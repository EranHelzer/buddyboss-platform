<?php
/**
 * BP Nouveau Messages main template.
 *
 * This template is used to inject the BuddyPress Backbone views
 * dealing with user's private messages.
 *
 * @since BuddyPress 3.0.0
 * @version 3.1.0
 */
?>

<input type="hidden" id="thread-id" value="" />
<div class="bp-messages-container">
	<div class="bp-messages-nav-panel">
		<div class="subnav-filters filters user-subnav bp-messages-filters push-right" id="subsubnav"></div>
		<div class="bp-messages-feedback"></div>
		<div class="bp-messages-threads-list" id="bp-messages-threads-list"></div>
	</div>
	<div class="bp-messages-content"></div>
</div>

<?php
if ( bp_is_active( 'media' ) && bp_is_messages_media_support_enabled() ) {
	bp_get_template_part( 'media/theatre' );
}

    /**
     * Split each js template to its own file. Easier for child theme to
     * overwrite individual parts.
     *
     * @version Buddyboss 1.0.0
     */
    $template_parts = apply_filters( 'bp_messages_js_template_parts', [
        'parts/bp-messages-feedback',
        'parts/bp-messages-loading',
        'parts/bp-messages-hook',
        'parts/bp-messages-form',
        'parts/bp-messages-editor',
        'parts/bp-messages-paginate',
        'parts/bp-messages-filters',
        'parts/bp-messages-thread',
        'parts/bp-messages-single-header',
        'parts/bp-messages-single-load-more',
        'parts/bp-messages-single-list',
        'parts/bp-messages-single',
        'parts/bp-messages-editor-toolbar',
        'parts/bp-messages-media',
        'parts/bp-messages-no-threads',
    ] );

    foreach ( $template_parts as $template_part ) {
        bp_get_template_part( 'common/js-templates/messages/' . $template_part );
    }
