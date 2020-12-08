<?php
/**
 * BuddyBoss Moderation Messages Classes
 *
 * @since   BuddyBoss 2.0.0
 * @package BuddyBoss\Moderation
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Database interaction class for the BuddyBoss moderation Messages.
 *
 * @since BuddyBoss 2.0.0
 */
class BP_Moderation_Messages extends BP_Moderation_Abstract {

	/**
	 * Item type
	 *
	 * @var string
	 */
	public static $moderation_type = 'message';

	/**
	 * BP_Moderation_Messages constructor.
	 *
	 * @since BuddyBoss 2.0.0
	 */
	public function __construct() {

		parent::$moderation[ self::$moderation_type ] = self::class;
		$this->item_type                              = self::$moderation_type;

		add_filter( 'bp_moderation_content_types', array( $this, 'add_content_types' ) );

		/**
		 * Moderation code should not add for WordPress backend or IF component is not active or Bypass argument passed for admin
		 */
		if ( ( is_admin() && ! wp_doing_ajax() ) || ! bp_is_active( 'messages' ) || self::admin_bypass_check() ) {
			return;
		}

		// Message.
		add_filter( 'bp_messages_message_get_join_sql', array( $this, 'update_join_sql' ), 10, 2 );
		add_filter( 'bp_messages_message_get_where_conditions', array( $this, 'update_where_sql' ), 10, 2 );

		// Recipient.
		add_filter( 'bp_messages_recipient_get_join_sql', array( $this, 'update_join_sql' ), 10, 2 );
		add_filter( 'bp_messages_recipient_get_where_conditions', array( $this, 'update_where_sql' ), 10, 2 );

		// button.
		add_filter( "bp_moderation_{$this->item_type}_button", array( $this, 'update_button' ), 10, 2 );

		// Delete message moderation data when message thread is deleted.
		add_action( 'bp_messages_message_delete_thread', array( $this, 'delete_moderation_data' ) );
	}

	/**
	 * Get Blocked Messages ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return array
	 */
	public static function get_sitewide_messages_hidden_ids() {
		$messages_ids = array();
		$threads      = self::get_sitewide_hidden_ids();
		if ( ! empty( $threads ) ) {
			$results = BP_Messages_Message::get(
				array(
					'fields'           => 'ids',
					'include_threads'  => $threads,
					'moderation_query' => false,
				)
			);
			if ( ! empty( $results['messages'] ) ) {
				$messages_ids = $results['messages'];
			}
		}

		return $messages_ids;
	}

	/**
	 * Get Blocked Message threads ids
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return array
	 */
	public static function get_sitewide_hidden_ids() {
		return self::get_sitewide_hidden_item_ids( self::$moderation_type );
	}

	/**
	 * Get Content owner id.
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param integer $message_id Message id.
	 *
	 * @return int
	 */
	public static function get_content_owner_id( $message_id ) {
		$message = new BP_Messages_Message( $message_id );

		return ( ! empty( $message->sender_id ) ) ? $message->sender_id : 0;
	}

	/**
	 * Get permalink
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $message_id message id.
	 *
	 * @return string
	 */
	public static function get_permalink( $message_id ) {
		$url = bp_get_message_thread_view_link( $message_id );

		return add_query_arg( array( 'modbypass' => 1 ), $url );
	}

	/**
	 * Report content
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param array $args Content data.
	 *
	 * @return string
	 */
	public static function report( $args ) {
		return parent::report( $args );
	}

	/**
	 * Add Moderation content type.
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param array $content_types Supported Contents types.
	 *
	 * @return mixed
	 */
	public function add_content_types( $content_types ) {
		$content_types[ self::$moderation_type ] = __( 'Message', 'buddyboss' );

		return $content_types;
	}

	/**
	 * Prepare Groups Join SQL query to filter blocked Messages
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param string $join_sql Messages Join sql.
	 * @param array  $args     Messages args.
	 *
	 * @return string Join sql
	 */
	public function update_join_sql( $join_sql, $args ) {

		if ( isset( $args['moderation_query'] ) && false === $args['moderation_query'] ) {
			return $join_sql;
		}

		$action_name = current_filter();

		$item_id_field = 'm.thread_id';
		if ( 'bp_messages_recipient_get_join_sql' === $action_name ) {
			$item_id_field = 'r.thread_id';
		}

		$join_sql .= $this->exclude_joint_query( $item_id_field );

		return $join_sql;
	}

