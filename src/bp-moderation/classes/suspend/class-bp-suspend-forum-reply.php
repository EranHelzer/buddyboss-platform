<?php
/**
 * BuddyBoss Suspend Forum Reply Classes
 *
 * @since   BuddyBoss 2.0.0
 * @package BuddyBoss\Suspend
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Database interaction class for the BuddyBoss Suspend Forum Reply.
 *
 * @since BuddyBoss 2.0.0
 */
class BP_Suspend_Forum_Reply extends BP_Suspend_Abstract {

	/**
	 * Item type
	 *
	 * @var string
	 */
	public static $type = 'forum_reply';

	/**
	 * BP_Suspend_Forum_Reply constructor.
	 *
	 * @since BuddyBoss 2.0.0
	 */
	public function __construct() {

		$this->item_type = self::$type;

		//Manage hidden list
		add_action( "bp_suspend_hide_{$this->item_type}", array( $this, 'manage_hidden_reply' ), 10, 3 );
		add_action( "bp_suspend_unhide_{$this->item_type}", array( $this, 'manage_unhidden_reply' ), 10, 4 );

		/**
		 * Suspend code should not add for WordPress backend or IF component is not active or Bypass argument passed for admin
		 */
		if ( ( is_admin() && ! wp_doing_ajax() ) || self::admin_bypass_check() ) {
			return;
		}

		$this->alias = $this->alias . 'fr'; // fr = Forum Reply.

		add_filter( 'posts_join', array( $this, 'update_join_sql' ), 10, 2 );
		add_filter( 'posts_where', array( $this, 'update_where_sql' ), 10, 2 );

		add_filter( 'bp_forum_reply_search_join_sql', array( $this, 'update_join_sql' ), 10 );
		add_filter( 'bp_forum_reply_search_where_sql', array( $this, 'update_where_sql' ), 10, 2 );

		// Blocked template
		add_filter( 'bbp_locate_template_names', array( $this, 'locate_blocked_template' ) );
	}

	/**
	 * Get Blocked member's reply ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return array
	 */
	public static function get_member_reply_ids( $member_id ) {
		$reply_ids = array();

		$reply_query = new WP_Query(
			array(
				'fields'                 => 'ids',
				'post_type'              => bbp_get_reply_post_type(),
				'post_status'            => 'publish',
				'author'                 => $member_id,
				'posts_per_page'         => - 1,
				// Need to get all topics id of hidden forums.
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'suppress_filters'       => true,
			)
		);

		if ( $reply_query->have_posts() ) {
			$reply_ids = $reply_query->posts;
		}

		return $reply_ids;
	}

	/**
	 * Get forum topics ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return array
	 */
	public static function get_topic_replies( $topic_id ) {
		$reply_ids = array();

		$reply_query = new WP_Query(
			array(
				'fields'                 => 'ids',
				'post_type'              => bbp_get_reply_post_type(),
				'post_status'            => 'publish',
				'post_parent'            => $topic_id,
				'posts_per_page'         => - 1,
				// Need to get all topics id of hidden forums.
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'suppress_filters'       => true,
			)
		);

		if ( $reply_query->have_posts() ) {
			$reply_ids = $reply_query->posts;
		}

		return $reply_ids;
	}

	/**
	 * Prepare forum reply Join SQL query to filter blocked Forum Reply
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param string $join_sql Forum Reply Join sql.
	 * @param object $wp_query WP_Query object.
	 *
	 * @return string Join sql
	 */
	public function update_join_sql( $join_sql, $wp_query = null ) {
		global $wpdb;

		$action_name = current_filter();

		if ( 'bp_forum_reply_search_join_sql' === $action_name ) {
			$join_sql .= $this->exclude_joint_query( 'p.ID' );

			/**
			 * Filters the hidden Forum Reply Where SQL statement.
			 *
			 * @since BuddyBoss 2.0.0
			 *
			 * @param array $join_sql Join sql query
			 * @param array $class    current class object.
			 */
			$join_sql = apply_filters( 'bp_suspend_forum_reply_get_join', $join_sql, $this );

		} else {
			$reply_slug = bbp_get_reply_post_type();
			$post_types = wp_parse_slug_list( $wp_query->get( 'post_type' ) );
			if ( false === $wp_query->get( 'moderation_query' ) || ! empty( $post_types ) && in_array( $reply_slug, $post_types, true ) ) {
				$join_sql .= $this->exclude_joint_query( "{$wpdb->posts}.ID" );

				/**
				 * Filters the hidden Forum Reply Where SQL statement.
				 *
				 * @since BuddyBoss 2.0.0
				 *
				 * @param array $join_sql Join sql query
				 * @param array $class    current class object.
				 */
				$join_sql = apply_filters( 'bp_suspend_forum_reply_get_join', $join_sql, $this );
			}
		}

		return $join_sql;
	}

