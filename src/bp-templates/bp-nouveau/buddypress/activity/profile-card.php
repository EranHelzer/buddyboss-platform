<?php
/**
 * The template for pofile/groups card.
 *
 * This template can be overridden by copying it to yourtheme/buddypress/activity/profile-card.php.
 *
 * @since   BuddyBoss 2.5.80
 * @version 1.0.0
 */
?>
<div id="profile-card" class="bb-profile-card bb-popup-card" style="display: none;">

	<div class="bb-card-content">
		<div class="bb-card-body">
			<div class="bb-card-avatar">
				<span class="card-profile-status active"></span>
				<img src="" alt="">
			</div>
			<div class="bb-card-entity">
				<div class="bb-card-profile-type"></div>
				<h4 class="bb-card-heading"></h4>
				<div class="bb-card-meta">
					<span class="card-meta-joined">Joined Nov 2023</span>
					<span class="card-meta-last-active">Active now</span>
					<span class="card-meta-joined"><span>23</span> followers</span>
				</div>
			</div>
		</div>
		<div class="bb-card-footer">
			<div class="bb-card-action-primary">
				<a href="" class="card-button">
					<i class="bb-icon-l bb-icon-comment"></i>
					<?php esc_html_e( 'Message', 'buddyboss' ); ?>
				</a>
			</div>
			<div class="bb-card-action-outline">
				<a href="" class="card-button card-button-profile"><?php esc_html_e( 'View Profile', 'buddyboss' ); ?></a>
			</div>
		</div>
	</div>

</div>