<?php
/**
 * The template for activity modal
 *
 * This template can be overridden by copying it to yourtheme/buddypress/activity/activity-modal.php.
 *
 * @since   BuddyBoss [BBVERSION]
 * @version 1.0.0
 */
?>
<div class="bb-activity-model-wrapper bb-internal-model activity-theatre" style="display: none;">

    <div id="activity-modal" class="activity-modal activity">
			<div class="bb-modal-activity-header">
				<h2>John's Post</h2>
				<a class="bb-close-action-popup bb-model-close-button" href="#">
					<span class="bb-icon-l bb-icon-times"></span>
				</a>
			</div>
			<div class="bb-modal-activity-body">
				<ul class="activity-list item-list bp-list"></ul>
			</div>
			<div class="bb-modal-activity-footer activity-item">
				<div class="ac-form-placeholder">
					<div class="bp-ac-form-container">
						<div class="ac-reply-avatar">
							<?php bp_loggedin_user_avatar( array( 'type' => 'thumb' ) ); ?>
						</div>
						<div class="ac-reply-content">
							<div id="ac-reply-toolbar-536" class="ac-reply-toolbar">

								<div class="post-elements-buttons-item post-media media-support">
									<a href="#" id="ac-reply-media-button-536" class="toolbar-button bp-tooltip ac-reply-media-button" data-bp-tooltip-pos="up" data-bp-tooltip="Attach photo" data-ac-id="536">
										<i class="bb-icon-l bb-icon-camera"></i>
									</a>
								</div>

								<div class="post-elements-buttons-item post-video video-support">
									<a href="#" id="ac-reply-video-button-536" class="toolbar-button bp-tooltip ac-reply-video-button" data-bp-tooltip-pos="up" data-bp-tooltip="Attach video" data-ac-id="536">
										<i class="bb-icon-l bb-icon-video"></i>
									</a>
								</div>
								<div class="post-elements-buttons-item post-media document-support">
									<a href="#" id="ac-reply-document-button-536" class="toolbar-button bp-tooltip ac-reply-document-button" data-bp-tooltip-pos="up" data-bp-tooltip="Attach document" data-ac-id="536">
										<i class="bb-icon-l bb-icon-attach"></i>
									</a>
								</div>

								<div class="post-elements-buttons-item post-gif" data-nth-child="4">
									<div class="gif-media-search">
										<a href="#" id="ac-reply-gif-button-536" class="toolbar-button bp-tooltip ac-reply-gif-button" data-bp-tooltip-pos="up" data-bp-tooltip="Choose a GIF">
											<i class="bb-icon-l bb-icon-gif"></i>
										</a>
										<div class="gif-media-search-dropdown"></div>
									</div>
								</div>

								<div class="post-elements-buttons-item post-emoji bp-tooltip" data-bp-tooltip-pos="up" data-bp-tooltip="Emoji" id="ac-reply-emoji-button-536" data-nth-child="5"><div class="emojionearea emojionearea-standalone ac-input bp-suggestions medium-editor-element" role="application"><div class="emojionearea-editor has-placeholder" contenteditable="false" placeholder="Write a comment..." tabindex="0" dir="ltr" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off"></div><div class="emojionearea-button" title="Use the TAB key to insert emoji faster"><div class="emojionearea-button-open"></div></div></div></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

</div>