<?php
/**
 * BuddyBoss - Members Settings ( Notifications )
 *
 * @since BuddyPress 3.0.0
 * @version 3.0.0
 */

bp_nouveau_member_hook( 'before', 'settings_template' );

$data = bb_core_notification_preferences_data();
?>

<h2 class="screen-heading email-settings-screen"><?php echo wp_kses_post( $data['screen_title'] ); ?></h2>

<p class="bp-help-text email-notifications-info">
	<?php echo wp_kses_post( $data['screen_description'] ); ?>
</p>

<form action="<?php echo esc_url( bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications' ); ?>" method="post" class="standard-form" id="settings-form">

	<?php
	if ( false === bb_enabled_legacy_email_preference() ) {

		if ( bb_web_notification_enabled() || bb_app_notification_enabled() ) {
			?>

			<div class="notification_info">
				<p class="notification_learn_more"><a href="#"><?php esc_html_e( 'Learn more', 'buddyboss' ); ?><span class="bb-icon-chevron-down"></span></a></p>

				<div class="notification_type email_notification">
					<span class="notification_type_icon">
						<i class="bb-icon bb-icon-mail"></i>
					</span>

					<div class="notification_type_info">
						<h3><?php esc_attr_e( 'Email', 'buddyboss' ); ?></h3>
						<p><?php esc_attr_e( 'A notification sent to your inbox', 'buddyboss' ); ?></p>
					</div>
				</div><!-- .notification_type -->

				<?php if ( bb_web_notification_enabled() ) { ?>
				<div class="notification_type web_notification">
					<span class="notification_type_icon">
						<i class="bb-icon bb-icon-monitor"></i>
					</span>

					<div class="notification_type_info">
						<h3><?php esc_attr_e( 'Web', 'buddyboss' ); ?></h3>
						<p><?php esc_attr_e( 'A notification in the corner of your screen', 'buddyboss' ); ?></p>
					</div>
				</div><!-- .notification_type -->
				<?php } ?>

				<?php if ( bb_app_notification_enabled() ) { ?>
				<div class="notification_type app_notification">
					<span class="notification_type_icon">
						<i class="bb-icon bb-icon-smartphone"></i>
					</span>

					<div class="notification_type_info">
						<h3><?php esc_attr_e( 'App', 'buddyboss' ); ?></h3>
						<p><?php esc_attr_e( 'A notification pushed to your mobile device', 'buddyboss' ); ?></p>
					</div>
				</div><!-- .notification_type -->
				<?php } ?>

			</div><!-- .notification_info -->
		<?php } ?>

	<table class="main-notification-settings">

		<?php if ( true === $data['show_checkbox_label'] ) { ?>
		<thead>
			<tr>
				<th class="title"><?php esc_html_e( 'Enable notifications', 'buddyboss' ); ?></th>
				<th class="email">
					<input type="checkbox" id="main_notification_email" name="" class="bs-styled-checkbox" />
					<label for="main_notification_email"><?php esc_html_e( 'Email', 'buddyboss' ); ?></label>
				</th>

				<?php if ( bb_web_notification_enabled() ) { ?>
				<th class="web">
					<input type="checkbox" id="main_notification_web" name="" class="bs-styled-checkbox" />
					<label for="main_notification_web"><?php esc_html_e( 'Web', 'buddyboss' ); ?></label>
				</th>
				<?php } ?>

				<?php if ( bb_app_notification_enabled() ) { ?>
				<th class="app">
					<input type="checkbox" id="main_notification_app" name="" class="bs-styled-checkbox" />
					<label for="main_notification_app"><?php esc_html_e( 'App', 'buddyboss' ); ?></label>
				</th>
				<?php } ?>
			</tr>
		</thead>
		<?php } ?>

		<tbody>
			<?php if ( bb_web_notification_enabled() || bb_app_notification_enabled() ) { ?>
			<tr class="section-end">
				<td>
					<?php esc_html_e( 'A manual notification from a site admin', 'buddyboss' ); ?>
				</td>
				<td class="email notification_no_option">
					<?php esc_html_e( '-', 'buddyboss' ); ?>
				</td>

				<?php if ( bb_web_notification_enabled() ) { ?>
				<td class="web">
					<input type="checkbox" id="admin_notification_web" name="" class="bs-styled-checkbox" />
					<label for="admin_notification_web"><?php esc_html_e( 'Web', 'buddyboss' ); ?></label>
				</td>
				<?php } ?>

				<?php if ( bb_app_notification_enabled() ) { ?>
				<td class="app">
					<input type="checkbox" id="admin_notification_app" name="" class="bs-styled-checkbox" />
					<label for="admin_notification_app"><?php esc_html_e( 'App', 'buddyboss' ); ?></label>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>

		</tbody>
	</table>
	<?php } ?>

	<?php bp_nouveau_member_email_notice_settings(); ?>

	<?php bp_nouveau_submit_button( 'member-notifications-settings' ); ?>

</form>

<?php
bp_nouveau_member_hook( 'after', 'settings_template' );
