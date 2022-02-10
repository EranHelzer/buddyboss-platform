<?php
/**
 * BuddyBoss Messages Notification Class.
 *
 * @package BuddyBoss\Messages
 *
 * @since BuddyBoss [BBVERSION]
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set up the BP_Messages_Notification class.
 *
 * @since BuddyBoss [BBVERSION]
 */
class BP_Messages_Notification extends BP_Core_Notification_Abstract {

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
	 * @return null|BP_Messages_Notification|Controller|object
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
		$this->register_preferences_group(
			'messages',
			esc_html__( 'Messages', 'buddyboss' ),
			esc_html__( 'Private Messaging', 'buddyboss' ),
			4
		);

		$this->register_notification_for_new_message();
	}

	/**
	 * Register notification for user new message.
	 */
	public function register_notification_for_new_message() {
		$this->register_preference(
			'notification_messages_new_message',
			esc_html__( 'A member sends you a new message', 'buddyboss' ),
			esc_html__( 'A member receives a new message', 'buddyboss' ),
			'messages'
		);

		$this->register_email_type(
			'messages-unread',
			array(
				/* translators: do not remove {} brackets or translate its contents. */
				'post_title'   => __( '[{{{site.name}}}] New message from {{sender.name}}', 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'post_content' => __( "{{sender.name}} sent you a new message.\n\n{{{message}}}", 'buddyboss' ),
				/* translators: do not remove {} brackets or translate its contents. */
				'post_excerpt' => __( "{{sender.name}} sent you a new message.\n\n{{{message}}}\"\n\nGo to the discussion to reply or catch up on the conversation: {{{message.url}}}", 'buddyboss' ),
			),
			array(
				'description' => __( 'Recipient has received a private message.', 'buddyboss' ),
				'unsubscribe' => array(
					'meta_key' => 'notification_messages_new_message',
					'message'  => __( 'You will no longer receive emails when someone sends you a message.', 'buddyboss' ),
				),
			),
			'notification_messages_new_message'
		);

		$this->register_notification(
			'messages',
			'new_message',
			'notification_messages_new_message'
		);
	}

	/**
	 * Format the notifications.
	 *
	 * @since BuddyBoss [BBVERSION]
	 *
	 * @param int    $item_id               Notification item ID.
	 * @param int    $secondary_item_id     Notification secondary item ID.
	 * @param int    $action_item_count     Number of notifications with the same action.
	 * @param string $format                Format of return. Either 'string' or 'object'.
	 * @param string $component_action_name Canonical notification action.
	 * @param string $component_name        Notification component ID.
	 * @param int    $notification_id       Notification ID.
	 *
	 * @return array
	 */
	public function format_notification( $item_id, $secondary_item_id, $action_item_count, $format, $component_action_name, $component_name, $notification_id ) {
		return array();
	}
}
