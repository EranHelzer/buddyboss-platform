<?php
/**
 * Filters related to the Moderation component.
 *
 * @since   BuddyBoss 2.0.0
 * @package BuddyBoss\Moderation
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

new BP_Core_Suspend();
new BP_Moderation_Members();
new BP_Moderation_Comment();

if ( bp_is_active( 'activity' ) ) {
	new BP_Moderation_Activity();
	new BP_Moderation_Activity_Comment();
}

if ( bp_is_active( 'groups' ) ) {
	new BP_Moderation_Groups();
}

if ( bp_is_active( 'forums' ) ) {
	new BP_Moderation_Forums();
	new BP_Moderation_Forum_Topics();
	new BP_Moderation_Forum_Replies();
}

if ( bp_is_active( 'document' ) ) {
	new BP_Moderation_Folder();
	new BP_Moderation_Document();
}

if ( bp_is_active( 'media' ) ) {
	new BP_Moderation_Album();
	new BP_Moderation_Media();
}

/**
 * Update modebypass Param
 *
 * @since BuddyBoss 2.0.0
 *
 * @param Array $params Array of key/value pairs for AJAX usage.
 */
function bp_moderation_js_strings( $params ) {
	$params['modbypass'] = filter_input( INPUT_GET, 'modbypass', FILTER_SANITIZE_NUMBER_INT );

	return $params;
}

add_filter( 'bp_core_get_js_strings', 'bp_moderation_js_strings' );

/**
 * Function to handle frontend report form submission.
 *
 * @since BuddyBoss 2.0.0
 */
