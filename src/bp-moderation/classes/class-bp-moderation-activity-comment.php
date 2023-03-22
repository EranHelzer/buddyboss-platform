<?php
/**
 * BuddyBoss Moderation Activity Comment Classes
 *
 * @since   BuddyBoss 1.5.6
 * @package BuddyBoss\Moderation
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Database interaction class for the BuddyBoss moderation Activity Comment.
 *
 * @since BuddyBoss 1.5.6
 */
class BP_Moderation_Activity_Comment extends BP_Moderation_Abstract {

	/**
	 * Item type
	 *
	 * @var string
	 */
	public static $moderation_type = 'activity_comment';

	/**
	 * BP_Moderation_Activity_Comment constructor.
	 *
	 * @since BuddyBoss 1.5.6
	 */
	public function __construct() {

		parent::$moderation[ self::$moderation_type ] = self::class;
		$this->item_type                              = self::$moderation_type;

		add_filter( 'bp_moderation_content_types', array( $this, 'add_content_types' ) );

		/**
		 * Moderation code should not add for WordPress backend or IF Bypass argument passed for admin
		 */
		if ( ( is_admin() && ! wp_doing_ajax() ) || self::admin_bypass_check() ) {
			return;
		}

		/**
		 * If moderation setting enabled for this content then it'll filter hidden content.
		 * And IF moderation setting enabled for member then it'll filter blocked user content.
		 */
		add_filter( 'bp_suspend_activity_comment_get_where_conditions', array( $this, 'update_where_sql' ), 10, 2 );
		add_filter( 'bp_locate_template_names', array( $this, 'locate_blocked_template' ) );

		add_filter( 'bp_activity_comment_content', array( $this, 'bb_activity_comment_remove_mention_link' ), 10, 1 );

		// Code after below condition should not execute if moderation setting for this content disabled.
		if ( ! bp_is_moderation_content_reporting_enable( 0, self::$moderation_type ) ) {
			return;
		}

		// Update report button.
		add_filter( "bp_moderation_{$this->item_type}_button_sub_items", array( $this, 'update_button_sub_items' ) );

		// Validate item before proceed.
		add_filter( "bp_moderation_{$this->item_type}_validate", array( $this, 'validate_single_item' ), 10, 2 );

		// Report button text.
		add_filter( "bb_moderation_{$this->item_type}_report_button_text", array( $this, 'report_button_text' ), 10, 2 );
		add_filter( "bb_moderation_{$this->item_type}_reported_button_text", array( $this, 'report_button_text' ), 10, 2 );

		// Report popup content type.
		add_filter( "bp_moderation_{$this->item_type}_report_content_type", array( $this, 'report_content_type' ), 10, 2 );

		add_filter( 'bp_activity_comment_content', array( $this, 'bb_blocked_get_activity_comment' ), 10, 2 );

		add_filter( 'bp_activity_can_comment_reply', array( $this, 'bb_blocked_activity_can_comment_reply' ), 10, 2 );
	}

	/**
	 * Get permalink
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param int $activity_id activity id.
	 *
	 * @return string
	 */
	public static function get_permalink( $activity_id ) {
		$url = bp_activity_get_permalink( $activity_id );

		return add_query_arg( array( 'modbypass' => 1 ), $url );
	}

	/**
	 * Get Content owner id.
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param integer $activity_id Activity id.
	 *
	 * @return int
	 */
	public static function get_content_owner_id( $activity_id ) {
		$activity = new BP_Activity_Activity( $activity_id );

		return ( ! empty( $activity->user_id ) ) ? $activity->user_id : 0;
	}

	/**
	 * Add Moderation content type.
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param array $content_types Supported Contents types.
	 *
	 * @return mixed
	 */
	public function add_content_types( $content_types ) {
		$content_types[ self::$moderation_type ] = __( 'Activity Comments', 'buddyboss' );

		return $content_types;
	}

	/**
	 * Update where query Remove hidden/blocked user's Activities
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param string $where   Activity Where sql.
	 * @param object $suspend suspend object.
	 *
	 * @return array
	 */
	public function update_where_sql( $where, $suspend ) {
		$this->alias = $suspend->alias;

		$sql = $this->exclude_where_query();
		if ( ! empty( $sql ) ) {
			$where['moderation_where'] = $sql;
		}

		return $where;
	}

	/**
	 * Update blocked comment template
	 *
	 * @since BuddyBoss 1.5.6
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

		if (
			(
				$this->is_content_hidden( $activities_template->activity->current_comment->id ) ||
				bb_moderation_is_user_blocked_by( $activities_template->activity->current_comment->user_id )
			) &&
			(
				! bb_is_group_activity_comment( $activities_template->activity->current_comment ) ||
				(
					bb_is_group_activity_comment( $activities_template->activity->current_comment ) &&
					bp_moderation_is_content_hidden( $activities_template->activity->current_comment->id, self::$moderation_type )
				)
			)
		) {
			return 'activity/blocked-comment.php';
		}

		return $template_names;
	}

	/**
	 * Function to modify button sub item
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param int $comment_id Comment id.
	 *
	 * @return array
	 */
	public function update_button_sub_items( $comment_id ) {
		$comment = new BP_Activity_Activity( $comment_id );

		if ( empty( $comment->id ) ) {
			return array();
		}

		$sub_items = array();
		$activity  = new BP_Activity_Activity( $comment->item_id );
		if ( ! empty( $activity->id ) && 'blogs' === $activity->component ) {
			$post_type = get_post_type( $activity->secondary_item_id );
			if ( ! empty( $post_type ) && 'post' === $post_type ) {
				$post_comment_id = bp_activity_get_meta( $comment->id, "bp_blogs_{$post_type}_comment_id", true );

				if ( ! empty( $post_comment_id ) ) {
					$sub_items['id']   = $post_comment_id;
					$sub_items['type'] = BP_Moderation_Comment::$moderation_type;
				}
			}
		}

		return $sub_items;
	}

