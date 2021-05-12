<?php
/**
 * Filters related to the Activity Feeds component.
 *
 * @package BuddyBoss\Activity
 * @since   BuddyPress 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/* Filters *******************************************************************/

// Apply WordPress defined filters.
add_filter( 'bp_get_activity_action', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_content_body', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_content', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_parent_content', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_latest_update', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_latest_update_excerpt', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_feed_item_description', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_activity_content_before_save', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_activity_action_before_save', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_activity_latest_update_content', 'bp_activity_filter_kses', 1 );
add_filter( 'bp_get_activity_action', 'force_balance_tags' );
add_filter( 'bp_get_activity_content_body', 'force_balance_tags' );
add_filter( 'bp_get_activity_content', 'force_balance_tags' );
add_filter( 'bp_get_activity_latest_update', 'force_balance_tags' );
add_filter( 'bp_get_activity_latest_update_excerpt', 'force_balance_tags' );
add_filter( 'bp_get_activity_feed_item_description', 'force_balance_tags' );
add_filter( 'bp_activity_content_before_save', 'force_balance_tags' );
add_filter( 'bp_activity_action_before_save', 'force_balance_tags' );
if ( function_exists( 'wp_encode_emoji' ) ) {
	add_filter( 'bp_activity_content_before_save', 'wp_encode_emoji' );
}
add_filter( 'bp_activity_mentioned_users', 'bp_find_mentions_by_at_sign', 10, 2 );
add_filter( 'bp_get_activity_action', 'wptexturize' );
add_filter( 'bp_get_activity_content_body', 'wptexturize' );
add_filter( 'bp_get_activity_content', 'wptexturize' );
add_filter( 'bp_get_activity_parent_content', 'wptexturize' );
add_filter( 'bp_get_activity_latest_update', 'wptexturize' );
add_filter( 'bp_get_activity_latest_update_excerpt', 'wptexturize' );
add_filter( 'bp_activity_get_embed_excerpt', 'wptexturize' );
add_filter( 'bp_get_activity_action', 'convert_smilies' );
add_filter( 'bp_get_activity_content_body', 'convert_smilies' );
add_filter( 'bp_get_activity_content', 'convert_smilies' );
add_filter( 'bp_get_activity_parent_content', 'convert_smilies' );
add_filter( 'bp_get_activity_latest_update', 'convert_smilies' );
add_filter( 'bp_get_activity_latest_update_excerpt', 'convert_smilies' );
add_filter( 'bp_activity_get_embed_excerpt', 'convert_smilies' );
add_filter( 'bp_get_activity_action', 'convert_chars' );
add_filter( 'bp_get_activity_content_body', 'convert_chars' );
add_filter( 'bp_get_activity_content', 'convert_chars' );
add_filter( 'bp_get_activity_parent_content', 'convert_chars' );
add_filter( 'bp_get_activity_latest_update', 'convert_chars' );
add_filter( 'bp_get_activity_latest_update_excerpt', 'convert_chars' );
add_filter( 'bp_activity_get_embed_excerpt', 'convert_chars' );
add_filter( 'bp_get_activity_action', 'wpautop' );
add_filter( 'bp_get_activity_content_body', 'wpautop' );
add_filter( 'bp_get_activity_content', 'wpautop' );
add_filter( 'bp_get_activity_feed_item_description', 'wpautop' );
add_filter( 'bp_activity_get_embed_excerpt', 'wpautop' );
add_filter( 'bp_get_activity_action', 'make_clickable', 9 );
add_filter( 'bp_get_activity_content_body', 'make_clickable', 9 );
add_filter( 'bp_get_activity_content', 'make_clickable', 9 );
add_filter( 'bp_get_activity_parent_content', 'make_clickable', 9 );
add_filter( 'bp_get_activity_latest_update', 'make_clickable', 9 );
add_filter( 'bp_get_activity_latest_update_excerpt', 'make_clickable', 9 );
add_filter( 'bp_get_activity_feed_item_description', 'make_clickable', 9 );
add_filter( 'bp_activity_get_embed_excerpt', 'make_clickable', 9 );
add_filter( 'bp_acomment_name', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_action', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_content', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_content_body', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_parent_content', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_latest_update', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_latest_update_excerpt', 'stripslashes_deep', 5 );
add_filter( 'bp_get_activity_feed_item_description', 'stripslashes_deep', 5 );
add_filter( 'bp_activity_primary_link_before_save', 'esc_url_raw' );
// Apply BuddyPress-defined filters.
add_filter( 'bp_get_activity_content', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_get_activity_content_body', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_get_activity_parent_content', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_get_activity_latest_update', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_get_activity_latest_update_excerpt', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_get_activity_feed_item_description', 'bp_activity_make_nofollow_filter' );
add_filter( 'bp_activity_new_at_mention_permalink', 'bp_activity_new_at_mention_permalink', 11, 3 );
add_filter( 'pre_comment_content', 'bp_activity_at_name_filter' );
add_filter( 'the_content', 'bp_activity_at_name_filter' );
add_filter( 'bp_activity_get_embed_excerpt', 'bp_activity_at_name_filter' );
add_filter( 'bp_get_activity_parent_content', 'bp_create_excerpt' );
add_filter( 'bp_get_activity_content_body', 'bp_activity_truncate_entry', 5 );
add_filter( 'bp_get_activity_content', 'bp_activity_truncate_entry', 5 );
add_filter( 'bp_get_total_favorite_count_for_user', 'bp_core_number_format' );
add_filter( 'bp_get_total_mention_count_for_user', 'bp_core_number_format' );
add_filter( 'bp_activity_get_embed_excerpt', 'bp_activity_embed_excerpt_onclick_location_filter', 9 );
// add_filter( 'bp_after_has_activities_parse_args', 'bp_activity_display_all_types_on_just_me' );
add_filter( 'bp_get_activity_content_body', 'bp_activity_link_preview', 20, 2 );
add_action( 'bp_has_activities', 'bp_activity_has_activity_filter', 10, 2 );
add_action( 'bp_has_activities', 'bp_activity_has_media_activity_filter', 10, 2 );
/*
 Actions *******************************************************************/
// At-name filter.
add_action( 'bp_activity_before_save', 'bp_activity_at_name_filter_updates' );
// Activity feed moderation.
add_action( 'bp_activity_before_save', 'bp_activity_check_moderation_keys', 2, 1 );
add_action( 'bp_activity_before_save', 'bp_activity_check_blacklist_keys', 2, 1 );
// Activity link preview
add_action( 'bp_activity_after_save', 'bp_activity_save_link_data', 2, 1 );
add_action( 'bp_activity_after_save', 'bp_activity_update_comment_privacy', 3 );
// Remove Activity if uncheck the options from the backend BuddyBoss > Settings > Activity > Posts in Activity Feed >BuddyBoss Platform
add_action( 'bp_activity_before_save', 'bp_activity_remove_platform_updates', 999, 1 );
add_action( 'bp_media_add', 'bp_activity_media_add', 9 );
add_filter( 'bp_media_add_handler', 'bp_activity_create_parent_media_activity', 9 );
add_filter( 'bp_media_add_handler', 'bp_activity_edit_update_media', 10 );
add_action( 'bp_document_add', 'bp_activity_document_add', 9 );
add_filter( 'bp_document_add_handler', 'bp_activity_create_parent_document_activity', 9 );
add_filter( 'bp_document_add_handler', 'bp_activity_edit_update_document', 10 );
// Temporary filter to remove edit button on popup until we fully make compatible on edit everywhere in popup/reply/comment.
add_filter( 'bp_nouveau_get_activity_entry_buttons', 'bp_nouveau_remove_edit_activity_entry_buttons', 999, 2 );
add_filter( 'bp_repair_list', 'bb_activity_media_document_migration' );
/** Functions *****************************************************************/
/**
 * Types of activity feed items to moderate.
 *
 * @return array $types List of the activity types to moderate.
 * @since BuddyPress 1.6.0
 */
function bp_activity_get_moderated_activity_types() {
	$types = array(
		'activity_comment',
		'activity_update',
	);

	/**
	 * Filters the default activity types that BuddyPress should moderate.
	 *
	 * @param array $types Default activity types to moderate.
	 *
	 * @since BuddyPress 1.6.0
	 */
	return apply_filters( 'bp_activity_check_activity_types', $types );
}

/**
 * Moderate the posted activity item, if it contains moderate keywords.
 *
 * @param BP_Activity_Activity $activity The activity object to check.
 *
 * @since BuddyPress 1.6.0
 */
function bp_activity_check_moderation_keys( $activity ) {
	// Only check specific types of activity updates.
	if ( ! in_array( $activity->type, bp_activity_get_moderated_activity_types() ) ) {
		return;
	}
	// Send back the error so activity update fails.
	// @todo This is temporary until some kind of moderation is built.
	$moderate = bp_core_check_for_moderation( $activity->user_id, '', $activity->content, 'wp_error' );
	if ( is_wp_error( $moderate ) ) {
		$activity->errors = $moderate;
		// Backpat.
		$activity->component = false;
	}
}

/**
 * Mark the posted activity as spam, if it contains blacklist keywords.
 *
 * @param BP_Activity_Activity $activity The activity object to check.
 *
 * @since BuddyPress 1.6.0
 */
function bp_activity_check_blacklist_keys( $activity ) {
	// Only check specific types of activity updates.
	if ( ! in_array( $activity->type, bp_activity_get_moderated_activity_types() ) ) {
		return;
	}
	// Send back the error so activity update fails.
	// @todo This is temporary until some kind of trash status is built.
	$blacklist = bp_core_check_for_blacklist( $activity->user_id, '', $activity->content, 'wp_error' );
	if ( is_wp_error( $blacklist ) ) {
		$activity->errors = $blacklist;
		// Backpat.
		$activity->component = false;
	}
}

/**
 * Save link preview data into activity meta key "_link_preview_data"
 *
 * @param $activity
 *
 * @since BuddyBoss 1.0.0
 */
function bp_activity_save_link_data( $activity ) {
	$link_url   = ! empty( $_POST['link_url'] ) ? filter_var( $_POST['link_url'], FILTER_VALIDATE_URL ) : '';
	$link_embed = isset( $_POST['link_embed'] ) ? filter_var( $_POST['link_embed'], FILTER_VALIDATE_BOOLEAN ) : false;
	// Check if link url is set or not.
	if ( empty( $link_url ) ) {
		if ( false === $link_embed ) {
			bp_activity_update_meta( $activity->id, '_link_embed', '0' );
			// This will remove the preview data if the activity don't have anymore link in content.
			bp_activity_update_meta( $activity->id, '_link_preview_data', '' );
		}

		return;
	}
	// Return if link embed was used activity is in edit.
	if ( true === $link_embed && 'activity_comment' === $activity->type ) {
		return;
	}
	$link_title       = ! empty( $_POST['link_title'] ) ? filter_var( $_POST['link_title'] ) : '';
	$link_description = ! empty( $_POST['link_description'] ) ? filter_var( $_POST['link_description'] ) : '';
	$link_image       = ! empty( $_POST['link_image'] ) ? filter_var( $_POST['link_image'], FILTER_VALIDATE_URL ) : '';
	// Check if link embed was used.
	if ( true === $link_embed && ! empty( $link_url ) ) {
		bp_activity_update_meta( $activity->id, '_link_embed', $link_url );

		return;
	}
	$preview_data['url'] = $link_url;
	if ( ! empty( $link_image ) ) {
		$attachment_id = bp_activity_media_sideload_attachment( $link_image );
		if ( $attachment_id ) {
			$preview_data['attachment_id'] = $attachment_id;
		} else {
			// store non downloadable urls as it is in preview data.
			$preview_data['image_url'] = $link_image;
		}
	}
	if ( ! empty( $link_title ) ) {
		$preview_data['title'] = $link_title;
	}
	if ( ! empty( $link_description ) ) {
		$preview_data['description'] = $link_description;
	}
	bp_activity_update_meta( $activity->id, '_link_preview_data', $preview_data );
}

/**
 * Update activity comment privacy with parent activity privacy update.
 *
 * @param BP_Activity_Activity $activity Activity object
 *
 * @since BuddyBoss 1.4.0
 */
function bp_activity_update_comment_privacy( $activity ) {
	$activity_comments = bp_activity_get_specific(
		array(
			'activity_ids'     => array( $activity->id ),
			'display_comments' => true,
		)
	);
	if ( ! empty( $activity_comments ) && ! empty( $activity_comments['activities'] ) && isset( $activity_comments['activities'][0]->children ) ) {
		$children = $activity_comments['activities'][0]->children;
		if ( ! empty( $children ) ) {
			foreach ( $children as $comment ) {
				bp_activity_comment_privacy_update( $comment, $activity->privacy );
			}
		}
	}
}

/**
 * Recursive function to update privacy of comment with nested level.
 *
 * @param BP_Activity_Activity $comment Activity comment object
 * @param string               $privacy Parent Activity privacy
 *
 * @since BuddyBoss 1.4.0
 */
function bp_activity_comment_privacy_update( $comment, $privacy ) {
	$comment_activity          = new BP_Activity_Activity( $comment->id );
	$comment_activity->privacy = $privacy;
	$comment_activity->save();
	if ( ! empty( $comment->children ) ) {
		foreach ( $comment->children as $child_comment ) {
			bp_activity_comment_privacy_update( $child_comment, $privacy );
		}
	}
}

/**
 * Custom kses filtering for activity content.
 *
 * @param string $content The activity content.
 *
 * @return string $content Filtered activity content.
 * @since BuddyPress 1.1.0
 */
function bp_activity_filter_kses( $content ) {
	/**
	 * Filters the allowed HTML tags for BuddyBoss Activity content.
	 *
	 * @param array $value Array of allowed HTML tags and attributes.
	 *
	 * @since BuddyPress 1.2.0
	 */
	$activity_allowedtags = apply_filters( 'bp_activity_allowed_tags', bp_get_allowedtags() );

	return wp_kses( $content, $activity_allowedtags );
}

/**
 * Find and link @-mentioned users in the contents of a given item.
 *
 * @param string $content     The contents of a given item.
 * @param int    $activity_id The activity id. Deprecated.
 *
 * @return string $content Content filtered for mentions.
 * @since BuddyPress 1.2.0
 */
function bp_activity_at_name_filter( $content, $activity_id = 0 ) {
	// Are mentions disabled?
	if ( ! bp_activity_do_mentions() ) {
		return $content;
	}
	// Try to find mentions.
	$usernames = bp_activity_find_mentions( $content );
	// No mentions? Stop now!
	if ( empty( $usernames ) ) {
		return $content;
	}
	// We don't want to link @mentions that are inside of links, so we
	// temporarily remove them.
	$replace_count = 0;
	$replacements  = array();
	foreach ( $usernames as $username ) {
		// Prevent @ name linking inside <a> tags.
		preg_match_all( '/(<a.*?(?!<\/a>)@' . $username . '.*?<\/a>)/', $content, $content_matches );
		if ( ! empty( $content_matches[1] ) ) {
			foreach ( $content_matches[1] as $replacement ) {
				$replacements[ '#BPAN' . $replace_count ] = $replacement;
				$content                                  = str_replace( $replacement, '#BPAN' . $replace_count, $content );
				$replace_count ++;
			}
		}
	}
	// Linkify the mentions with the username.
	foreach ( (array) $usernames as $user_id => $username ) {
		$content = preg_replace( '/(@' . $username . '\b)/', "<a class='bp-suggestions-mention' href='" . bp_core_get_user_domain( $user_id ) . "' rel='nofollow'>@$username</a>", $content );
	}
	// Put everything back.
	if ( ! empty( $replacements ) ) {
		foreach ( $replacements as $placeholder => $original ) {
			$content = str_replace( $placeholder, $original, $content );
		}
	}

	// Return the content.
	return $content;
}

/**
 * Catch mentions in an activity item before it is saved into the database.
 *
 * If mentions are found, replace @mention text with user links and add our
 * hook to send mention notifications after the activity item is saved.
 *
 * @param BP_Activity_Activity $activity Activity Object.
 *
 * @since BuddyPress 1.5.0
 */
function bp_activity_at_name_filter_updates( $activity ) {
	// Are mentions disabled?
	if ( ! bp_activity_do_mentions() ) {
		return;
	}
	// If activity was marked as spam, stop the rest of this function.
	if ( ! empty( $activity->is_spam ) ) {
		return;
	}
	// Try to find mentions.
	$usernames = bp_activity_find_mentions( $activity->content );
	// We have mentions!
	if ( ! empty( $usernames ) ) {
		// Replace @mention text with userlinks.
		foreach ( (array) $usernames as $user_id => $username ) {
			$activity->content = preg_replace( '/(@' . $username . '\b)/', "<a class='bp-suggestions-mention' href='" . bp_core_get_user_domain( $user_id ) . "' rel='nofollow'>@$username</a>", $activity->content );
		}
		// Add our hook to send @mention emails after the activity item is saved.
		add_action( 'bp_activity_after_save', 'bp_activity_at_name_send_emails' );
		// Temporary variable to avoid having to run bp_activity_find_mentions() again.
		buddypress()->activity->mentioned_users = $usernames;
	}
}

/**
 * Sends emails and BP notifications for users @-mentioned in an activity item.
 *
 * @param BP_Activity_Activity $activity The BP_Activity_Activity object.
 *
 * @since BuddyPress 1.7.0
 */
function bp_activity_at_name_send_emails( $activity ) {
	// Are mentions disabled?
	if ( ! bp_activity_do_mentions() || ( ! empty( $activity->privacy ) && 'onlyme' === $activity->privacy ) ) {
		return;
	}
	// If our temporary variable doesn't exist, stop now.
	if ( empty( buddypress()->activity->mentioned_users ) ) {
		return;
	}
	// Grab our temporary variable from bp_activity_at_name_filter_updates().
	$usernames = buddypress()->activity->mentioned_users;
	// Get rid of temporary variable.
	unset( buddypress()->activity->mentioned_users );
	// Send @mentions and setup BP notifications.
	foreach ( (array) $usernames as $user_id => $username ) {
		/**
		 * Filters BuddyPress' ability to send email notifications for @mentions.
		 *
		 * @param bool                 $value     Whether or not BuddyPress should send a notification to the mentioned users.
		 * @param array                $usernames Array of users potentially notified.
		 * @param int                  $user_id   ID of the current user being notified.
		 * @param BP_Activity_Activity $activity  Activity object.
		 *
		 * @since BuddyPress 1.6.0
		 * @since BuddyPress 2.5.0 Introduced `$user_id` and `$activity` parameters.
		 */
		if ( apply_filters( 'bp_activity_at_name_do_notifications', true, $usernames, $user_id, $activity ) ) {
			bp_activity_at_message_notification( $activity->id, $user_id );
			// Updates mention count for the user.
			bp_activity_update_mention_count_for_user( $user_id, $activity->id );
		}
	}
}

/**
 * Catch links in activity text so rel=nofollow can be added.
 *
 * @param string $text Activity text.
 *
 * @return string $text Text with rel=nofollow added to any links.
 * @since BuddyPress 1.2.0
 */
function bp_activity_make_nofollow_filter( $text ) {
	return preg_replace_callback( '|<a (.+?)>|i', 'bp_activity_make_nofollow_filter_callback', $text );
}

/**
 * Add rel=nofollow to a link.
 *
 * @param array $matches Items matched by preg_replace_callback() in bp_activity_make_nofollow_filter().
 *
 * @return string $text Link with rel=nofollow added.
 * @since BuddyPress 1.2.0
 */
function bp_activity_make_nofollow_filter_callback( $matches ) {
	$text = $matches[1];
	$text = str_replace( array( ' rel="nofollow"', " rel='nofollow'" ), '', $text );
	// Extract URL from href
	preg_match_all( '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match );
	$url_host      = ( isset( $match[0] ) && isset( $match[0][0] ) ? parse_url( $match[0][0], PHP_URL_HOST ) : '' );
	$base_url_host = parse_url( site_url(), PHP_URL_HOST );
	// If site link then nothing to do.
	if ( $url_host == $base_url_host || empty( $url_host ) ) {
		return "<a $text rel=\"nofollow\">";
		// Else open in new tab.
	} else {
		return "<a target='_blank' $text rel=\"nofollow\">";
	}
}

/**
 * Truncate long activity entries when viewed in activity feeds.
 *
 * This method can only be used inside the Activity loop.
 *
 * @param string $text The original activity entry text.
 * @param array  $args {
 *                     Optional parameters. See $options argument of {@link bp_create_excerpt()}
 *                     for all available parameters.
 *                     }.
 *
 * @return string $excerpt The truncated text.
 * @since BuddyPress 2.6.0 Added $args parameter.
 *
 * @since BuddyPress 1.5.0
 */
function bp_activity_truncate_entry( $text, $args = array() ) {
	global $activities_template;
	/**
	 * Provides a filter that lets you choose whether to skip this filter on a per-activity basis.
	 *
	 * @param bool $value If true, text should be checked to see if it needs truncating.
	 *
	 * @since BuddyPress 2.3.0
	 */
	$maybe_truncate_text = apply_filters(
		'bp_activity_maybe_truncate_entry',
		isset( $activities_template->activity->type ) && ! in_array( $activities_template->activity->type, array( 'new_blog_post' ), true )
	);
	// The full text of the activity update should always show on the single activity screen.
	if ( empty( $args['force_truncate'] ) && ( ! $maybe_truncate_text || bp_is_single_activity() ) ) {
		return $text;
	}
	/**
	 * Filters the appended text for the activity excerpt.
	 *
	 * @param string $value Internationalized "Read more" text.
	 *
	 * @since BuddyPress 1.5.0
	 */
	$append_text    = apply_filters( 'bp_activity_excerpt_append_text', __( ' Read more', 'buddyboss' ) );
	$excerpt_length = bp_activity_get_excerpt_length();
	$args           = wp_parse_args( $args, array( 'ending' => __( '&hellip;', 'buddyboss' ) ) );
	// Run the text through the excerpt function. If it's too short, the original text will be returned.
	$excerpt = bp_create_excerpt( $text, $excerpt_length, $args );
	/*
	 * If the text returned by bp_create_excerpt() is different from the original text (ie it's
	 * been truncated), add the "Read More" link. Note that bp_create_excerpt() is stripping
	 * shortcodes, so we have strip them from the $text before the comparison.
	 */
	if ( strlen( $excerpt ) < strlen( strip_shortcodes( $text ) ) ) {
		$id      = ! empty( $activities_template->activity->current_comment->id ) ? 'acomment-read-more-' . $activities_template->activity->current_comment->id : 'activity-read-more-' . bp_get_activity_id();
		$excerpt = sprintf( '%1$s<span class="activity-read-more" id="%2$s"><a href="%3$s" rel="nofollow">%4$s</a></span>', $excerpt, $id, bp_get_activity_thread_permalink(), $append_text );
	}

	/**
	 * Filters the composite activity excerpt entry.
	 *
	 * @param string $excerpt     Excerpt text and markup to be displayed.
	 * @param string $text        The original activity entry text.
	 * @param string $append_text The final append text applied.
	 *
	 * @since BuddyPress 1.5.0
	 */
	return apply_filters( 'bp_activity_truncate_entry', $excerpt, $text, $append_text );
}

/**
 * Embed link preview in activity content
 *
 * @param $content
 * @param $activity
 *
 * @return string
 * @since BuddyBoss 1.0.0
 */
function bp_activity_link_preview( $content, $activity ) {
	$activity_id  = $activity->id;
	$preview_data = bp_activity_get_meta( $activity_id, '_link_preview_data', true );
	if ( empty( $preview_data['url'] ) ) {
		return $content;
	}
	$preview_data = bp_parse_args(
		$preview_data,
		array(
			'title'       => '',
			'description' => '',
		)
	);
	$description  = $preview_data['description'];
	$read_more    = ' &hellip; <a class="activity-link-preview-more" href="' . esc_url( $preview_data['url'] ) . '" target="_blank" rel="nofollow">' . __( 'Continue reading', 'buddyboss' ) . '</a>';
	$description  = wp_trim_words( $description, 40, $read_more );
	$content      = make_clickable( $content );
	$content     .= '<div class="activity-link-preview-container">';
	$content     .= '<p class="activity-link-preview-title"><a href="' . esc_url( $preview_data['url'] ) . '" target="_blank" rel="nofollow">' . esc_html( $preview_data['title'] ) . '</a></p>';
	if ( ! empty( $preview_data['attachment_id'] ) ) {
		$image_url = wp_get_attachment_image_url( $preview_data['attachment_id'], 'full' );
		$content  .= '<div class="activity-link-preview-image">';
		$content  .= '<a href="' . esc_url( $preview_data['url'] ) . '" target="_blank"><img src="' . esc_url( $image_url ) . '" /></a>';
		$content  .= '</div>';
	} elseif ( ! empty( $preview_data['image_url'] ) ) {
		$content .= '<div class="activity-link-preview-image">';
		$content .= '<a href="' . esc_url( $preview_data['url'] ) . '" target="_blank"><img src="' . esc_url( $preview_data['image_url'] ) . '" /></a>';
		$content .= '</div>';
	}
	$content .= '<div class="activity-link-preview-excerpt"><p>' . $description . '</p></div>';
	$content .= '</div>';

	return $content;
}

/**
 * Include extra JavaScript dependencies for activity component.
 *
 * @param array $js_handles The original dependencies.
 *
 * @return array $js_handles The new dependencies.
 * @since BuddyPress 2.0.0
 */
function bp_activity_get_js_dependencies( $js_handles = array() ) {
	if ( bp_activity_do_heartbeat() ) {
		$js_handles[] = 'heartbeat';
	}

	return $js_handles;
}

// add_filter( 'bp_core_get_js_dependencies', 'bp_activity_get_js_dependencies', 10, 1 );
// NOTICE: this dependency breaks activity stream when heartbeat is dequed via external sources
/**
 * Enqueue Heartbeat js for the activity
 *
 * @since BuddyBoss 1.1.1
 */
function bp_activity_enqueue_heartbeat_js() {
	if ( bp_activity_do_heartbeat() ) {
		wp_enqueue_script( 'heartbeat' );
	}
}

add_action( 'bp_nouveau_enqueue_scripts', 'bp_activity_enqueue_heartbeat_js' );
/**
 * Add a just-posted classes to the most recent activity item.
 *
 * We use these classes to avoid pagination issues when items are loaded
 * dynamically into the activity feed.
 *
 * @param string $classes Array of classes for most recent activity item.
 *
 * @return string $classes
 * @since BuddyPress 2.0.0
 */
function bp_activity_newest_class( $classes = '' ) {
	$bp = buddypress();
	if ( ! empty( $bp->activity->last_recorded ) && $bp->activity->last_recorded == bp_get_activity_date_recorded() ) {
		$classes .= ' new-update';
	}
	$classes .= ' just-posted';

	return $classes;
}

/**
 * Returns $args to force display of all member activity types on members activity feed.
 *
 * @param array $args
 *
 * @return array $args
 * @since BuddyBoss 1.0.0
 */
function bp_activity_display_all_types_on_just_me( $args ) {
	if ( empty( $args['scope'] ) || 'all' !== $args['scope'] || ! bp_loggedin_user_id() ) {
		return $args;
	}
	if ( bp_is_user() && 'all' === $args['scope'] && empty( bp_current_action() ) ) {
		$scope         = array( 'just-me' );
		$args['scope'] = implode( ',', $scope );

		return $args;
	}
	$scope = array( 'just-me' );
	if ( bp_activity_do_mentions() ) {
		$scope[] = 'mentions';
	}
	if ( bp_is_active( 'friends' ) ) {
		$scope[] = 'friends';
	}
	if ( bp_is_active( 'groups' ) ) {
		$scope[] = 'groups';
	}
	if ( bp_is_activity_follow_active() ) {
		$scope[] = 'following';
	}
	$args['scope'] = implode( ',', $scope );

	return $args;
}

/**
 * Check if Activity Heartbeat feature i on to add a timestamp class.
 *
 * @param string $classes Array of classes for timestamp.
 *
 * @return string $classes
 * @since BuddyPress 2.0.0
 */
function bp_activity_timestamp_class( $classes = '' ) {
	if ( ! bp_activity_do_heartbeat() ) {
		return $classes;
	}
	$activity_date = bp_get_activity_date_recorded();
	if ( empty( $activity_date ) ) {
		return $classes;
	}
	$classes .= ' date-recorded-' . strtotime( $activity_date );

	return $classes;
}

add_filter( 'bp_get_activity_css_class', 'bp_activity_timestamp_class', 9, 1 );
/**
 * Use WordPress Heartbeat API to check for latest activity update.
 *
 * @param array $response Array containing Heartbeat API response.
 * @param array $data     Array containing data for Heartbeat API response.
 *
 * @return array $response
 * @since BuddyPress 2.0.0
 */
function bp_activity_heartbeat_last_recorded( $response = array(), $data = array() ) {
	if ( empty( $data['bp_activity_last_recorded'] ) ) {
		return $response;
	}
	// Use the querystring argument stored in the cookie (to preserve
	// filters), but force the offset to get only new items.
	$activity_latest_args = bp_parse_args(
		bp_ajax_querystring( 'activity' ),
		array( 'since' => date_i18n( 'Y-m-d H:i:s', $data['bp_activity_last_recorded'] ) ),
		'activity_latest_args'
	);
	if ( ! empty( $data['bp_activity_last_recorded_search_terms'] ) && empty( $activity_latest_args['search_terms'] ) ) {
		$activity_latest_args['search_terms'] = addslashes( $data['bp_activity_last_recorded_search_terms'] );
	}
	$newest_activities      = array();
	$last_activity_recorded = 0;
	// Temporarily add a just-posted class for new activity items.
	add_filter( 'bp_get_activity_css_class', 'bp_activity_newest_class', 10, 1 );
	ob_start();
	if ( bp_has_activities( $activity_latest_args ) ) {
		while ( bp_activities() ) {
			bp_the_activity();
			$atime = strtotime( bp_get_activity_date_recorded() );
			if ( $last_activity_recorded < $atime ) {
				$last_activity_recorded = $atime;
			}
			bp_get_template_part( 'activity/entry' );
		}
	}
	$newest_activities['activities']    = ob_get_contents();
	$newest_activities['last_recorded'] = $last_activity_recorded;
	ob_end_clean();
	// Remove the temporary filter.
	remove_filter( 'bp_get_activity_css_class', 'bp_activity_newest_class', 10 );
	if ( ! empty( $newest_activities['last_recorded'] ) ) {
		$response['bp_activity_newest_activities'] = $newest_activities;
	}

	return $response;
}

add_filter( 'heartbeat_received', 'bp_activity_heartbeat_last_recorded', 10, 2 );
add_filter( 'heartbeat_nopriv_received', 'bp_activity_heartbeat_last_recorded', 10, 2 );
/**
 * Set the strings for WP HeartBeat API where needed.
 *
 * @param array $strings Localized strings.
 *
 * @return array $strings
 * @since BuddyPress 2.0.0
 */
function bp_activity_heartbeat_strings( $strings = array() ) {
	if ( ! bp_activity_do_heartbeat() ) {
		return $strings;
	}
	$global_pulse = 0;
	/**
	 * Filter that checks whether the global heartbeat settings already exist.
	 *
	 * @param array $value Heartbeat settings array.
	 *
	 * @since BuddyPress 2.0.0
	 */
	$heartbeat_settings = apply_filters( 'heartbeat_settings', array() );
	if ( ! empty( $heartbeat_settings['interval'] ) ) {
		// 'Fast' is 5
		$global_pulse = is_numeric( $heartbeat_settings['interval'] ) ? absint( $heartbeat_settings['interval'] ) : 5;
	}
	/**
	 * Filters the pulse frequency to be used for the BuddyBoss Activity heartbeat.
	 *
	 * @param int $value The frequency in seconds between pulses.
	 *
	 * @since BuddyPress 2.0.0
	 */
	$bp_activity_pulse = apply_filters( 'bp_activity_heartbeat_pulse', 15 );
	/**
	 * Use the global pulse value unless:
	 * a. the BP-specific value has been specifically filtered, or
	 * b. it doesn't exist (ie, BP will be the only one using the heartbeat,
	 *    so we're responsible for enabling it)
	 */
	if ( has_filter( 'bp_activity_heartbeat_pulse' ) || empty( $global_pulse ) ) {
		$pulse = $bp_activity_pulse;
	} else {
		$pulse = $global_pulse;
	}
	$strings = array_merge(
		$strings,
		array(
			'newest' => __( 'Load Newest', 'buddyboss' ),
			'pulse'  => absint( $pulse ),
		)
	);

	return $strings;
}

add_filter( 'bp_core_get_js_strings', 'bp_activity_heartbeat_strings', 10, 1 );
/** Scopes ********************************************************************/
/**
 * Set up activity arguments for use with the 'just-me' scope.
 *
 * @param array $retval Empty array by default.
 * @param array $filter Current activity arguments.
 *
 * @return array $retval
 * @since BuddyPress 2.2.0
 */
function bp_activity_filter_just_me_scope( $retval = array(), $filter = array() ) {
	// Determine the user_id.
	if ( ! empty( $filter['user_id'] ) ) {
		$user_id = $filter['user_id'];
	} else {
		$user_id = bp_displayed_user_id()
			? bp_displayed_user_id()
			: bp_loggedin_user_id();
	}
	// Should we show all items regardless of sitewide visibility?
	$show_hidden = array();
	if ( ! empty( $user_id ) && $user_id !== bp_loggedin_user_id() ) {
		$show_hidden = array(
			'column' => 'hide_sitewide',
			'value'  => 0,
		);
	}
	$privacy = array( 'public' );
	if ( is_user_logged_in() ) {
		$privacy[] = 'loggedin';
		if ( bp_is_active( 'friends' ) ) {
			// Determine friends of user.
			$friends = friends_get_friend_user_ids( $user_id );
			if ( $user_id === bp_loggedin_user_id() || bp_is_activity_directory() ) {
				$friends[] = bp_loggedin_user_id();
			}
			if ( ! empty( $friends ) && in_array( bp_loggedin_user_id(), $friends ) ) {
				$privacy[] = 'friends';
			}
		}
		if ( $user_id === bp_loggedin_user_id() ) {
			$privacy[] = 'onlyme';
		}
	}
	$retval = array(
		'relation' => 'AND',
		array(
			'column' => 'user_id',
			'value'  => $user_id,
		),
		array(
			'column'  => 'privacy',
			'value'   => $privacy,
			'compare' => 'IN',
		),
		$show_hidden,
		// Overrides.
		'override' => array(
			// 'display_comments' => bp_show_streamed_activity_comment() ? 'stream' : 'threaded',
			'filter'      => array( 'user_id' => 0 ),
			'show_hidden' => true,
		),
	);

	return $retval;
}

add_filter( 'bp_activity_set_just-me_scope_args', 'bp_activity_filter_just_me_scope', 10, 2 );
/**
 * Set up activity arguments for use with the 'public' scope.
 *
 * @param array $retval Empty array by default.
 * @param array $filter Current activity arguments.
 *
 * @return array $retval
 * @since BuddyBoss 1.4.3
 */
function bp_activity_filter_public_scope( $retval = array(), $filter = array() ) {
	$privacy = array( 'public' );
	if ( bp_loggedin_user_id() ) {
		$privacy[] = 'loggedin';
	}
	$retval = array(
		'relation' => 'AND',
		array(
			'column'  => 'privacy',
			'value'   => $privacy,
			'compare' => 'IN',
		),
		array(
			'column' => 'hide_sitewide',
			'value'  => 0,
		),
	);

	return $retval;
}

add_filter( 'bp_activity_set_public_scope_args', 'bp_activity_filter_public_scope', 10, 2 );
/**
 * Set up activity arguments for use with the 'favorites' scope.
 *
 * @param array $retval Empty array by default.
 * @param array $filter Current activity arguments.
 *
 * @return array $retval
 * @since BuddyPress 2.2.0
 */
function bp_activity_filter_favorites_scope( $retval = array(), $filter = array() ) {
	// Determine the user_id.
	if ( ! empty( $filter['user_id'] ) ) {
		$user_id = $filter['user_id'];
	} else {
		$user_id = bp_displayed_user_id()
			? bp_displayed_user_id()
			: bp_loggedin_user_id();
	}
	// Determine the favorites.
	$favs = bp_activity_get_user_favorites( $user_id );
	if ( empty( $favs ) ) {
		$favs = array( 0 );
	}
	// Should we show all items regardless of sitewide visibility?
	$show_hidden = array();
	if ( ! empty( $user_id ) && ( $user_id !== bp_loggedin_user_id() ) ) {
		$show_hidden = array(
			'column' => 'hide_sitewide',
			'value'  => 0,
		);
	}
	$friends_filter = array();
	$onlyme_filter  = array();
	$privacy        = array( 'public' );
	if ( is_user_logged_in() ) {
		$privacy[] = 'loggedin';
		if ( bp_is_active( 'friends' ) ) {
			// Determine friends of user.
			$friends = friends_get_friend_user_ids( $user_id );
			if ( empty( $friends ) ) {
				$friends = array( 0 );
			}
			if ( $user_id === bp_loggedin_user_id() ) {
				$friends[] = bp_loggedin_user_id();
				$friends   = array_unique( $friends );
			}
			if ( ! empty( $friends ) ) {
				$friends_filter = array(
					'relation' => 'AND',
					array(
						'column'  => 'user_id',
						'compare' => 'IN',
						'value'   => (array) $friends,
					),
					array(
						'column'  => 'privacy',
						'compare' => '=',
						'value'   => 'friends',
					),
					array(
						'column'  => 'id',
						'compare' => 'IN',
						'value'   => (array) $favs,
					),
					$show_hidden,
				);
			}
		}
		if ( $user_id === bp_loggedin_user_id() ) {
			$onlyme_filter = array(
				'relation' => 'AND',
				array(
					'column'  => 'user_id',
					'compare' => '=',
					'value'   => $user_id,
				),
				array(
					'column'  => 'privacy',
					'compare' => '=',
					'value'   => 'onlyme',
				),
				array(
					'column'  => 'id',
					'compare' => 'IN',
					'value'   => (array) $favs,
				),
				$show_hidden,
			);
			$privacy[]     = 'loggedin';
		}
	}
	$retval = array(
		'relation' => 'AND',
		array(
			'column'  => 'id',
			'compare' => 'IN',
			'value'   => (array) $favs,
		),
		array(
			'column'  => 'privacy',
			'compare' => 'IN',
			'value'   => $privacy,
		),
		$show_hidden,
	);
	if ( empty( $friends_filter ) && empty( $onlyme_filter ) ) {
		$retval['override'] = array(
			'filter'      => array( 'user_id' => 0 ),
			'show_hidden' => true,
		);
	}
	if ( ! empty( $friends_filter ) || ! empty( $onlyme_filter ) ) {
		$retval = array(
			'relation' => 'OR',
			$retval,
			$friends_filter,
			$onlyme_filter,
			// Overrides.
			'override' => array(
				'filter'      => array( 'user_id' => 0 ),
				'show_hidden' => true,
			),
		);
	}

	return $retval;
}

add_filter( 'bp_activity_set_favorites_scope_args', 'bp_activity_filter_favorites_scope', 10, 2 );
/**
 * Set up activity arguments for use with the 'favorites' scope.
 *
 * @param array $retval Empty array by default.
 * @param array $filter Current activity arguments.
 *
 * @return array $retval
 * @since BuddyPress 2.2.0
 */
function bp_activity_filter_mentions_scope( $retval = array(), $filter = array() ) {
	// Are mentions disabled?
	if ( ! bp_activity_do_mentions() ) {
		return $retval;
	}
	// Determine the user_id.
	if ( ! empty( $filter['user_id'] ) ) {
		$user_id = $filter['user_id'];
	} else {
		$user_id = bp_displayed_user_id()
			? bp_displayed_user_id()
			: bp_loggedin_user_id();
	}
	$privacy     = array( 'public' );
	$friends     = array();
	$show_hidden = array();
	$user_groups = array();
	if ( is_user_logged_in() ) {
		$privacy[] = 'loggedin';
		if ( bp_is_active( 'friends' ) && $user_id ) {
			// Determine friends of user.
			$friends = friends_get_friend_user_ids( $user_id );
		}
	}
	if ( bp_is_active( 'groups' ) ) {
		if ( ! empty( $user_id ) && $user_id !== bp_loggedin_user_id() ) {
			$show_hidden = array(
				'column' => 'hide_sitewide',
				'value'  => 0,
			);
		}
		// Fetch public groups.
		$public_groups = groups_get_groups(
			array(
				'fields'   => 'ids',
				'status'   => 'public',
				'per_page' => - 1,
			)
		);
		if ( ! empty( $public_groups['groups'] ) ) {
			$public_groups = $public_groups['groups'];
		} else {
			$public_groups = array();
		}
		if ( is_user_logged_in() ) {
			$groups = groups_get_user_groups( $user_id );
			if ( ! empty( $groups['groups'] ) ) {
				$user_groups = $groups['groups'];
			} else {
				$user_groups = array();
			}
		}
		$user_groups = array_unique( array_merge( $user_groups, $public_groups ) );
	}
	$privacy_scope = array();
	if ( ! empty( $friends ) ) {
		$privacy_scope[] = array(
			'relation' => 'AND',
			array(
				'column'  => 'user_id',
				'compare' => 'IN',
				'value'   => (array) $friends,
			),
			array(
				'column'  => 'privacy',
				'compare' => '=',
				'value'   => 'friends',
			),
		);
	}
	if ( ! empty( $user_groups ) ) {
		$privacy_scope[] = array(
			'relation' => 'AND',
			array(
				'column'  => 'item_id',
				'compare' => 'IN',
				'value'   => $user_groups,
			),
			array(
				'column' => 'component',
				'value'  => buddypress()->groups->id,
			),
			array(
				'column'  => 'privacy',
				'compare' => '=',
				'value'   => 'public',
			),
			$show_hidden,
		);
	}
	$privacy_scope[] = array(
		'relation' => 'AND',
		array(
			'column'  => 'privacy',
			'compare' => 'IN',
			'value'   => $privacy,
		),
		array(
			'column'  => 'component',
			'compare' => '!=',
			'value'   => 'groups',
		),
	);
	if ( ! empty( $privacy_scope ) && count( $privacy_scope ) > 1 ) {
		$privacy_scope['relation'] = 'OR';
	}
	$retval = array(
		'relation' => 'AND',
		array(
			'column'  => 'content',
			'compare' => 'LIKE',
			// Start search at @ symbol and stop search at closing tag delimiter.
			'value'   => '@' . bp_activity_get_user_mentionname( $user_id ) . '<',
		),
		// Overrides.
		'override' => array(
			// 'display_comments' => bp_show_streamed_activity_comment() ? 'stream' : 'threaded',
			'filter'      => array( 'user_id' => 0 ),
			'show_hidden' => true,
		),
		$privacy_scope,
	);

	return $retval;
}

add_filter( 'bp_activity_set_mentions_scope_args', 'bp_activity_filter_mentions_scope', 10, 2 );
/**
 * Filter the members loop on a follow page.
 *
 * This is done so we can return users that:
 *   - the current user is following (on a user page or member directory); or
 *   - are following the displayed user on the displayed user's followers page
 *
 * @param array|string $qs     The querystring for the BP loop.
 * @param str          $object The current object for the querystring.
 *
 * @return array|string Modified querystring
 * @since BuddyBoss 1.0.0
 */
function bp_add_member_follow_scope_filter( $qs, $object ) {
	// not on the members object? stop now!
	if ( 'members' !== $object ) {
		return $qs;
	}
	// members directory
	if ( ! bp_is_user() && bp_is_members_directory() ) {
		$qs_args = wp_parse_args( $qs );
		// check if members scope is following before manipulating.
		if ( isset( $qs_args['scope'] ) && 'following' === $qs_args['scope'] ) {
			$qs .= '&include=' . bp_get_following_ids(
				array(
					'user_id' => bp_loggedin_user_id(),
				)
			);
		}
	}

	return $qs;
}

add_filter( 'bp_ajax_querystring', 'bp_add_member_follow_scope_filter', 20, 2 );
/**
 * Set up activity arguments for use with the 'following' scope.
 *
 * For details on the syntax, see {@link BP_Activity_Query}.
 *
 * @param array $retval Empty array by default.
 * @param array $filter Current activity arguments.
 *
 * @return array
 * @since BuddyBoss 1.0.0
 */
function bp_users_filter_activity_following_scope( $retval = array(), $filter = array() ) {
	// Is follow active?
	if ( ! bp_is_activity_follow_active() ) {
		return $retval;
	}
	// Determine the user_id.
	if ( ! empty( $filter['user_id'] ) ) {
		$user_id = $filter['user_id'];
	} else {
		$user_id = bp_displayed_user_id()
			? bp_displayed_user_id()
			: bp_loggedin_user_id();
	}
	// Determine following of user.
	$following_ids = bp_get_following(
		array(
			'user_id' => $user_id,
		)
	);
	if ( empty( $following_ids ) ) {
		$following_ids = array( 0 );
	}
	$privacy = array( 'public' );
	if ( bp_loggedin_user_id() ) {
		$privacy[] = 'loggedin';
	}
	$friends_follow = array();
	if ( bp_is_active( 'friends' ) && $user_id === bp_loggedin_user_id() ) {
		// Determine friends of user.
		$friends = friends_get_friend_user_ids( $user_id );
		if ( ! empty( $friends ) ) {
			$friends_follower_ids = array_intersect( $following_ids, $friends );
			if ( ! empty( $friends_follower_ids ) ) {
				$friends_follow[] = array(
					'relation' => 'AND',
					array(
						'column'  => 'user_id',
						'compare' => 'IN',
						'value'   => (array) $friends_follower_ids,
					),
					array(
						'column'  => 'privacy',
						'compare' => '=',
						'value'   => 'friends',
					),
				);
			}
		}
	}
	$friends_follow[] = array(
		'relation' => 'AND',
		array(
			'column'  => 'user_id',
			'compare' => 'IN',
			'value'   => (array) $following_ids,
		),
		array(
			'column'  => 'privacy',
			'compare' => 'IN',
			'value'   => (array) $privacy,
		),
	);
	if ( ! empty( $friends_follow ) && count( $friends_follow ) > 1 ) {
		$friends_follow['relation'] = 'OR';
	}
	$retval = array(
		'relation' => 'AND',
		$friends_follow,
		// we should only be able to view sitewide activity content for those the user
		// is following.
		array(
			'column' => 'hide_sitewide',
			'value'  => 0,
		),
		// overrides.
		'override' => array(
			'filter'      => array(
				'user_id' => 0,
			),
			'show_hidden' => true,
		),
	);

	return $retval;
}

add_filter( 'bp_activity_set_following_scope_args', 'bp_users_filter_activity_following_scope', 10, 2 );
/**
 * Do not add the activity if uncheck the options from the
 * backend BuddyBoss > Settings > Activity > Posts in Activity Feed >BuddyBoss Platform
 *
 * @param $activity_object
 *
 * @since BuddyBoss 1.0.0
 */
function bp_activity_remove_platform_updates( $activity_object ) {
	if ( false === bp_platform_is_feed_enable( 'bp-feed-platform-' . $activity_object->type ) ) {
		$activity_object->type = false;
	}
}

/**
 * Fix to BuddyBoss media activity data
 *
 * @since BuddyBoss 1.0.0
 */
function bp_activity_media_fix_data() {
	$privacy    = array( 'public', 'loggedin', 'friends', 'onlyme', 'grouponly', 'media' );
	$meta_query = array(
		array(
			'relation' => 'OR',
			'key'      => 'bp_media_activity',
			'compare'  => 'EXISTS',
		),
	);
	$result     = BP_Activity_Activity::get(
		array(
			'per_page'    => 10000,
			'privacy'     => $privacy,
			'meta_query'  => $meta_query,
			'show_hidden' => true,
		)
	);
	if ( ! empty( $result['activities'] ) ) {
		foreach ( $result['activities'] as $activity ) {
			$activity = new BP_Activity_Activity( $activity->id );
			if ( ! empty( $activity ) ) {
				$activity->privacy = 'media';
				$activity->save();
			}
		}
	}
}

/**
 * Filter the activities of friends privacy
 *
 * @param $has_activities
 * @param $activities
 *
 * @return mixed
 * @since BuddyBoss 1.0.0
 */
function bp_activity_has_activity_filter( $has_activities, $activities ) {
	if ( ! $has_activities || ! bp_is_active( 'friends' ) || ! is_user_logged_in() || is_super_admin() ) {
		return $has_activities;
	}
	if ( ! empty( $activities->activities ) ) {
		foreach ( $activities->activities as $key => $activity ) {
			if ( 'friends' == $activity->privacy && $activity->user_id !== bp_loggedin_user_id() ) {
				$remove_from_stream = false;
				$is_friend          = friends_check_friendship( bp_loggedin_user_id(), $activity->user_id );
				if ( ! $is_friend ) {
					$remove_from_stream = true;
				}
				if ( $remove_from_stream && isset( $activities->activity_count ) ) {
					$activities->activity_count = $activities->activity_count - 1;
					if ( isset( $activities->total_activity_count ) ) {
						$activities->total_activity_count = $activities->total_activity_count - 1;
					}
					unset( $activities->activities[ $key ] );
				}
			}
		}
	}
	$activities->activities = array_values( $activities->activities );
	if ( $activities->activity_count === 0 ) {
		return false;
	}

	return $has_activities;
}

/**
 * Filter the activities for document and media privacy
 *
 * @param $has_activities
 * @param $activities
 *
 * @return mixed
 * @since BuddyBoss 1.4.3
 */
function bp_activity_has_media_activity_filter( $has_activities, $activities ) {
	if ( ! $has_activities || ! bp_is_active( 'media' ) || ! bp_is_single_activity() ) {
		return $has_activities;
	}
	if ( ! empty( $activities->activities ) ) {
		foreach ( $activities->activities as $key => $activity ) {
			if ( in_array( $activity->privacy, array( 'media', 'document' ) ) ) {
				$parent_activity_id = false;
				if ( ! empty( $activity->secondary_item_id ) ) {
					$parent_activity_id = $activity->secondary_item_id;
				} else {
					$attachment_id = BP_Media::get_activity_attachment_id( $activity->id );
					if ( ! empty( $attachment_id ) ) {
						$parent_activity_id = get_post_meta( $attachment_id, 'bp_media_parent_activity_id', true );
					}
				}
				if ( ! empty( $parent_activity_id ) ) {
					$parent         = new BP_Activity_Activity( $parent_activity_id );
					$parent_user    = $parent->user_id;
					$parent_privacy = $parent->privacy;
					if ( $parent_privacy === 'public' ) {
						continue;
					}
					$remove_from_stream = false;
					if ( $parent_privacy === 'loggedin' && ! bp_loggedin_user_id() ) {
						$remove_from_stream = true;
					}
					if ( false === $remove_from_stream && $parent_privacy === 'onlyme' && bp_loggedin_user_id() !== $parent_user ) {
						$remove_from_stream = true;
					}
					if ( false === $remove_from_stream && $parent_privacy === 'friends' ) {
						if ( bp_is_active( 'friends' ) ) {
							$is_friend = friends_check_friendship( bp_loggedin_user_id(), $parent_user );
							if ( ! $is_friend && $parent_user !== bp_loggedin_user_id() ) {
								$remove_from_stream = true;
							}
						} else {
							$remove_from_stream = true;
						}
					}
					if ( $remove_from_stream && isset( $activities->activity_count ) ) {
						$activities->activity_count = $activities->activity_count - 1;
						if ( isset( $activities->total_activity_count ) ) {
							$activities->total_activity_count = $activities->total_activity_count - 1;
						}
						unset( $activities->activities[ $key ] );
					}
				}
			}
		}
	}
	$activities->activities = array_values( $activities->activities );
	if ( $activities->activity_count === 0 ) {
		return false;
	}

	return $has_activities;
}

/**
 * Create media activity for each media uploaded
 *
 * @param $media
 *
 * @since BuddyBoss 1.2.0
 */
function bp_activity_media_add( $media ) {
	global $bp_media_upload_count, $bp_new_activity_comment, $bp_activity_post_update_id, $bp_activity_post_update;
	if ( ! empty( $media ) && empty( $media->activity_id ) ) {
		$parent_activity_id = false;
		if ( ! empty( $bp_activity_post_update ) && ! empty( $bp_activity_post_update_id ) ) {
			$parent_activity_id = (int) $bp_activity_post_update_id;
		}
		if ( $bp_media_upload_count > 1 || ! empty( $bp_new_activity_comment ) ) {
			if ( bp_is_active( 'groups' ) && ! empty( $bp_new_activity_comment ) && empty( $media->group_id ) ) {
				$comment = new BP_Activity_Activity( $bp_new_activity_comment );
				if ( ! empty( $comment->item_id ) ) {
					$comment_activity = new BP_Activity_Activity( $comment->item_id );
					if ( ! empty( $comment_activity->component ) && buddypress()->groups->id === $comment_activity->component ) {
						$media->group_id = $comment_activity->item_id;
						$media->privacy  = 'comment'; // Set privacy for group activity - grouponly to comment - 2121
					}
				}
			}
			// Check when new activity coment is empty then set privacy comment - - 2121
			if ( ! empty( $bp_new_activity_comment ) ) {
				$activity_id    = $bp_new_activity_comment;
				$media->privacy = 'comment';
			} else {
				$args = array(
					'hide_sitewide' => true,
					'privacy'       => 'media',
				);
				// Create activity only if not created previously.
				if ( ! empty( $media->group_id ) && bp_is_active( 'groups' ) ) {
					$args['item_id'] = $media->group_id;
					$args['type']    = 'activity_update';
					$current_group   = groups_get_group( $media->group_id );
					$args['action']  = sprintf( __( '%1$s posted an update in the group %2$s', 'buddyboss' ), bp_core_get_userlink( $media->user_id ), '<a href="' . bp_get_group_permalink( $current_group ) . '">' . esc_attr( $current_group->name ) . '</a>' );
					$activity_id     = groups_record_activity( $args );
				} else {
					$activity_id = bp_activity_post_update( $args );
				}
			}
			if ( $activity_id ) {
				// save media activity id in media
				$media->activity_id = $activity_id;
				$media->save();
				// update activity meta
				bp_activity_update_meta( $activity_id, 'bp_media_activity', '1' );
				bp_activity_update_meta( $activity_id, 'bp_media_id', $media->id );
				// save attachment meta for activity
				update_post_meta( $media->attachment_id, 'bp_media_activity_id', $activity_id );
				if ( $parent_activity_id ) {
					// If new activity comment is empty - 2121
					if ( empty( $bp_new_activity_comment ) ) {
						$media_activity                    = new BP_Activity_Activity( $activity_id );
						$media_activity->secondary_item_id = $parent_activity_id;
						$media_activity->save();
					}
					// save parent activity id in attachment meta
					update_post_meta( $media->attachment_id, 'bp_media_parent_activity_id', $parent_activity_id );
				}
			}
		} else {
			if ( $parent_activity_id ) {
				// If the media posted in activity comment then set the activity id to comment id.- 2121
				if ( ! empty( $bp_new_activity_comment ) ) {
					$parent_activity_id = $bp_new_activity_comment;
					$media->privacy     = 'comment';
				}
				// save media activity id in media
				$media->activity_id = $parent_activity_id;
				$media->save();
				// save parent activity id in attachment meta
				update_post_meta( $media->attachment_id, 'bp_media_parent_activity_id', $parent_activity_id );
			}
		}
	}
}

/**
 * Create main activity for the media uploaded and saved.
 *
 * @param $media_ids
 *
 * @return mixed
 * @since BuddyBoss 1.2.0
 */
function bp_activity_create_parent_media_activity( $media_ids ) {
	global $bp_media_upload_count, $bp_activity_post_update, $bp_media_upload_activity_content, $bp_activity_post_update_id, $bp_activity_edit;
	if ( ! empty( $media_ids ) && empty( $bp_activity_post_update ) && ! isset( $_POST['edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$added_media_ids = $media_ids;
		$content         = false;
		if ( ! empty( $bp_media_upload_activity_content ) ) {
			/**
			 * Filters the content provided in the activity input field.
			 *
			 * @param string $value Activity message being posted.
			 *
			 * @since BuddyPress 1.2.0
			 */
			$content = apply_filters( 'bp_activity_post_update_content', $bp_media_upload_activity_content );
		}
		$group_id = FILTER_INPUT( INPUT_POST, 'group_id', FILTER_SANITIZE_NUMBER_INT );
		$album_id = false;
		// added fall back to get group_id from media.
		if ( empty( $group_id ) && ! empty( $added_media_ids ) ) {
			$media_object = new BP_Media( current( (array) $added_media_ids ) );
			if ( ! empty( $media_object->group_id ) ) {
				$group_id = $media_object->group_id;
			}
		}
		if ( bp_is_active( 'groups' ) && ! empty( $group_id ) && $group_id > 0 ) {
			$activity_id = groups_post_update(
				array(
					'content'  => $content,
					'group_id' => $group_id,
				)
			);
		} else {
			$activity_id = bp_activity_post_update( array( 'content' => $content ) );
		}
		// save media meta for activity.
		if ( ! empty( $activity_id ) ) {
			$privacy = 'public';
			foreach ( (array) $added_media_ids as $media_id ) {
				$media = new BP_Media( $media_id );
				// get one of the media's privacy for the activity privacy.
				$privacy = $media->privacy;
				// get media album id.
				if ( ! empty( $media->album_id ) ) {
					$album_id = $media->album_id;
				}
				if ( 1 === $bp_media_upload_count ) {
					// save media activity id in media.
					$media->activity_id = $activity_id;
					$media->save();
				}
				// save parent activity id in attachment meta.
				update_post_meta( $media->attachment_id, 'bp_media_parent_activity_id', $activity_id );
			}
			bp_activity_update_meta( $activity_id, 'bp_media_ids', implode( ',', $added_media_ids ) );
			// if media is from album then save album id in activity media.
			if ( ! empty( $album_id ) ) {
				bp_activity_update_meta( $activity_id, 'bp_media_album_activity', $album_id );
			}
			if ( empty( $group_id ) ) {
				$main_activity = new BP_Activity_Activity( $activity_id );
				if ( ! empty( $main_activity ) ) {
					$main_activity->privacy = $privacy;
					$main_activity->save();
				}
			}
		}
	}

	return $media_ids;
}

/**
 * Update media and activity for media updation and deletion while editing the activity.
 *
 * @param $media_ids
 *
 * @return mixed
 * @since BuddyBoss 1.5.0
 */
function bp_activity_edit_update_media( $media_ids ) {
	global $bp_activity_edit, $bp_activity_post_update_id;
	if ( ( true === $bp_activity_edit || isset( $_POST['edit'] ) ) && ! empty( $bp_activity_post_update_id ) ) {
		$old_media_ids = bp_activity_get_meta( $bp_activity_post_update_id, 'bp_media_ids', true );
		$old_media_ids = explode( ',', $old_media_ids );
		if ( ! empty( $old_media_ids ) ) {
			// old media count 1 and new media uploaded count is greater than 1.
			if ( 1 === count( $old_media_ids ) && 1 < count( $media_ids ) ) {
				$old_media_id = $old_media_ids[0];
				// check if old media id is in new media uploaded.
				if ( in_array( $old_media_id, $media_ids ) ) {
					// Create new media activity for old media because it has only parent activity to show right now.
					$old_media = new BP_Media( $old_media_id );
					$args      = array(
						'hide_sitewide' => true,
						'privacy'       => 'media',
					);
					if ( ! empty( $old_media->group_id ) && bp_is_active( 'groups' ) ) {
						$args['item_id'] = $old_media->group_id;
						$args['type']    = 'activity_update';
						$current_group   = groups_get_group( $old_media->group_id );
						$args['action']  = sprintf( __( '%1$s posted an update in the group %2$s', 'buddyboss' ), bp_core_get_userlink( $old_media->user_id ), '<a href="' . bp_get_group_permalink( $current_group ) . '">' . esc_attr( $current_group->name ) . '</a>' );
						$activity_id     = groups_record_activity( $args );
					} else {
						$activity_id = bp_activity_post_update( $args );
					}
					// media activity for old media is created and it is being assigned to the old media.
					// And media activity is being saved with needed data to figure out everything for it.
					if ( $activity_id ) {
						$old_media->activity_id = $activity_id;
						$old_media->save();
						$media_activity                    = new BP_Activity_Activity( $activity_id );
						$media_activity->secondary_item_id = $bp_activity_post_update_id;
						$media_activity->save();
						// update activity meta to tell it is media activity.
						bp_activity_update_meta( $activity_id, 'bp_media_activity', '1' );
						bp_activity_update_meta( $activity_id, 'bp_media_id', $old_media->id );
						// save attachment meta for activity.
						update_post_meta( $old_media->attachment_id, 'bp_media_activity_id', $activity_id );
						// save parent activity id in attachment meta.
						update_post_meta( $old_media->attachment_id, 'bp_media_parent_activity_id', $bp_activity_post_update_id );
					}
				}
				// old media count is greater than 1 and new media uploaded count is only 1 now.
			} elseif ( 1 < count( $old_media_ids ) && 1 === count( $media_ids ) ) {
				$new_media_id = $media_ids[0];
				// check if new media is in old media uploaded, if yes then delete that media's media activity first.
				if ( in_array( $new_media_id, $old_media_ids ) ) {
					$new_media         = new BP_Media( $new_media_id );
					$media_activity_id = $new_media->activity_id;
					// delete media's assigned media activity.
					remove_action( 'bp_activity_after_delete', 'bp_media_delete_activity_media' );
					bp_activity_delete( array( 'id' => $media_activity_id ) );
					add_action( 'bp_activity_after_delete', 'bp_media_delete_activity_media' );
					// save parent activity id in media.
					$new_media->activity_id = $bp_activity_post_update_id;
					$new_media->save();
					// save parent activity id in attachment meta.
					update_post_meta( $new_media->attachment_id, 'bp_media_parent_activity_id', $bp_activity_post_update_id );
				}
				// old media and new media count is same and old media and new media are different.
			} elseif ( 1 === count( $old_media_ids ) && 1 === count( $media_ids ) ) {
				$new_media_id = $media_ids[0];
				// check if new media is not in old media uploaded and.
				if ( ! in_array( $new_media_id, $old_media_ids ) ) {
					$old_media_id = $old_media_ids[0];
					$old_media    = new BP_Media( $old_media_id );
					// unset the activity id for old media and save it to save activity from deleting after.
					if ( ! empty( $old_media->id ) ) {
						$old_media->activity_id = false;
						$old_media->save();
						// delete attachment activity id meta.
						delete_post_meta( $old_media->attachment_id, 'bp_media_parent_activity_id' );
					}
				}
			}
		}
	}

	return $media_ids;
}

/**
 * Generate permalink for comment mention notification.
 *
 * @param $link
 * @param $item_id
 * @param $secondary_item_id
 *
 * @return string
 * @since BuddyBoss 1.2.5
 */
function bp_activity_new_at_mention_permalink( $link, $item_id, $secondary_item_id ) {
	$activity_obj = new BP_Activity_Activity( $item_id );
	if ( 'activity_comment' == $activity_obj->type ) {
		$notification = BP_Notifications_Notification::get(
			array(
				'user_id'           => bp_loggedin_user_id(),
				'item_id'           => $item_id,
				'secondary_item_id' => $secondary_item_id,
				'component_name'    => 'activity',
				'component_action'  => 'new_at_mention',
			)
		);
		if ( ! empty( $notification ) ) {
			$id   = current( $notification )->id;
			$link = add_query_arg( 'crid', (int) $id, bp_activity_get_permalink( $activity_obj->id ) );
		}
	}

	return $link;
}

/**
 * Create document activity for each document uploaded
 *
 * @param $document
 *
 * @since BuddyBoss 1.2.0
 */
function bp_activity_document_add( $document ) {
	global $bp_document_upload_count, $bp_new_activity_comment, $bp_activity_post_update_id, $bp_activity_post_update;
	if ( ! empty( $document ) && empty( $document->activity_id ) ) {
		$parent_activity_id = false;
		if ( ! empty( $bp_activity_post_update ) && ! empty( $bp_activity_post_update_id ) ) {
			$parent_activity_id = (int) $bp_activity_post_update_id;
		}
		if ( $bp_document_upload_count > 1 || ! empty( $bp_new_activity_comment ) ) {
			if ( bp_is_active( 'groups' ) && ! empty( $bp_new_activity_comment ) && empty( $document->group_id ) ) {
				$comment = new BP_Activity_Activity( $bp_new_activity_comment );
				if ( ! empty( $comment->item_id ) ) {
					$comment_activity = new BP_Activity_Activity( $comment->item_id );
					if ( ! empty( $comment_activity->component ) && buddypress()->groups->id === $comment_activity->component ) {
						$document->group_id = $comment_activity->item_id;
						$document->privacy  = 'comment';
					}
				}
			}
			// Check when new activity comment is empty then set privacy comment - - 2121
			if ( ! empty( $bp_new_activity_comment ) ) {
				$activity_id       = $bp_new_activity_comment;
				$document->privacy = 'comment';
			} else {
				$args = array(
					'hide_sitewide' => true,
					'privacy'       => 'document',
				);
				// Create activity if not created previously.
				if ( ! empty( $document->group_id ) && bp_is_active( 'groups' ) ) {
					$args['item_id'] = $document->group_id;
					$args['type']    = 'activity_update';
					$current_group   = groups_get_group( $document->group_id );
					$args['action']  = sprintf( __( '%1$s posted an update in the group %2$s', 'buddyboss' ), bp_core_get_userlink( $document->user_id ), '<a href="' . bp_get_group_permalink( $current_group ) . '">' . esc_attr( $current_group->name ) . '</a>' );
					$activity_id     = groups_record_activity( $args );
				} else {
					$activity_id = bp_activity_post_update( $args );
				}
			}
			if ( $activity_id ) {
				// save document activity id in document.
				$document->activity_id = $activity_id;
				$document->save();
				// update activity meta.
				bp_activity_update_meta( $activity_id, 'bp_document_activity', '1' );
				bp_activity_update_meta( $activity_id, 'bp_document_id', $document->id );
				// save attachment meta for activity.
				update_post_meta( $document->attachment_id, 'bp_document_activity_id', $activity_id );
				if ( $parent_activity_id ) {
					if ( empty( $bp_new_activity_comment ) ) {
						$document_activity                    = new BP_Activity_Activity( $activity_id );
						$document_activity->secondary_item_id = $parent_activity_id;
						$document_activity->save();
						// save parent activity id in attachment meta.
						update_post_meta( $document->attachment_id, 'bp_document_parent_activity_id', $parent_activity_id );
					}
				}
			}
		} else {
			if ( $parent_activity_id ) {
				if ( empty( $bp_new_activity_comment ) ) {
					$parent_activity_id = $bp_new_activity_comment;
					$document->privacy  = 'comment';
				}
				// save document activity id
				$document->activity_id = $parent_activity_id;
				$document->save();
				// save parent activity id in attachment meta
				update_post_meta( $document->attachment_id, 'bp_document_parent_activity_id', $parent_activity_id );
			}
		}
	}
}

/**
 * Create main activity for the media uploaded and saved.
 *
 * @param $document_ids
 *
 * @return mixed
 * @since BuddyBoss 1.2.0
 */
function bp_activity_create_parent_document_activity( $document_ids ) {
	global $bp_document_upload_count, $bp_activity_post_update, $bp_document_upload_activity_content, $bp_activity_post_update_id, $bp_activity_edit;
	if ( ! empty( $document_ids ) && empty( $bp_activity_post_update ) && ! isset( $_POST['edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$added_document_ids = $document_ids;
		$content            = false;
		if ( ! empty( $bp_document_upload_activity_content ) ) {
			/**
			 * Filters the content provided in the activity input field.
			 *
			 * @param string $value Activity message being posted.
			 *
			 * @since BuddyPress 1.2.0
			 */
			$content = apply_filters( 'bp_activity_post_update_content', $bp_document_upload_activity_content );
		}
		$group_id  = FILTER_INPUT( INPUT_POST, 'group_id', FILTER_SANITIZE_NUMBER_INT );
		$folder_id = false;
		// added fall back to get group_id from document.
		if ( empty( $group_id ) && ! empty( $added_document_ids ) ) {
			$document_object = new BP_Document( current( (array) $added_document_ids ) );
			if ( ! empty( $document_object->group_id ) ) {
				$group_id = $document_object->group_id;
			}
		}
		if ( bp_is_active( 'groups' ) && ! empty( $group_id ) && $group_id > 0 ) {
			$activity_id = groups_post_update(
				array(
					'content'  => $content,
					'group_id' => $group_id,
				)
			);
		} else {
			$activity_id = bp_activity_post_update( array( 'content' => $content ) );
		}
		// save document meta for activity.
		if ( ! empty( $activity_id ) ) {
			$privacy = 'public';
			foreach ( (array) $added_document_ids as $document_id ) {
				$document = new BP_Document( $document_id );
				// get one of the media's privacy for the activity privacy.
				$privacy = $document->privacy;
				// get document folder id.
				if ( ! empty( $document->folder_id ) ) {
					$folder_id = $document->folder_id;
				}
				if ( 1 === $bp_document_upload_count ) {
					// save media activity id in media.
					$document->activity_id = $activity_id;
					$document->group_id    = $group_id;
					$document->save();
				}
				// save parent activity id in attachment meta.
				update_post_meta( $document->attachment_id, 'bp_document_parent_activity_id', $activity_id );
			}
			bp_activity_update_meta( $activity_id, 'bp_document_ids', implode( ',', $added_document_ids ) );
			// if document is from folder then save folder id in activity meta.
			if ( ! empty( $folder_id ) ) {
				bp_activity_update_meta( $activity_id, 'bp_document_folder_activity', $folder_id );
			}
			if ( empty( $group_id ) ) {
				$main_activity = new BP_Activity_Activity( $activity_id );
				if ( ! empty( $main_activity ) ) {
					$main_activity->privacy = $privacy;
					$main_activity->save();
				}
			}
		}
	}

	return $document_ids;
}

/**
 * Update document and activity for document updation and deletion while editing the activity.
 *
 * @param $document_ids
 *
 * @return mixed
 * @since BuddyBoss 1.5.0
 */
function bp_activity_edit_update_document( $document_ids ) {
	global $bp_activity_edit, $bp_activity_post_update_id;
	if ( ( true === $bp_activity_edit || isset( $_POST['edit'] ) ) && ! empty( $bp_activity_post_update_id ) ) {
		$old_document_ids = bp_activity_get_meta( $bp_activity_post_update_id, 'bp_document_ids', true );
		$old_document_ids = explode( ',', $old_document_ids );
		if ( ! empty( $old_document_ids ) ) {
			// old document count 1 and new document uploaded count is greater than 1.
			if ( 1 === count( $old_document_ids ) && 1 < count( $document_ids ) ) {
				$old_document_id = $old_document_ids[0];
				// check if old document id is in new document uploaded.
				if ( in_array( $old_document_id, $document_ids ) ) {
					// Create new document activity for old document because it has only parent activity to show right now.
					$old_document = new BP_Document( $old_document_id );
					$args         = array(
						'hide_sitewide' => true,
						'privacy'       => 'document',
					);
					if ( ! empty( $old_document->group_id ) && bp_is_active( 'groups' ) ) {
						$args['item_id'] = $old_document->group_id;
						$args['type']    = 'activity_update';
						$current_group   = groups_get_group( $old_document->group_id );
						$args['action']  = sprintf( __( '%1$s posted an update in the group %2$s', 'buddyboss' ), bp_core_get_userlink( $old_document->user_id ), '<a href="' . bp_get_group_permalink( $current_group ) . '">' . esc_attr( $current_group->name ) . '</a>' );
						$activity_id     = groups_record_activity( $args );
					} else {
						$activity_id = bp_activity_post_update( $args );
					}
					// document activity for old document is created and it is being assigned to the old document.
					// And document activity is being saved with needed data to figure out everything for it.
					if ( $activity_id ) {
						$old_document->activity_id = $activity_id;
						$old_document->save();
						$document_activity                    = new BP_Activity_Activity( $activity_id );
						$document_activity->secondary_item_id = $bp_activity_post_update_id;
						$document_activity->save();
						// update activity meta to tell it is document activity.
						bp_activity_update_meta( $activity_id, 'bp_document_activity', '1' );
						bp_activity_update_meta( $activity_id, 'bp_document_id', $old_document->id );
						// save attachment meta for activity.
						update_post_meta( $old_document->attachment_id, 'bp_document_activity_id', $activity_id );
						// save parent activity id in attachment meta.
						update_post_meta( $old_document->attachment_id, 'bp_document_parent_activity_id', $bp_activity_post_update_id );
					}
				}
				// old document count is greater than 1 and new document uploaded count is only 1 now.
			} elseif ( 1 < count( $old_document_ids ) && 1 === count( $document_ids ) ) {
				$new_document_id = $document_ids[0];
				// check if new document is in old document uploaded, if yes then delete that document's document activity first.
				if ( in_array( $new_document_id, $old_document_ids ) ) {
					$new_document         = new BP_Document( $new_document_id );
					$document_activity_id = $new_document->activity_id;
					// delete document's assigned document activity.
					remove_action( 'bp_activity_after_delete', 'bp_document_delete_activity_document' );
					bp_activity_delete( array( 'id' => $document_activity_id ) );
					add_action( 'bp_activity_after_delete', 'bp_document_delete_activity_document' );
					// save parent activity id in document.
					$new_document->activity_id = $bp_activity_post_update_id;
					$new_document->save();
					// save parent activity id in attachment meta.
					update_post_meta( $new_document->attachment_id, 'bp_document_parent_activity_id', $bp_activity_post_update_id );
				}
				// old document and new document count is same and old document and new document are different.
			} elseif ( 1 === count( $old_document_ids ) && 1 === count( $document_ids ) ) {
				$new_document_id = $document_ids[0];
				// check if new document is not in old document uploaded and.
				if ( ! in_array( $new_document_id, $old_document_ids ) ) {
					$old_document_id = $old_document_ids[0];
					$old_document    = new BP_Document( $old_document_id );
					// unset the activity id for old document and save it to save activity from deleting after.
					if ( ! empty( $old_document->id ) ) {
						$old_document->activity_id = false;
						$old_document->save();
						// delete attachment activity id meta.
						delete_post_meta( $old_document->attachment_id, 'bp_document_parent_activity_id' );
					}
				}
			}
		}
	}

	return $document_ids;
}

/**
 * We removing the Edit Button on Document/Media Activity popup until we fully support on popup.
 *
 * @param $buttons
 * @param $activity_id
 *
 * @return mixed
 * @since BuddyBoss 1.5.0
 */
function bp_nouveau_remove_edit_activity_entry_buttons( $buttons, $activity_id ) {
	$exclude_action_arr = array( 'media_get_activity', 'document_get_activity' );
	if ( bp_is_activity_edit_enabled() && isset( $_REQUEST ) && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $exclude_action_arr, 1 ) ) {
		$activity = new BP_Activity_Activity( $activity_id );
		if ( in_array( $activity->privacy, array( 'document', 'media' ), 1 ) ) {
			unset( $buttons['activity_edit'] );
		}
	}

	return $buttons;
}

add_action( 'bp_before_activity_activity_content', 'bp_blogs_activity_content_set_temp_content' );
/**
 * Function which set the temporary content on the blog post activity.
 *
 * @since BuddyBoss 1.5.5
 */
function bp_blogs_activity_content_set_temp_content() {
	global $activities_template;
	$activity = $activities_template->activity;
	if ( ( 'blogs' === $activity->component ) && isset( $activity->secondary_item_id ) && 'new_blog_' . get_post_type( $activity->secondary_item_id ) === $activity->type ) {
		$content = get_post( $activity->secondary_item_id );
		// If we converted $content to an object earlier, flip it back to a string.
		if ( is_a( $content, 'WP_Post' ) ) {
			$activities_template->activity->content = '&#8203;';
		}
	} elseif ( 'blogs' === $activity->component && 'new_blog_comment' === $activity->type && $activity->secondary_item_id && $activity->secondary_item_id > 0 ) {
		$activities_template->activity->content = '&#8203;';
	}
}

add_filter( 'bp_get_activity_content_body', 'bp_blogs_activity_content_with_read_more', 9999, 2 );
/**
 * Function which set the content on activity blog post.
 *
 * @param $content
 * @param $activity
 *
 * @return string
 *
 * @since BuddyBoss 1.5.5
 */
function bp_blogs_activity_content_with_read_more( $content, $activity ) {
	if ( ( 'blogs' === $activity->component ) && isset( $activity->secondary_item_id ) && 'new_blog_' . get_post_type( $activity->secondary_item_id ) === $activity->type ) {
		$blog_post = get_post( $activity->secondary_item_id );
		// If we converted $content to an object earlier, flip it back to a string.
		if ( is_a( $blog_post, 'WP_Post' ) ) {
			$content = bp_create_excerpt( bp_strip_script_and_style_tags( html_entity_decode( $blog_post->post_content ) ) );
			if ( false !== strrpos( $content, __( '&hellip;', 'buddyboss' ) ) ) {
				$content     = str_replace( ' [&hellip;]', '&hellip;', $content );
				$append_text = apply_filters( 'bp_activity_excerpt_append_text', __( ' Read more', 'buddyboss' ) );
				$content     = sprintf( '%1$s<span class="activity-blog-post-link"><a href="%2$s" rel="nofollow">%3$s</a></span>', $content, get_permalink( $blog_post ), $append_text );
				$content     = apply_filters_ref_array( 'bp_get_activity_content', array( $content, $activity ) );
				preg_match( '/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches );
				if ( isset( $matches ) && array_key_exists( 0, $matches ) && ! empty( $matches[0] ) ) {
					$iframe   = $matches[0];
					$content  = strip_tags( preg_replace( '/<iframe.*?\/iframe>/i', '', $content ), '<a>' );
					$content .= $iframe;
				} else {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $blog_post->ID ), 'full', false );
					if ( isset( $src[0] ) ) {
						$content .= sprintf( ' <img src="%s">', esc_url( $src[0] ) );
					}
				}
			} else {
				$content = apply_filters_ref_array( 'bp_get_activity_content', array( $content, $activity ) );
				$content = strip_tags( $content, '<a><iframe>' );
				preg_match( '/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches );
				if ( isset( $matches ) && array_key_exists( 0, $matches ) && ! empty( $matches[0] ) ) {
					$content = $content;
				} else {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $blog_post->ID ), 'full', false );
					if ( isset( $src[0] ) ) {
						$content .= sprintf( ' <img src="%s">', esc_url( $src[0] ) );
					}
				}
			}
		}
	} elseif ( 'blogs' === $activity->component && 'new_blog_comment' === $activity->type && $activity->secondary_item_id && $activity->secondary_item_id > 0 ) {
		$comment = get_comment( $activity->secondary_item_id );
		$content = bp_create_excerpt( html_entity_decode( $comment->comment_content ) );
		if ( false !== strrpos( $content, __( '&hellip;', 'buddyboss' ) ) ) {
			$content     = str_replace( ' [&hellip;]', '&hellip;', $content );
			$append_text = apply_filters( 'bp_activity_excerpt_append_text', __( ' Read more', 'buddyboss' ) );
			$content     = sprintf( '%1$s<span class="activity-blog-post-link"><a href="%2$s" rel="nofollow">%3$s</a></span>', $content, get_comment_link( $activity->secondary_item_id ), $append_text );
		}
	}

	return $content;
}

add_filter( 'bp_get_activity_content', 'bp_blogs_activity_comment_content_with_read_more', 9999, 2 );
/**
 * Function which set the content on activity blog post comment.
 *
 * @param $content
 * @param $activity
 *
 * @return string
 * @since BuddyBoss 1.5.5
 */
function bp_blogs_activity_comment_content_with_read_more( $content, $activity ) {
	if ( 'activity_comment' === $activity->type && $activity->item_id && $activity->item_id > 0 ) {
		// Get activity object.
		$comment_activity = new BP_Activity_Activity( $activity->item_id );
		if ( 'blogs' === $comment_activity->component && isset( $comment_activity->secondary_item_id ) && 'new_blog_' . get_post_type( $comment_activity->secondary_item_id ) === $comment_activity->type ) {
			$comment_post_type = $comment_activity->secondary_item_id;
			$get_post_type     = get_post_type( $comment_post_type );
			$comment_id        = bp_activity_get_meta( $activity->id, 'bp_blogs_' . $get_post_type . '_comment_id', true );
			if ( $comment_id ) {
				$comment = get_comment( $comment_id );
				$content = bp_create_excerpt( html_entity_decode( $comment->comment_content ) );
				if ( false !== strrpos( $content, __( '&hellip;', 'buddyboss' ) ) ) {
					$content     = str_replace( ' [&hellip;]', '&hellip;', $content );
					$append_text = apply_filters( 'bp_activity_excerpt_append_text', __( ' Read more', 'buddyboss' ) );
					$content     = sprintf( '%1$s<span class="activity-blog-post-link"><a href="%2$s" rel="nofollow">%3$s</a></span>', $content, get_comment_link( $comment_id ), $append_text );
				}
			}
		}
	}

	return $content;
}

/**
 * Function which register a new checkbox for media comment migration for activity in Repair community in the tool menu.
 *
 * @param array $repair_list List of all repair items.
 *
 * @return array Repair list items.
 */
function bb_activity_media_document_migration( $repair_list ) {
	$repair_list[] = array(
		'bp-repair-activity-media',
		__( 'Repair Media Comments on the Activity/News Feed.', 'buddyboss' ),
		'bb_activity_media_document_migration_process',
	);

	return $repair_list;
}

/**
 * Function which set the media/document migration for the activity section.
 *
 * @return array Return array with next offset and message.
 */
function bb_activity_media_document_migration_process() {
	global $wpdb;
	$bp                  = buddypress();
	$activity_table_name = $bp->activity->table_name;
	$offset              = filter_input( INPUT_POST, 'offset', FILTER_VALIDATE_INT );
	if ( 1 === $offset ) {
		$offset = 0;
	} else {
		$offset = $offset;
	}
	$active_post_types = get_post_types( array( 'public' => true ) );
	$bp_exclude_cpt    = array(
		'forum',
		'topic',
		'reply',
		'page',
		'attachment',
		'bp-group-type',
		'bp-member-type',
	);
	$post_type_arr     = array();
	foreach ( $active_post_types as $post_type_name ) {
		if ( ! in_array( $post_type_name, $bp_exclude_cpt, true ) ) {
			$post_type_arr[] = $post_type_name;
		}
	}
	// Get root elements id for the activity.
	$count_recepient_qry = 'SELECT COUNT(id) as ids FROM ' . $activity_table_name . ' WHERE ( item_id=0 AND secondary_item_id=0 )';
	if ( ! empty( $post_type_arr ) ) {
		foreach ( $post_type_arr as $get_post_type ) {
			$db_type_name         = 'new_blog_' . $get_post_type;
			$count_recepient_qry .= " OR ( component='blogs' AND type='" . $db_type_name . "' )";
		}
	}
	$recipients_count_row_data = $wpdb->get_row( $count_recepient_qry );
	bb_migration_write_log( ' count_recepient_qry - ' . $count_recepient_qry );
	$recipients_query = 'SELECT id FROM ' . $activity_table_name . ' WHERE ( item_id=0 AND secondary_item_id=0 )';
	if ( ! empty( $post_type_arr ) ) {
		foreach ( $post_type_arr as $get_post_type ) {
			$db_type_name      = 'new_blog_' . $get_post_type;
			$recipients_query .= ' OR ( component="blogs" AND type="' . $db_type_name . '" )';
		}
	}
	if ( 1 < (int) $recipients_count_row_data->ids ) {
		$recipients_query .= ' LIMIT ' . $offset . ', 2';
	}
	bb_migration_write_log( 'recipients_query - ' . $recipients_query );
	$recipients = $wpdb->get_results( $recipients_query );
	if ( ! empty( $recipients ) ) {
		$records_updated = '';
		foreach ( $recipients as $get_parent_id ) {
			$check_media_migration = bp_activity_get_meta( $get_parent_id->id, 'bp_media_comment_migration', true );
			if ( 'success' !== $check_media_migration ) {
				$args = array(
					'display_comments' => true,
					'show_hidden'      => true,
					'sort'             => 'ASC',
					'activity_ids'     => $get_parent_id->id,
				);
				bb_migration_write_log( 'Main Parent Id - ' . $get_parent_id->id );
				$activity_data         = bp_activity_get_specific( $args );
				$new_seq               = array();
				$sub_data              = array();
				$sub_activity_id_store = array();
				if ( isset( $activity_data['activities'] ) ) {
					foreach ( $activity_data['activities'] as $comment_data ) {
						// Check if current activity has children.
						if ( $comment_data->children ) {
							// if current activity has children then get all the children for this activity.
							$sub_data                              = bb_migration_get_children_data(
								$sub_activity_id_store,
								$sub_data,
								$comment_data->children,
								$get_parent_id->id
							);
							$new_seq[ $comment_data->id ]['child'] = $sub_data['child_array'];
							$sub_activity_id_store                 = $sub_data['activity_id_store'];
						}
					}
					if ( ! empty( $sub_activity_id_store ) ) {
						// Remove id which type is activity_update and privacy is media.
						// Update in meta when migration complete for the root id.
						bb_migration_remove_activity_id_activity_update_type( $sub_activity_id_store, $get_parent_id->id );
						bp_activity_update_meta( $get_parent_id->id, 'bp_media_comment_migration', 'success' );
						/* translators: %s refers to how many numbers running at that process */
						$records_updated = sprintf( __( '%s media comment migrated successfully.', 'buddyboss' ), number_format_i18n( $offset ) );
					} else {
						/* translators: %s refers to how many numbers running at that process */
						$records_updated = sprintf( __( '%s no media comment available.', 'buddyboss' ), number_format_i18n( $offset ) );
					}
				}
			} else {
				/* translators: %s refers to how many numbers running at that process */
				$records_updated = sprintf( __( '%s media already migrated.', 'buddyboss' ), number_format_i18n( $offset ) );
			}
			$offset ++;
		}
		bb_migration_write_log( 'offset - ' . $offset );
		bb_migration_write_log( '$recipients_count_row_data->ids - ' . $recipients_count_row_data->ids );
		if ( 1 === (int) $recipients_count_row_data->ids || (int) $offset === (int) $recipients_count_row_data->ids ) {
			return array(
				'status'  => 1,
				'message' => __( 'media comment migration complete!', 'buddyboss' ),
			);
		} else {
			return array(
				'status'  => 'running',
				'offset'  => $offset,
				'records' => $records_updated,
			);
		}
	} else {
		return array(
			'status'  => 1,
			'message' => __( 'media comment migration complete!', 'buddyboss' ),
		);
	}
}

/**
 * Function which get children data based on root element id. Its also get child data based on his parent id.
 *
 * @param array $activity_id_store Store children data and check for the duplicate.
 * @param array $sub_data          Get array of parent ids children data. Its work as herarchical array.
 * @param array $children_array    Array of children data. Here all childrens check his own children.
 *                                 If any children have its own child data then it will store in $sub_data array.
 * @param int   $main_root_id      Main root element id.
 *
 * @return array|void Return array with child_array and activity_id_store
 */
function bb_migration_get_children_data( $activity_id_store, $sub_data, $children_array, $main_root_id ) {
	global $wpdb;
	$bp                   = buddypress();
	$activity_table_name  = $bp->activity->table_name;
	$child_array          = array();
	$main_sub_child_array = array();
	foreach ( $children_array as $children_data ) {
		$activity_id_store = array_map( 'intval', $activity_id_store );
		if ( in_array( (int) $children_data->id, $activity_id_store, true ) ) {
			return;
		}
		$activity_id_store[] = $children_data->id;
		// Get children data based on its parent id.
		$args            = array(
			'display_comments' => true,
			'show_hidden'      => true,
			'sort'             => 'ASC',
			'activity_ids'     => $children_data->id,
		);
		$activity_data   = bp_activity_get_specific( $args );
		$sub_child_array = array();
		foreach ( $activity_data['activities'] as $comment_data ) {
			// Check if current activity has children.
			if ( ! empty( $comment_data->children ) ) {
				$activity_id_store[] = $comment_data->id;
				// Update mptt_right and secondary_item_id for the activity.
				bb_migration_get_activity_data_and_update(
					$comment_data->id,
					$comment_data->mptt_left,
					$comment_data->mptt_right,
					$comment_data->item_id,
					$comment_data->secondary_item_id,
					$comment_data->type,
					$comment_data->privacy,
					$main_root_id
				);
				// if current activity has children then get all the children for this activity.
				$sub_child_d           = bb_migration_get_children_data(
					$activity_id_store,
					$sub_data,
					$comment_data->children,
					$main_root_id
				);
				$sub_child_array       = $sub_child_d['child_array'];
				$new_activity_id_store = $sub_child_d['activity_id_store'];
				if ( ! empty( $new_activity_id_store ) ) {
					$activity_id_store = array_unique( array_merge( $activity_id_store, $new_activity_id_store ), SORT_REGULAR );
				}
				// Check media activity exists in the activity id - If yes then get all comments for this media activity.
				$sub_data = $wpdb->get_results( $wpdb->prepare( 'SELECT id FROM ' . $activity_table_name . ' WHERE item_id=0 AND secondary_item_id=%d', (int) $comment_data->id ) );
				if ( ! empty( $sub_data ) ) {
					foreach ( $sub_data as $get_sub_sub_data ) {
						$media_update_id    = $get_sub_sub_data->id;
						$sargs              = array(
							'display_comments' => true,
							'show_hidden'      => true,
							'sort'             => 'ASC',
							'activity_ids'     => $media_update_id,
						);
						$sget_activity_data = bp_activity_get_specific( $sargs );
						foreach ( $sget_activity_data['activities'] as $key => $scomment_data ) {
							// Check children exists in the media comments activity.
							if ( ! empty( $scomment_data->children ) ) {
								$activity_id_store[] = $get_sub_sub_data->id;
								$activity_id_store[] = $scomment_data->id;
								// It will update mptt_right and secondary_item_id for the media's activity which have children.
								bb_migration_get_activity_data_and_update(
									$scomment_data->id,
									$scomment_data->mptt_left,
									$scomment_data->mptt_right,
									$scomment_data->item_id,
									$scomment_data->secondary_item_id,
									$scomment_data->type,
									$scomment_data->privacy,
									$main_root_id
								);
								// if current activity has children then get all the children for this activity.
								$sub_child_d                                      = bb_migration_get_children_data(
									$activity_id_store,
									$sub_data,
									$scomment_data->children,
									$main_root_id
								);
								$sub_child_array[ $media_update_id ]['new_child'] = $sub_child_d['child_array'];
								$new_activity_id_store                            = $sub_child_d['activity_id_store'];
								if ( ! empty( $new_activity_id_store ) ) {
									$activity_id_store = array_unique( array_merge( $activity_id_store, $new_activity_id_store ), SORT_REGULAR );
								}
							} else {
								$activity_id_store[] = $scomment_data->id;
								// It will update mptt_right and secondary_item_id for the media's activity which have not children.
								bb_migration_get_activity_data_and_update(
									$scomment_data->id,
									$scomment_data->mptt_left,
									$scomment_data->mptt_right,
									$scomment_data->item_id,
									$scomment_data->secondary_item_id,
									$scomment_data->type,
									$scomment_data->privacy,
									$main_root_id
								);
							}
						}
					}
				}
			} else {
				$activity_id_store[] = $comment_data->id;
				// It will update mptt_right and secondary_item_id for the parents activity id which have not children.
				bb_migration_get_activity_data_and_update(
					$comment_data->id,
					$comment_data->mptt_left,
					$comment_data->mptt_right,
					$comment_data->item_id,
					$comment_data->secondary_item_id,
					$comment_data->type,
					$comment_data->privacy,
					$main_root_id
				);
				// if children empty then check media comment exists for that's activity id.
				$sub_data = $wpdb->get_results( $wpdb->prepare( 'SELECT id from ' . $activity_table_name . ' WHERE item_id=%d OR secondary_item_id=%d', (int) $comment_data->id, (int) $comment_data->id ) );
				if ( ! empty( $sub_data ) ) {
					foreach ( $sub_data as $sub_sub_data ) {
						$args = array(
							'display_comments' => true,
							'show_hidden'      => true,
							'sort'             => 'ASC',
							'activity_ids'     => $sub_sub_data->id,
						);
						// Get secondary item id based on media activity comment id - Which type will activity_update.
						$activity_data = bp_activity_get_specific( $args );
						foreach ( $activity_data['activities'] as $key => $m_comment_data ) {
							// Check children exists in the media comments activity.
							if ( ! empty( $m_comment_data->children ) ) {
								$activity_id_store[] = $sub_sub_data->id;
								$activity_id_store[] = $m_comment_data->id;
								// It will update mptt_right and secondary_item_id for the media's activity which have children.
								bb_migration_get_activity_data_and_update(
									$m_comment_data->id,
									$m_comment_data->mptt_left,
									$m_comment_data->mptt_right,
									$m_comment_data->item_id,
									$m_comment_data->secondary_item_id,
									$m_comment_data->type,
									$m_comment_data->privacy,
									$main_root_id
								);
								// if current activity has children then get all the children for this activity.
								$sub_child_d                                       = bb_migration_get_children_data(
									$activity_id_store,
									$sub_data,
									$m_comment_data->children,
									$main_root_id
								);
								$sub_child_array[ $sub_sub_data->id ]['new_child'] = $sub_child_d['child_array'];
								$new_activity_id_store                             = $sub_child_d['activity_id_store'];
								if ( ! empty( $new_activity_id_store ) ) {
									$activity_id_store = array_unique( array_merge( $activity_id_store, $new_activity_id_store ), SORT_REGULAR );
								}
							} else {
								$activity_id_store[] = $m_comment_data->id;
								// It will update mptt_right and secondary_item_id for the media's activity which have not children.
								bb_migration_get_activity_data_and_update(
									$m_comment_data->id,
									$m_comment_data->mptt_left,
									$m_comment_data->mptt_right,
									$m_comment_data->item_id,
									$m_comment_data->secondary_item_id,
									$m_comment_data->type,
									$m_comment_data->privacy,
									$main_root_id
								);
							}
						}
					}
				}
			}
			$main_sub_child_array = $sub_child_array;
		}
		$child_array[ $children_data->id ] = $main_sub_child_array;
	}
	$return_array = array(
		'child_array'       => $child_array,
		'activity_id_store' => $activity_id_store,
	);

	return $return_array;
}

/**
 * Function which get new secondary item for the media/document comments.
 *
 * @param int    $comment_id        Comment id.
 * @param int    $mppt_left         Left position of comment.
 * @param int    $mptt_right        Right position of comment.
 * @param int    $item_id           Item id of the comment.
 * @param int    $secondary_item_id Secondary item id of the comment.
 * @param string $comment_type      Type of the comment.
 * @param string $comment_privacy   Privacy of the comment.
 * @param int    $main_root_id      Main root comment id.
 *
 * @uses bb_activity_update_data() Use this function for the update data based data.
 */
function bb_migration_get_activity_data_and_update( $comment_id, $mppt_left, $mptt_right, $item_id, $secondary_item_id, $comment_type, $comment_privacy, $main_root_id ) {
	global $wpdb;
	$bp                    = buddypress();
	$activity_table_name   = $bp->activity->table_name;
	$new_secondary_item_id = $secondary_item_id;
	if ( (int) $item_id === (int) $secondary_item_id ) {
		$old_secondary_item_id = $wpdb->get_row( $wpdb->prepare( 'SELECT secondary_item_id FROM ' . $activity_table_name . ' WHERE id=%d', $item_id ) );
		if ( ! empty( $old_secondary_item_id ) ) {
			$new_secondary_item_id = $old_secondary_item_id->secondary_item_id;
			// If secondary item id is zero then it will consider old secondary item.
			if ( 0 === (int) $new_secondary_item_id ) {
				$new_secondary_item_id = $secondary_item_id;
			}
		}
	}
	// Update activity id in media table and also update privacy for activity.
	bb_activity_update_data( $comment_id, $new_secondary_item_id, $main_root_id, $mptt_right, $comment_type );
}

/**
 * Function which update fields in activity table. It will update mppt_right, secondary_item_id based on its parent id.
 *
 * @param int    $comment_id            Comment id.
 * @param int    $new_secondary_item_id Change secondary item id of the comment based on move.
 * @param int    $main_root_id          Main root comment id.
 * @param int    $mptt_right            Right position of comment.
 * @param string $comment_type          Type of comment.
 */
function bb_activity_update_data( $comment_id, $new_secondary_item_id, $main_root_id, $mptt_right, $comment_type ) {
	global $wpdb;
	$bp                  = buddypress();
	$activity_table_name = $bp->activity->table_name;
	$media_table_name    = $bp->media->table_name;
	$document_table_name = $bp->document->table_name;
	// Update current mptt_right, item_id & secondary_item_id for current comment.
	if ( (int) $comment_id !== (int) $main_root_id ) {
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . $activity_table_name . ' SET mptt_right = %d,item_id = %d, secondary_item_id = %d WHERE id = %d', intval( $mptt_right + 1 ), $main_root_id, $new_secondary_item_id, $comment_id ) );
		// Get mptt_right for root comment.
		$mptt_data_for_main_root_id = $wpdb->get_row( $wpdb->prepare( 'SELECT mptt_left, mptt_right FROM ' . $activity_table_name . ' WHERE id=%d', $main_root_id ) );
		if ( ! empty( $mptt_data_for_main_root_id ) ) {
			// Update mptt_right for root comment.
			$new_mppt_right_for_parent_id = intval( $mptt_data_for_main_root_id->mptt_right + 1 );
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $activity_table_name . ' SET mptt_right = %d WHERE id = %d', $new_mppt_right_for_parent_id, $main_root_id ) );
		}
	}
	if ( (int) $comment_id !== (int) $new_secondary_item_id ) {
		// Get mptt_right for secondary comment.
		$mptt_data_for_new_secondary_item_id = $wpdb->get_row( $wpdb->prepare( 'SELECT mptt_left, mptt_right FROM ' . $activity_table_name . ' WHERE id=%d', $new_secondary_item_id ) );
		if ( ! empty( $mptt_data_for_new_secondary_item_id ) ) {
			// Update mptt_right for secondary comment.
			$new_mppt_right_for_si_id = intval( $mptt_data_for_new_secondary_item_id->mptt_right + 1 );
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $activity_table_name . ' SET mptt_right = %d WHERE id = %d', $new_mppt_right_for_si_id, $new_secondary_item_id ) );
		}
	}
	// Update privacy in activity table and media table.
	if ( 'activity_update' !== $comment_type ) {
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . $activity_table_name . ' SET privacy = %s WHERE id = %d', 'public', $comment_id ) );
	} elseif ( 'activity_update' === $comment_type ) {
		if ( (int) $comment_id !== (int) $main_root_id ) {
			$secondary_item_id_for_current_comment_id = $wpdb->get_row( $wpdb->prepare( 'SELECT secondary_item_id FROM ' . $activity_table_name . ' WHERE id=%d AND type=%s', $comment_id, $comment_type ) );
			if ( ! empty( $secondary_item_id_for_current_comment_id ) ) {
				$get_au_id = $secondary_item_id_for_current_comment_id->secondary_item_id;
				// Check activity id exists in media table.
				$check_activity_id_exists_for_media_sql = $wpdb->get_row( $wpdb->prepare( 'SELECT activity_id FROM ' . $media_table_name . ' WHERE activity_id=%d', $comment_id ) );
				if ( ! empty( $check_activity_id_exists_for_media_sql ) && isset( $check_activity_id_exists_for_media_sql->activity_id ) ) {
					// Update activity id in media table.
					$wpdb->query( $wpdb->prepare( 'UPDATE ' . $media_table_name . ' SET privacy = %s,activity_id = %d WHERE activity_id = %d', 'comment', $get_au_id, $comment_id ) );
				}
				// Check activity id exists in document table.
				$check_activity_id_exists_for_doc_sql = $wpdb->get_row( $wpdb->prepare( 'SELECT activity_id FROM ' . $document_table_name . ' WHERE activity_id=%d', $comment_id ) );
				if ( ! empty( $check_activity_id_exists_for_doc_sql ) && isset( $check_activity_id_exists_for_doc_sql->activity_id ) ) {
					// Update activity id in media table.
					$wpdb->query( $wpdb->prepare( 'UPDATE ' . $document_table_name . ' SET privacy = %s,activity_id = %d WHERE activity_id = %d', 'comment', $get_au_id, $comment_id ) );
				}
			}
		}
	}
}