	/**
	 * Prepare forum reply Where SQL query to filter blocked Forum Reply
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param array       $where_conditions Forum Reply Where sql.
	 * @param object|null $wp_query         WP_Query object.
	 *
	 * @return mixed Where SQL
	 */
	public function update_where_sql( $where_conditions, $wp_query = null ) {

		$action_name = current_filter();

		if ( 'bp_forum_reply_search_where_sql' !== $action_name ) {
			$reply_slug = bbp_get_reply_post_type();
			$post_types = wp_parse_slug_list( $wp_query->get( 'post_type' ) );
			if ( false === $wp_query->get( 'moderation_query' ) || empty( $post_types ) || ! in_array( $reply_slug, $post_types, true ) ) {
				return $where_conditions;
			}
		}

		$where                  = array();
		$where['suspend_where'] = $this->exclude_where_query();

		/**
		 * Filters the hidden forum reply Where SQL statement.
		 *
		 * @since BuddyBoss 2.0.0
		 *
		 * @param array $where Query to hide suspended user's forum reply.
		 * @param array $class current class object.
		 */
		$where = apply_filters( 'bp_suspend_forum_reply_get_where_conditions', $where, $this );

		if ( ! empty( array_filter( $where ) ) ) {
			if ( 'bp_forum_reply_search_join_sql' === $action_name ) {
				$where_conditions['suspend_where'] = '( ' . implode( ' AND ', $where ) . ' )';
			} else {
				$where_conditions .= ' AND ( ' . implode( ' AND ', $where ) . ' )';
			}
		}

		return $where_conditions;
	}

	/**
	 * Hide related content of forum reply
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int      $reply_id      forum reply id
	 * @param int|null $hide_sitewide item hidden sitewide or user specific
	 * @param array    $args          parent args
	 */
	public function manage_hidden_reply( $reply_id, $hide_sitewide, $args = array() ) {
		$suspend_args = wp_parse_args( $args, array(
			'item_id'   => $reply_id,
			'item_type' => BP_Suspend_Forum_Reply::$type,
		) );

		if ( ! is_null( $hide_sitewide ) ) {
			$suspend_args['hide_sitewide'] = $hide_sitewide;
		}

		BP_Core_Suspend::add_suspend( $suspend_args );
		$this->hide_related_content( $reply_id, $hide_sitewide, $args );
	}

	/**
	 * Un-hide related content of reply
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int      $reply_id      reply id
	 * @param int|null $hide_sitewide item hidden sitewide or user specific
	 * @param int      $force_all     un-hide for all users
	 * @param array    $args          parent args
	 */
	public function manage_unhidden_reply( $reply_id, $hide_sitewide, $force_all, $args = array() ) {
		$suspend_args = wp_parse_args( $args, array(
			'item_id'   => $reply_id,
			'item_type' => BP_Suspend_Forum_Reply::$type,
		) );

		if ( ! is_null( $hide_sitewide ) ) {
			$suspend_args['hide_sitewide'] = $hide_sitewide;
		}

		BP_Core_Suspend::remove_suspend( $suspend_args );
		$this->unhide_related_content( $reply_id, $hide_sitewide, $force_all, $args );
	}

	/**
	 * Update blocked comment template
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param string $template_names Template name.
	 *
	 * @return string
	 */
	public function locate_blocked_template( $template_names ) {

		if ( 'loop-single-reply.php' !== $template_names ) {
			if ( ! is_array( $template_names ) || ! in_array( 'loop-single-reply.php', $template_names, true ) ) {
				return $template_names;
			}
		}

		$reply_id = bbp_get_reply_id();

		if ( BP_Core_Suspend::check_suspended_content( $reply_id, self::$type ) ) {
			return 'loop-blocked-single-reply.php';
		}

		return $template_names;
	}

	/**
	 * Get Activity's comment ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $reply_id reply id
	 *
	 * @return array
	 */
	protected function get_related_contents( $reply_id ) {
		$related_contents = array();

		if ( bp_is_active( 'activity' ) ) {
			$related_contents[ BP_Suspend_Activity::$type ] = BP_Suspend_Activity::get_bbpress_activity_ids( $reply_id );
		}

		if ( bp_is_active( 'document' ) ) {
			$related_contents[ BP_Suspend_Document::$type ] = BP_Suspend_Document::get_document_ids_meta( $reply_id );
		}

		if ( bp_is_active( 'media' ) ) {
			$related_contents[ BP_Suspend_Media::$type ] = BP_Suspend_Media::get_media_ids_meta( $reply_id );
		}

		return $related_contents;
	}
}
