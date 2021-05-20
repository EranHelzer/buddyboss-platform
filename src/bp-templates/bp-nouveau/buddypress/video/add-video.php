<?php
/**
 * BuddyBoss - Add Video
 *
 * @package BuddyBoss\Core
 *
 * @since BuddyBoss 1.7.0
 */

if ( bp_is_my_profile() || ( bp_is_group() && is_user_logged_in() ) ) : ?>

	<div class="bb-video-actions-wrap bb-media-actions-wrap">
		<h2 class="bb-title"><?php esc_html_e( 'Videos', 'buddyboss' ); ?></h2>
		<div class="bb-video-actions">
			<a href="#" id="bp-add-video" class="bb-add-video button small outline"><?php esc_html_e( 'Add Videos', 'buddyboss' ); ?></a>
		</div>
	</div>

	<?php bp_get_template_part( 'video/uploader' ); ?>

<?php endif; ?>