/**
 * Function which will deletes activity id whose type would activity_update and privacy would media from the activity table.
 *
 * @param array $activity_ids Array of activity_ids.
 * @param int   $main_root_id Main root activity id.
 */
function bb_migration_remove_activity_id_activity_update_type( $activity_ids, $main_root_id ) {
	// Deletes activity id whose type would activity_update and privacy would media from the activity table.
	global $wpdb;
	$bp                  = buddypress();
	$activity_table_name = $bp->activity->table_name;
	if ( ! empty( $activity_ids ) ) {
		foreach ( $activity_ids as $child_id ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $activity_table_name . ' WHERE id = %d AND item_id=%s AND type=%s AND ( privacy=%s OR privacy=%s )', $child_id, $main_root_id, 'activity_update', 'media', 'document' ) );
		}
	}
}

/**
 * Function which set error log for the migration data.
 *
 * @param string|array $log string|array|object Its message or data which we will add in log file.
 */
function bb_migration_write_log( $log ) {
	$message = gmdate( 'Y-m-d H:i:s - ' );
	if ( is_string( $log ) ) {
		$message .= $log . "\r\n";
	}
	$log_file_path = WP_CONTENT_DIR . '/media_migration_debug.log';
	if ( ! file_exists( $log_file_path ) ) {
		fopen( $log_file_path, 'w' );
	}
	if ( is_array( $log ) || is_object( $log ) ) {
		error_log( print_r( $log, true ), 3, $log_file_path );
	} else {
		error_log( $message, 3, $log_file_path );
	}
}