function bp_moderation_content_report() {
	$response = array(
		'success' => false,
		'message' => '',
	);

	$nonce     = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
	$item_id   = filter_input( INPUT_POST, 'content_id', FILTER_SANITIZE_NUMBER_INT );
	$item_type = filter_input( INPUT_POST, 'content_type', FILTER_SANITIZE_STRING );
	$category  = filter_input( INPUT_POST, 'report_category', FILTER_SANITIZE_STRING );
	if ( 'other' !== $category ) {
		$category = filter_input( INPUT_POST, 'report_category', FILTER_SANITIZE_NUMBER_INT );
	}
	$item_note = filter_input( INPUT_POST, 'note', FILTER_SANITIZE_STRING );

	if ( empty( $item_id ) || empty( $item_type ) || empty( $category ) ) {
		return new WP_Error(
			'bp_moderation_missing_data',
			esc_html__( 'Required field missing.', 'buddyboss' )
		);
	}

	if ( 'other' === $category && empty( $item_note ) ) {
		return new WP_Error(
			'bp_moderation_missing_data',
			esc_html__( 'Please specify reason to report this content.', 'buddyboss' )
		);
	}

	// Check the current has access to report the item ot not.
	$user_can = bp_moderation_user_can( $item_id, $item_type );
	if ( false === (bool) $user_can ) {
		return new WP_Error(
			'bp_moderation_invalid_access',
			esc_html__( 'Sorry, you can not able to report this item.', 'buddyboss' )
		);
	}

	/**
	 * If Sub item id and sub type is empty then actual item is reported otherwise Connected item will be reported
	 * Like For Forum create activity, When reporting Activity it'll report actual forum
	 */
	$sub_items     = bp_moderation_get_sub_items( $item_id, $item_type );
	$item_sub_id   = isset( $sub_items['id'] ) ? $sub_items['id'] : $item_id;
	$item_sub_type = isset( $sub_items['type'] ) ? $sub_items['type'] : $item_type;

	if ( bp_moderation_report_exist( $item_sub_id, $item_sub_type ) ) {
		return new WP_Error(
			'bp_moderation_already_reported',
			esc_html__( 'Already reported this item.', 'buddyboss' )
		);
	}

	if ( wp_verify_nonce( $nonce, 'bp-moderation-content' ) && ! is_wp_error( $response['message'] ) ) {
		$moderation = bp_moderation_add(
			array(
				'content_id'   => $item_sub_id,
				'content_type' => $item_sub_type,
				'category_id'  => $category,
				'note'         => $item_note,
			)
		);

		if ( ! empty( $moderation->id ) && ! empty( $moderation->report_id ) ) {
			$response['success']    = true;
			$response['moderation'] = $moderation;

			$button_args = array(
				'button_attr' => array(
					'data-bp-content-id'   => $item_id,
					'data-bp-content-type' => $item_type,
				),
			);

			$response['button'] = bp_moderation_get_report_button( $button_args, false );
		}

		$response['message'] = $moderation->errors;
	}

	if ( empty( $response['success'] ) && empty( $response['message'] ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_missing_error', esc_html__( 'Sorry, Something happened wrong', 'buddyboss' ) );
	}

	echo wp_json_encode( $response );
	exit();
}

add_action( 'wp_ajax_bp_moderation_content_report', 'bp_moderation_content_report' );
add_action( 'wp_ajax_nopriv_bp_moderation_content_report', 'bp_moderation_content_report' );


/**
 * Function to handle frontend block member form submission.
 *
 * @since BuddyBoss 2.0.0
 */
function bp_moderation_block_member() {
	$response = array(
		'success' => false,
		'message' => '',
	);

	$nonce   = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
	$item_id = filter_input( INPUT_POST, 'content_id', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $item_id ) ) {
		return new WP_Error( 'bp_moderation_missing_data', esc_html__( 'Required field missing.', 'buddyboss' ) );
	}

	if ( bp_moderation_report_exist( $item_id, BP_Moderation_Members::$moderation_type ) ) {
		return new WP_Error( 'bp_moderation_already_reported', esc_html__( 'Already reported this item.', 'buddyboss' ) );
	}

	if ( (int) bp_loggedin_user_id() === (int) $item_id ) {
		return new WP_Error( 'bp_moderation_invalid_item_id', esc_html__( 'Sorry, you can not able to block him self.', 'buddyboss' ) );
	}

	// Check the current has access to report the item ot not.
	$user_can = bp_moderation_user_can( $item_id, BP_Moderation_Members::$moderation_type );
	if ( false === (bool) $user_can ) {
		return new WP_Error(
			'bp_moderation_invalid_access',
			esc_html__( 'Sorry, you can not able to block this member.', 'buddyboss' )
		);
	}

	if ( wp_verify_nonce( $nonce, 'bp-moderation-content' ) && ! is_wp_error( $response['message'] ) ) {
		$moderation = bp_moderation_add(
			array(
				'content_id'   => $item_id,
				'content_type' => BP_Moderation_Members::$moderation_type,
				'note'         => esc_html__( 'Member block', 'buddyboss' ),
			)
		);

		if ( ! empty( $moderation->id ) && ! empty( $moderation->report_id ) ) {
			$response['success']    = true;
			$response['moderation'] = $moderation;

			if ( bp_is_friend( $item_id ) ) {
				friends_remove_friend( bp_loggedin_user_id(), $item_id );
			}

			if ( bp_is_following(
				array(
					'leader_id'   => $item_id,
					'follower_id' => bp_loggedin_user_id(),
				)
			) ) {
				bp_stop_following(
					array(
						'leader_id'   => $item_id,
						'follower_id' => bp_loggedin_user_id(),
					)
				);
			}

			$response['button'] = bp_moderation_get_report_button(
				array(
					'button_attr' => array(
						'data-bp-content-id'   => $item_id,
						'data-bp-content-type' => BP_Moderation_Members::$moderation_type,
					),
				),
				false
			);
		}

		$response['message'] = $moderation->errors;
	}

	if ( empty( $response['success'] ) && empty( $response['message'] ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_missing_error', esc_html__( 'Sorry, Something happened wrong', 'buddyboss' ) );
	}

	echo wp_json_encode( $response );
	exit();

}

add_action( 'wp_ajax_bp_moderation_block_member', 'bp_moderation_block_member' );
add_action( 'wp_ajax_nopriv_bp_moderation_block_member', 'bp_moderation_block_member' );

/**
 * Function to handle frontend unblock user request.
 *
 * @since BuddyBoss 2.0.0
 */
function bp_moderation_unblock_user() {
	$response = array(
		'success' => false,
		'message' => '',
	);

	$nonce   = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING );
	$item_id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $item_id ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_missing_data', esc_html__( 'Required field missing.', 'buddyboss' ) );
	}

	if ( ! bp_moderation_report_exist( $item_id, BP_Moderation_Members::$moderation_type ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_not_exit', esc_html__( 'Moderation reported not found.', 'buddyboss' ) );
	}

	if ( wp_verify_nonce( $nonce, 'bp-unblock-user' ) && ! is_wp_error( $response['message'] ) ) {
		$moderation = bp_moderation_delete(
			array(
				'content_id'   => $item_id,
				'content_type' => BP_Moderation_Members::$moderation_type,
			)
		);

		if ( empty( $moderation->report_id ) ) {
			$response['success'] = true;
			$response['message'] = esc_html__( 'User unblocked successfully', 'buddyboss' );
		}
	}

	if ( empty( $response['success'] ) && empty( $response['message'] ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_block_error', esc_html__( 'Sorry, Something happened wrong', 'buddyboss' ) );
	}

	echo wp_json_encode( $response );
	exit();
}

add_action( 'wp_ajax_bp_moderation_unblock_user', 'bp_moderation_unblock_user' );
add_action( 'wp_ajax_nopriv_bp_moderation_unblock_user', 'bp_moderation_unblock_user' );

/**
 * Function to handle moderation request from frontend
 *
 * @since BuddyBoss 2.0.0
 */
function bp_moderation_content_actions_request() {
	$response = array(
		'success' => false,
		'message' => '',
	);

	$nonce      = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING );
	$item_type  = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );
	$sub_action = filter_input( INPUT_POST, 'sub_action', FILTER_SANITIZE_STRING );
	$item_id    = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $item_id ) || empty( $item_type ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_missing_data', esc_html__( 'Required field missing.', 'buddyboss' ) );
	}

	if ( wp_verify_nonce( $nonce, 'bp-hide-unhide-moderation' ) && ! is_wp_error( $response['message'] ) ) {
		if ( 'hide' === $sub_action ) {
			$moderation = bp_moderation_hide(
				array(
					'content_id'   => $item_id,
					'content_type' => $item_type,
				)
			);
			if ( 1 === $moderation->hide_sitewide ) {
				$response['success'] = true;
				$response['message'] = 'user' === $item_type ? esc_html__( 'Member has been successfully suspended.', 'buddyboss' ) : esc_html__( 'Content has been successfully hidden.', 'buddyboss' );
			}
		} else {
			$moderation = bp_moderation_unhide(
				array(
					'content_id'   => $item_id,
					'content_type' => $item_type,
				)
			);
			if ( 0 === $moderation->hide_sitewide ) {
				$response['success'] = true;
				$response['message'] = 'user' === $item_type ? esc_html__( 'Member has been successfully unsuspended.', 'buddyboss' ) : esc_html__( 'Content has been successfully unhidden.', 'buddyboss' );
			}
		}
	}

	if ( empty( $response['success'] ) && empty( $response['message'] ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_content_actions_request', esc_html__( 'Sorry, Something happened wrong', 'buddyboss' ) );
	}

	echo wp_json_encode( $response );
	exit();
}

