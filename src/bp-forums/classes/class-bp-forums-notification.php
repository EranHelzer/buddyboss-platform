<?php
/**
 * BuddyBoss Forums Notification Class.
 *
 * @package BuddyBoss\Forums
 *
 * @since BuddyBoss [BBVERSION]
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set up the BP_Forums_Notification class.
 *
 * @since BuddyBoss [BBVERSION]
 */
class BP_Forums_Notification extends BP_Core_Notification_Abstract {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Get the instance of this class.
	 *
	 * @since BuddyBoss [BBVERSION]
	 *
	 * @return null|BP_Forums_Notification|Controller|object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since BuddyBoss [BBVERSION]
	 */
	public function __construct() {
		// Initialize.
		$this->start();
	}

	/**
	 * Initialize all methods inside it.
	 *
	 * @return mixed|void
	 */
	public function load() {
		$this->register_notification_group(
			'forums',
			esc_html__( 'Forums', 'buddyboss' ),
			esc_html__( 'Forums Notifications', 'buddyboss' ),
			15
		);

		// Replies to a discussion you are subscribed.
		$this->register_notification_for_forums_following_reply();

		// Creates discussion in a forum you are subscribed.
		$this->register_notification_for_forums_following_topic();
	}



	/**
	 * Register notification for replies to a discussion you are subscribed.
	 */
	public function register_notification_for_forums_following_reply() {
		$this->register_notification_type(
			'bb_forums_subscribed_reply',
			esc_html__( 'New reply in a discussion you\'re subscribed to', 'buddyboss' ),
			esc_html__( 'A new reply in a discussion a member is subscribed to', 'buddyboss' ),
			'forums'
		);

		$this->register_email_type(
			'bbp-new-forum-reply',
			array(
				/* translators: do not remove {} brackets or translate its contents. */
				'email_title'         => __( '[{{{site.name}}}] {{poster.name}} replied to one of your forum discussions', 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'email_content'       => __( "{{poster.name}} replied to the discussion <a href=\"{{discussion.url}}\">{{discussion.title}}</a> in the forum <a href=\"{{forum.url}}\">{{forum.title}}</a>:\n\n{{{reply.content}}}", 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'email_plain_content' => __( "{{poster.name}} replied to the discussion {{discussion.title}} in the forum {{forum.title}}:\n\n{{{reply.content}}}\n\nPost Link: {{reply.url}}", 'buddyboss' ),
				'situation_label'     => __( 'A new reply in a discussion a member is subscribed to', 'buddyboss' ),
				'unsubscribe_text'    => __( 'You will no longer receive emails when a member will reply to one of your forum discussions.', 'buddyboss' ),
			),
			'bb_forums_subscribed_reply'
		);

		$this->register_notification(
			'forums',
			'bb_forums_subscribed_reply',
			'bb_forums_subscribed_reply'
		);

	}

	/**
	 * Register notification for creates discussion in a forum you are subscribed.
	 */
	public function register_notification_for_forums_following_topic() {
		$this->register_notification_type(
			'bb_forums_subscribed_discussion',
			esc_html__( 'New discussion in a forum you\'re subscribed to', 'buddyboss' ),
			esc_html__( 'A new discussion in a forum a member is subscribed to', 'buddyboss' ),
			'forums'
		);

		$this->register_email_type(
			'bbp-new-forum-topic',
			array(
				/* translators: do not remove {} brackets or translate its contents. */
				'email_title'         => __( '[{{{site.name}}}] New discussion: {{discussion.title}}', 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'email_content'       => __( "{{poster.name}} started a new discussion <a href=\"{{discussion.url}}\">{{discussion.title}}</a> in the forum <a href=\"{{forum.url}}\">{{forum.title}}</a>:\n\n{{{discussion.content}}}", 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'email_plain_content' => __( "{{poster.name}} started a new discussion {{discussion.title}} in the forum {{forum.title}}:\n\n{{{discussion.content}}}\n\nDiscussion Link: {{discussion.url}}", 'buddyboss' ),
				'situation_label'     => __( 'A new discussion in a forum a member is subscribed to', 'buddyboss' ),
				'unsubscribe_text'    => __( 'You will no longer receive emails when a member will create a new forum discussion.', 'buddyboss' ),
			),
			'bb_forums_subscribed_discussion'
		);

		$this->register_notification(
			'forums',
			'bb_forums_subscribed_discussion',
			'bb_forums_subscribed_discussion'
		);
	}

	/**
	 * Format the notifications.
	 *
	 * @since BuddyBoss [BBVERSION]
	 *
	 * @param string $content               Notification content.
	 * @param int    $item_id               Notification item ID.
	 * @param int    $secondary_item_id     Notification secondary item ID.
	 * @param int    $action_item_count     Number of notifications with the same action.
	 * @param string $format                Format of return. Either 'string' or 'object'.
	 * @param string $component_action_name Canonical notification action.
	 * @param string $component_name        Notification component ID.
	 * @param int    $notification_id       Notification ID.
	 * @param string $screen                Notification Screen type.
	 *
	 * @return array
	 */
	public function format_notification( $content, $item_id, $secondary_item_id, $action_item_count, $format, $component_action_name, $component_name, $notification_id, $screen ) {

		if ( 'forums' === $component_name && 'bb_forums_subscribed_reply' === $component_action_name ) {
			$topic_id    = bbp_get_reply_topic_id( $item_id );
			$topic_title = bbp_get_topic_title( $topic_id );
			$topic_link  = wp_nonce_url(
				add_query_arg(
					array(
						'action'   => 'bbp_mark_read',
						'topic_id' => $topic_id,
						'reply_id' => $item_id,
					),
					bbp_get_reply_url( $item_id )
				),
				'bbp_mark_topic_' . $topic_id
			);

			if ( (int) $action_item_count > 1 ) {
				$text = sprintf(
					/* translators: replies count. */
					esc_html__( 'You have %d new replies', 'buddyboss' ),
					(int) $action_item_count
				);
			} else {
				$except = bbp_get_reply_excerpt( $item_id, 50 );
				if ( ! empty( $except ) && ! empty( $secondary_item_id ) ) {
					$text = sprintf(
						/* translators: 1. Member display name. 2. excerpt. */
						esc_html__( '%1$s replied to a discussion: "%2$s"', 'buddyboss' ),
						bp_core_get_user_displayname( $secondary_item_id ),
						$except
					);
				} elseif ( ! empty( $secondary_item_id ) && empty( $except ) ) {
					$text = sprintf(
						/* translators: Member display name. */
						esc_html__( '%s replied to a discussion', 'buddyboss' ),
						bp_core_get_user_displayname( $secondary_item_id )
					);
				} else {
					$text = sprintf(
						/* translators: topic title. */
						esc_html__( 'You have a new reply to %s', 'buddyboss' ),
						$topic_title
					);
				}
			}

			$content = array(
				'text' => $text,
				'link' => $topic_link,
			);
		}

		if ( 'forums' === $component_name && 'bb_forums_subscribed_discussion' === $component_action_name ) {
			$topic_id    = bbp_get_topic_id( $item_id );
			$topic_title = bbp_get_topic_title( $topic_id );
			$topic_link  = wp_nonce_url(
				add_query_arg(
					array(
						'action'   => 'bbp_mark_read',
						'topic_id' => $topic_id,
					),
					bbp_get_topic_permalink( $topic_id )
				),
				'bbp_mark_topic_' . $topic_id
			);

			if ( (int) $action_item_count > 1 ) {
				/* translators: discussions count. */
				$text = sprintf( __( 'You have %d new discussion', 'buddyboss' ), (int) $action_item_count );
			} else {

				if ( ! empty( $secondary_item_id ) ) {
					$text = sprintf(
						/* translators: 1.Member display name 2. discussions title. */
						esc_html__( '%1$s started a discussion: "%2$s"', 'buddyboss' ),
						bp_core_get_user_displayname( $secondary_item_id ),
						$topic_title
					);
				} else {
					$text = sprintf(
						/* translators: discussions title. */
						esc_html__( 'You have a new discussion: "%s"', 'buddyboss' ),
						$topic_title
					);
				}
			}

			$content = array(
				'text' => $text,
				'link' => $topic_link,
			);
		}

		return $content;
	}
}
