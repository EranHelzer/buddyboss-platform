<?php
/**
 * The template for activity feed blocked comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * This template can be overridden by copying it to yourtheme/buddypress/activity/blocked-comment.php.
 *
 * @since   BuddyBoss 1.5.6
 * @version 1.5.6
 */

global $activities_template;
$is_user_blocked    = false;
$is_user_suspended  = false;
$is_user_blocked_by = false;

if ( bp_is_active( 'moderation' ) ) {
	$is_user_suspended  = function_exists( 'bp_moderation_is_user_suspended' ) && bp_moderation_is_user_suspended( bp_get_activity_comment_user_id() );
	$is_user_blocked    = function_exists( 'bp_moderation_is_user_blocked' ) && bp_moderation_is_user_blocked( bp_get_activity_comment_user_id() );
	$is_user_blocked_by = function_exists( 'bb_moderation_is_user_blocked_by' ) && bb_moderation_is_user_blocked_by( bp_get_activity_comment_user_id() );
}
?>

<li id="acomment-<?php bp_activity_comment_id(); ?>" class="<?php bp_activity_comment_css_class(); ?> suspended-comment-item"
	data-bp-activity-comment-id="<?php bp_activity_comment_id(); ?>">

	<div class="acomment-avatar item-avatar">
		<a href="<?php bp_activity_comment_user_link(); ?>">
			<?php
			bp_activity_avatar(
				array(
					'type'    => 'thumb',
					'user_id' => bp_get_activity_comment_user_id(),
				)
			);
			?>
		</a>
	</div>

	<div class="acomment-meta">
		<?php bp_nouveau_activity_comment_action(); ?>
	</div>

	<div class="acomment-content">
		<?php
		$activity_comment_content = '';
		if ( $is_user_suspended ) {
			$activity_comment_content = bb_moderation_is_suspended_message( bp_get_activity_comment_content(), BP_Moderation_Activity_Comment::$moderation_type, bp_get_activity_comment_user_id() );
		} elseif ( $is_user_blocked_by ) {
			$activity_comment_content = bb_moderation_is_blocked_message( bp_get_activity_comment_content(), BP_Moderation_Activity_Comment::$moderation_type, bp_get_activity_comment_user_id() );
		} elseif ( $is_user_blocked && ! bb_is_group_activity_comment( $activities_template->activity->current_comment ) ) {
			$activity_comment_content = bb_moderation_has_blocked_message( bp_get_activity_comment_content(), BP_Moderation_Activity_Comment::$moderation_type, bp_get_activity_comment_user_id() );
		} else {
			$activity_comment_content = esc_html__( 'This content has been hidden from site admin.', 'buddyboss' );
		}

		echo $activity_comment_content; // phpcs:ignore
		?>
	</div>
	<?php bp_nouveau_activity_recurse_comments( bp_activity_current_comment() ); ?>
</li>