add_action( 'wp_ajax_bp_moderation_content_actions_request', 'bp_moderation_content_actions_request' );
add_action( 'wp_ajax_nopriv_bp_moderation_content_actions_request', 'bp_moderation_content_actions_request' );

/**
 * Function to handle moderation request for user
 *
 * @since BuddyBoss 2.0.0
 */
function bp_moderation_user_actions_request() {
	$response = array(
		'success' => false,
		'message' => '',
	);

	$nonce      = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_STRING );
	$item_type  = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );
	$sub_action = filter_input( INPUT_POST, 'sub_action', FILTER_SANITIZE_STRING );
	$item_id    = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );

	if ( empty( $item_id ) || empty( $item_type ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_user_missing_data', esc_html__( 'Required field missing.', 'buddyboss' ) );
	}

	if ( wp_verify_nonce( $nonce, 'bp-hide-unhide-moderation' ) && ! is_wp_error( $response['message'] ) ) {

		if ( 'hide' === $sub_action ) {
			BP_Suspend_Member::suspend_user( $item_id );
			$response['success'] = true;
			$response['message'] = esc_html__( 'Member has been successfully suspended.', 'buddyboss' );
		} else {
			BP_Suspend_Member::unsuspend_user( $item_id );
			$response['success'] = true;
			$response['message'] = esc_html__( 'Member has been successfully unsuspended.', 'buddyboss' );
		}
	}

	if ( empty( $response['success'] ) && empty( $response['message'] ) ) {
		$response['message'] = new WP_Error( 'bp_moderation_user_missing_data', esc_html__( 'Sorry, Something happened wrong', 'buddyboss' ) );
	}

	echo wp_json_encode( $response );
	exit();
}

add_action( 'wp_ajax_bp_moderation_user_actions_request', 'bp_moderation_user_actions_request' );
add_action( 'wp_ajax_nopriv_bp_moderation_user_actions_request', 'bp_moderation_user_actions_request' );

/**
 * Function to Popup markup for moderation content report
 *
 * @since BuddyBoss 2.0.0
 */
function bb_moderation_content_report_popup() {
	include BP_PLUGIN_DIR . 'src/bp-moderation/screens/content-report-form.php';
	include BP_PLUGIN_DIR . 'src/bp-moderation/screens/block-member-form.php';
}

add_action( 'wp_footer', 'bb_moderation_content_report_popup' );

/**
 * Function to add the block user button in customizer section
 *
 * @since BuddyBoss 2.0.0
 *
 * @param array $buttons buttons array.
 *
 * @return mixed
 */
function bp_moderation_block_user_profile_button( $buttons ) {

	if ( bp_is_active( 'moderation' ) && bp_is_moderation_member_blocking_enable() ) {
		$buttons['member_report'] = __( 'Block', 'buddyboss' );
	}

	return $buttons;
}

add_filter( 'bp_nouveau_customizer_user_profile_actions', 'bp_moderation_block_user_profile_button' );

/**
 * Removed Moderation report entries after the suspend record delete.
 *
 * @since BuddyBoss 2.0.0
 *
 * @param object $recode Suspended record object.
 */
function bb_moderation_suspend_after_delete( $recode ) {

	if ( empty( $recode ) ) {
		return;
	}

	BP_Moderation::delete_moderation_by_id( $recode->id );

}
add_action( 'suspend_after_delete', 'bb_moderation_suspend_after_delete' );