	/**
	 * Prepare Messages Where SQL query to filter blocked Messages
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param string|array $where_conditions Messages Where sql.
	 * @param array        $args             Messages args.
	 *
	 * @return mixed Where SQL
	 */
	public function update_where_sql( $where_conditions, $args ) {

		if ( isset( $args['moderation_query'] ) && false === $args['moderation_query'] ) {
			return $where_conditions;
		}

		$action_name = current_filter();

		$where                   = array();
		$where['messages_where'] = $this->exclude_where_query();

		/**
		 * Exclude Blocked Groups message
		 */
		if ( bp_is_active( 'groups' ) ) {
			$groups_where = $this->exclude_group_messages_query();
			if ( ! empty( $groups_where ) ) {
				$where['groups_where'] = $groups_where;
			}
		}

		/**
		 * Filters the Messages Moderation Where SQL statement.
		 *
		 * @since BuddyBoss 2.0.0
		 *
		 * @param array $where array of Messages moderation where query.
		 */
		$where = apply_filters( 'bp_moderation_messages_get_where_conditions', $where );

		if ( ! empty( array_filter( $where ) ) ) {
			if ( 'bp_messages_recipient_get_where_conditions' === $action_name ) {
				$where_conditions .= ' AND ( ' . implode( ' AND ', $where ) . ' )';
			} else {
				$where_conditions['moderation_where'] = '( ' . implode( ' AND ', $where ) . ' )';
			}
		}

		return $where_conditions;
	}

	/**
	 * Get SQL for Exclude Blocked group related Messages
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return string|bool
	 */
	private function exclude_group_messages_query() {
		$sql         = false;
		$action_name = current_filter();

		$item_id_field = 'm.thread_id';
		if ( 'bp_messages_recipient_get_where_conditions' === $action_name ) {
			$item_id_field = 'r.thread_id';
		}

		$hidden_thread_ids = self::get_sitewide_groups_thread_hidden_ids();
		if ( ! empty( $hidden_thread_ids ) ) {
			$sql = "( {$item_id_field} NOT IN ( " . implode( ',', $hidden_thread_ids ) . ' ) )';
		}

		return $sql;
	}

	/**
	 * Get Message thread ids of blocked groups.
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return array|mixed
	 */
	private static function get_sitewide_groups_thread_hidden_ids() {
		$thread_ids = array();

		$hidden_group_ids = BP_Moderation_Groups::get_sitewide_hidden_ids();
		if ( ! empty( $hidden_group_ids ) ) {
			$messages = BP_Messages_Message::get(
				array(
					'fields'           => 'thread_ids',
					'moderation_query' => false,
					'meta_query'       => array(
						array(
							'key'     => 'group_id',
							'value'   => $hidden_group_ids,
							'compare' => 'IN',
						),
					),
				)
			);

			if ( ! empty( $messages['messages'] ) ) {
				$thread_ids = $messages['messages'];
			}
		}

		return $thread_ids;
	}

	/**
	 * Function to modify the button class
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param array  $button      Button args.
	 * @param string $is_reported Item reported.
	 *
	 * @return string
	 */
	public function update_button( $button, $is_reported ) {

		if ( $is_reported ) {
			$button['button_attr']['class'] = 'reported-content';
		} else {
			$button['button_attr']['class'] = 'report-content';
		}

		return $button;
	}

	/**
	 * Get SQL for Exclude Blocked Members related Messages
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @return string|bool
	 */
	private function exclude_member_message_query() {
		$action_name = current_filter();

		$user_id_field = 'm.sender_id';
		if ( 'bp_messages_recipient_get_where_conditions' === $action_name ) {
			$user_id_field = 'r.user_id';
		}

		$sql                = false;
		$hidden_members_ids = BP_Moderation_Members::get_sitewide_hidden_ids();
		if ( ! empty( $hidden_members_ids ) ) {
			$sql = "( {$user_id_field} NOT IN ( " . implode( ',', $hidden_members_ids ) . ' ) )';
		}

		return $sql;
	}

	/**
	 * Function to delete message moderation data when deleting the message thread
	 *
	 * @since BuddyBoss 2.0.0
	 *
	 * @param int $thread_id ID of the thread being deleted.
	 */
	public function delete_moderation_data( $thread_id ) {
		if ( ! empty( $thread_id ) ) {
			$moderation_obj = new BP_Moderation( $thread_id, self::$moderation_type );
			if ( ! empty( $moderation_obj->id ) ) {
				$moderation_obj->delete( true );
			}
		}
	}
}
