<?php
/**
 * BuddyBoss Suspend Activity Classes
 *
 * @since   BuddyBoss 2.0.0
 * @package BuddyBoss\Suspend
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Database interaction class for the BuddyBoss Suspend Activity comment.
 *
 * @since BuddyBoss 2.0.0
 */
class BP_Suspend_Activity_Comment extends BP_Suspend_Abstract {

	/**
	 * Item type
	 *
	 * @var string
	 */
	public static $type = 'activity_comment';

	/**
	 * BP_Moderation_Activity constructor.
	 *
	 * @since BuddyBoss 2.0.0
	 */
	public function __construct() {

		$this->item_type = self::$type;

		//Manage hidden list
		add_action( "bp_suspend_hide_{$this->item_type}", array( $this, 'manage_hidden_activity_comment' ), 10, 3 );
		add_action( "bp_suspend_unhide_{$this->item_type}", array( $this, 'manage_unhidden_activity_comment' ), 10, 4 );

		/**
		 * Suspend code should not add for WordPress backend or IF component is not active or Bypass argument passed for admin
		 */
		if ( ( is_admin() && ! wp_doing_ajax() ) || self::admin_bypass_check() ) {
			return;
		}

		add_filter( 'bp_activity_comments_search_join_sql', array( $this, 'update_join_sql' ), 10, 2 );
		add_filter( 'bp_activity_comments_search_where_conditions', array( $this, 'update_where_sql' ), 10, 2 );

		add_filter( 'bp_locate_template_names', array( $this, 'locate_blocked_template' ) );
	}

	/**
	 * Get Blocked member's activity ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $member_id member id.
	 *
	 * @return array
	 */
	public static function get_member_activity_comment_ids( $member_id ) {
		$activities_ids = array();

		$activities = BP_Activity_Activity::get( array(
			'moderation_query' => false,
			'per_page'         => 0,
			'fields'           => 'ids',
			'show_hidden'      => true,
			'display_comments' => true,
			'filter'           => array(
				'user_id' => $member_id,
				'action'  => 'activity_comment',
			),
		) );

		if ( ! empty( $activities['activities'] ) ) {
			$activities_ids = $activities['activities'];
		}

		return $activities_ids;
	}

	/**
	 * Prepare activity Join SQL query to filter blocked Activity
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param string $join_sql Activity Join sql.
	 * @param array  $args     Query arguments.
	 *
	 * @return string Join sql
	 */
	public function update_join_sql( $join_sql, $args = array() ) {

		if ( isset( $args['moderation_query'] ) && false === $args['moderation_query'] ) {
			return $join_sql;
		}

		$join_sql .= $this->exclude_joint_query( 'a.id' );

		/**
		 * Filters the hidden activity Where SQL statement.
		 *
		 * @since BuddyBoss 2.0.0
		 *
		 * @param array $join_sql Join sql query
		 * @param array $class    current class object.
		 */
		$join_sql = apply_filters( 'bp_suspend_activity_comment_get_join', $join_sql, $this );

		return $join_sql;
	}

	/**
	 * Prepare activity comment Where SQL query to filter blocked Activity
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param array $where_conditions Activity Where sql.
	 * @param array $args             Query arguments.
	 *
	 * @return mixed Where SQL
	 */
	public function update_where_sql( $where_conditions, $args = array() ) {
		if ( isset( $args['moderation_query'] ) && false === $args['moderation_query'] ) {
			return $where_conditions;
		}

		$where                  = array();
		$where['suspend_where'] = $this->exclude_where_query();

		/**
		 * Filters the hidden activity comment Where SQL statement.
		 *
		 * @since BuddyBoss 2.0.0
		 *
		 * @param array $where Query to hide suspended user's activity comment.
		 * @param array $class current class object.
		 */
		$where = apply_filters( 'bp_suspend_activity_comment_get_where_conditions', $where, $this );

		if ( ! empty( array_filter( $where ) ) ) {
			$where_conditions['suspend_where'] = '( ' . implode( ' AND ', $where ) . ' )';
		}

		return $where_conditions;
	}

	/**
	 * Hide related content of activity comment
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int      $acomment_id   activity comment id
	 * @param int|null $hide_sitewide item hidden sitewide or user specific
	 * @param array    $args          parent args
	 */
	public function manage_hidden_activity_comment( $acomment_id, $hide_sitewide, $args = array() ) {
		$suspend_args = wp_parse_args( $args, array(
			'item_id'   => $acomment_id,
			'item_type' => BP_Suspend_Activity_Comment::$type,
		) );

		if ( ! is_null( $hide_sitewide ) ) {
			$suspend_args['hide_sitewide'] = $hide_sitewide;
		}

		BP_Core_Suspend::add_suspend( $suspend_args );
		$this->hide_related_content( $acomment_id, $hide_sitewide, $args );
	}

	/**
	 * Un-hide related content of activity
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int      $acomment_id   activity comment id
	 * @param int|null $hide_sitewide item hidden sitewide or user specific
	 * @param int      $force_all     un-hide for all users
	 * @param array    $args          parent args
	 */
	public function manage_unhidden_activity_comment( $acomment_id, $hide_sitewide, $force_all, $args = array() ) {
		$suspend_args = wp_parse_args( $args, array(
			'item_id'   => $acomment_id,
			'item_type' => BP_Suspend_Activity_Comment::$type,
		) );

		if ( ! is_null( $hide_sitewide ) ) {
			$suspend_args['hide_sitewide'] = $hide_sitewide;
		}

		BP_Core_Suspend::remove_suspend( $suspend_args );
		$this->unhide_related_content( $acomment_id, $hide_sitewide, $force_all, $args );
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
		global $activities_template;

		if ( 'activity/comment.php' !== $template_names ) {
			if ( ! is_array( $template_names ) || ! in_array( 'activity/comment.php', $template_names, true ) ) {
				return $template_names;
			}
		}

		if ( BP_Core_Suspend::check_suspended_content( $activities_template->activity->current_comment->id, self::$type ) ) {
			return 'activity/blocked-comment.php';
		}

		return $template_names;
	}

	/**
	 * Get Activity's comment ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $acomment_id activity comment id
	 *
	 * @return array
	 */
	protected function get_related_contents( $acomment_id ) {

		$related_contents = array(
			self::$type => self::get_activity_comment_ids( $acomment_id ),
		);

		return $related_contents;
	}

	/**
	 * Get Blocked activity's comment ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $activity_id Activity id.
	 *
	 * @return array
	 */
	public static function get_activity_comment_ids( $activity_id ) {

		$comments_ids = array();

		$activity_comments = BP_Activity_Activity::get_child_comments( $activity_id );

		if ( ! empty( $activity_comments ) ) {
			$comments_ids = wp_list_pluck( $activity_comments, 'id' );
		}

		if ( bp_is_active( 'document' ) ) {
			$related_contents[ BP_Suspend_Document::$type ] = BP_Suspend_Document::get_document_ids_meta( $activity_id, 'bp_activity_get_meta' );
		}

		if ( bp_is_active( 'media' ) ) {
			$related_contents[ BP_Suspend_Media::$type ] = BP_Suspend_Media::get_media_ids_meta( $activity_id, 'bp_activity_get_meta' );
		}

		return $comments_ids;
	}
}