	/**
	 * Filter to check the activity is valid or not.
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @param bool   $retval  Check item is valid or not.
	 * @param string $item_id item id.
	 *
	 * @return bool
	 */
	public function validate_single_item( $retval, $item_id ) {
		if ( empty( $item_id ) ) {
			return $retval;
		}

		$activity = new BP_Activity_Activity( (int) $item_id );

		if ( empty( $activity ) || empty( $activity->id ) ) {
			return false;
		}

		return $retval;
	}

	/**
	 * Check content is hidden or not.
	 *
	 * @since BuddyBoss 1.5.6
	 *
	 * @return bool
	 */
	protected function is_content_hidden( $item_id ) {

		$author_id = self::get_content_owner_id( $item_id );

		if ( ( $this->is_member_blocking_enabled() && ! empty( $author_id ) && ! bp_moderation_is_user_suspended( $author_id ) && bp_moderation_is_user_blocked( $author_id ) ) ||
			 ( $this->is_reporting_enabled() && BP_Core_Suspend::check_hidden_content( $item_id, $this->item_type ) ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Function to change report button text.
	 *
	 * @since BuddyBoss 1.7.3
	 *
	 * @param string $button_text Button text.
	 * @param int    $item_id     Item id.
	 *
	 * @return string
	 */
	public function report_button_text( $button_text, $item_id ) {

		$comment = new BP_Activity_Activity( $item_id );

		if ( empty( $comment->id ) ) {
			return $button_text;
		}

		$button_text = esc_html__( 'Report Comment', 'buddyboss' );

		return $button_text;
	}

	/**
	 * Function to change report type.
	 *
	 * @since BuddyBoss 1.7.3
	 *
	 * @param string $content_type Button text.
	 * @param int    $item_id      Item id.
	 *
	 * @return string
	 */
	public function report_content_type( $content_type, $item_id ) {
		$comment = new BP_Activity_Activity( $item_id );

		if ( empty( $comment->id ) ) {
			return $content_type;
		}

		$content_type = esc_html__( 'Comment', 'buddyboss' );

		return $content_type;
	}

	/**
	 * Remove mentioned link from activity comment.
	 *
	 * @since BuddyBoss 2.2.7
	 *
	 * @param string $content Activity comment.
	 *
	 * @return string
	 */
	public function bb_activity_comment_remove_mention_link( $content ) {
		if ( empty( $content ) ) {
			return $content;
		}

		$content = bb_moderation_remove_mention_link( $content );

		return $content;
	}

	/**
	 * Update activity comment text for blocked comment.
	 *
	 * @since BuddyBoss [BBVERSION]
	 *
	 * @param string $content The content of the current activity comment.
	 * @param string $context This filter's context ("get").
	 *
	 * @return mixed|string
	 */
	public function bb_blocked_get_activity_comment( $content, $context ) {
		global $activities_template;

		if (
			empty( $activities_template->activity->current_comment->id ) ||
			empty( $activities_template->activity->current_comment->user_id )
		) {
			return $content;
		}

		$user_id = $activities_template->activity->current_comment->user_id;
		$item_id = $activities_template->activity->current_comment->id;

		// Set content for reported content of group.
		if ( bb_is_group_activity_comment( $activities_template->activity->current_comment ) ) {
			if (
				$this->is_content_hidden( $item_id ) &&
				! bp_moderation_is_user_blocked( $user_id )
			) {
				$content = esc_html__( 'This content has been hidden from site admin.', 'buddyboss' );
			}

			return $content;
		}

		if ( $this->is_content_hidden( $item_id ) ) {
			$is_user_blocked = bp_moderation_is_user_blocked( $user_id );

			if ( $is_user_blocked ) {
				$content = bb_moderation_has_blocked_message( $content, $this->item_type, $item_id );
			} else {
				$content = esc_html__( 'This content has been hidden from site admin.', 'buddyboss' );
			}
		} elseif ( bp_moderation_is_user_suspended( $user_id ) ) {
			$content = bb_moderation_is_suspended_message( $content, $this->item_type, $item_id );
		} elseif ( bb_moderation_is_user_blocked_by( $user_id ) ) {
			$content = bb_moderation_is_blocked_message( $content, $this->item_type, $item_id );
		}

		return $content;
	}

	/**
	 * Check the current comment author is has blocked or not.
	 *
	 * @since BuddyPress [BBVERSION]
	 *
	 * @param bool   $can_comment Status on if activity reply can be commented on.
	 * @param object $comment     Current comment object being checked on.
	 */
	public function bb_blocked_activity_can_comment_reply( $can_comment, $comment ) {
		if ( bp_is_active( 'groups' ) && ! empty( $comment->item_id ) && ! empty( $comment->user_id ) ) {
			if (
				! bb_is_group_activity_comment( $comment ) &&
				bb_moderation_is_user_blocked_by( $comment->user_id )
			) {
				return false;
				// Check it for reported group activity comments.
			} elseif (
				$this->is_content_hidden( $comment->id ) &&
				! bp_moderation_is_user_blocked( $comment->user_id )
			) {
				return false;
			}
		}

		return $can_comment;
	}
}
