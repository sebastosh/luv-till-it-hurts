<?php
wp_nonce_field('b2s_security_nonce', 'b2s_security_nonce');
require_once B2S_PLUGIN_DIR . 'includes/B2S/RePost/Item.php';
$rePostItem = new B2S_RePost_Item();

require_once (B2S_PLUGIN_DIR . 'includes/Util.php');
require_once B2S_PLUGIN_DIR . 'includes/B2S/Settings/Item.php';
$options = new B2S_Options(B2S_PLUGIN_BLOG_USER_ID);
$optionUserTimeZone = $options->_getOption('user_time_zone');
$userTimeZone = ($optionUserTimeZone !== false) ? $optionUserTimeZone : get_option('timezone_string');
$userTimeZoneOffset = (empty($userTimeZone)) ? get_option('gmt_offset') : B2S_Util::getOffsetToUtcByTimeZone($userTimeZone);
$metaSettings = get_option('B2S_PLUGIN_GENERAL_OPTIONS');
?>

<div class="b2s-container">
    <div class=" b2s-inbox col-md-12 del-padding-left">
        <div class="col-md-9 del-padding-left del-padding-right">
            <!--Header|Start - Include-->
            <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/header.php'); ?>
            <!--Header|End-->
            <div class="clearfix"></div>
            <!--Content|Start-->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row b2s-loading-area width-100" style="display: none;">
                            <div class="b2s-loader-impulse b2s-loader-impulse-md"></div>
                            <div class="text-center b2s-loader-text"><?php esc_html_e("Loading...", "blog2social"); ?></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row b2s-repost-options-area">
                        <?php echo $rePostItem->getRePostOptionsHtml(); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row b2s-repost-queue-area">
                        <?php echo $rePostItem->getRePostQueueHtml(); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php
                        $noLegend = 1;
                        require_once (B2S_PLUGIN_DIR . 'views/b2s/html/footer.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/sidebar.php'); ?>
    </div>
</div>

<input type="hidden" id="b2sUserVersion" value="<?php echo B2S_PLUGIN_USER_VERSION; ?>" />
<input type="hidden" id="b2sLang" value="<?php echo substr(B2S_LANGUAGE, 0, 2); ?>">
<input type="hidden" id="b2sJSTextAddPost" value="<?php echo esc_html_e("add post", "blog2social"); ?>">                    
<input type="hidden" id="b2sUserLang" value="<?php echo strtolower(substr(get_locale(), 0, 2)); ?>">
<input type='hidden' id="user_timezone" name="user_timezone" value="<?php echo $userTimeZoneOffset; ?>">
<input type="hidden" id="user_version" name="user_version" value="<?php echo B2S_PLUGIN_USER_VERSION; ?>">
<input type="hidden" id="b2sDefaultNoImage" value="<?php echo plugins_url('/assets/images/no-image.png', B2S_PLUGIN_FILE); ?>">
<input type="hidden" id="b2sPostId" value="">
<input type="hidden" id="b2sInsertImageType" value="0">
<input type="hidden" id="isOgMetaChecked" value="<?php echo (isset($metaSettings['og_active']) ? (int) $metaSettings['og_active'] : 0); ?>">
<input type="hidden" id="isCardMetaChecked" value="<?php echo (isset($metaSettings['card_active']) ? (int) $metaSettings['card_active'] : 0); ?>">
<input type="hidden" id="b2sNotAllowGif" value="<?php echo implode(";", json_decode(B2S_PLUGIN_NETWORK_NOT_ALLOW_GIF, true)); ?>">
<input type="hidden" id="b2sAnimateGif" value='<?php echo B2S_PLUGIN_NETWORK_ANIMATE_GIF; ?>'>
<input type="hidden" id="ogMetaNetworks" value="<?php echo implode(';', json_decode(B2S_PLUGIN_NETWORK_META_TAGS, true)['og']); ?>">
<input type="hidden" id="b2sEmojiTranslation" value='<?php echo json_encode(B2S_Tools::getEmojiTranslationList()); ?>'>

<script>
    var b2s_has_premium = <?= B2S_PLUGIN_USER_VERSION > 0 ? "true" : "false"; ?>;
    var b2s_plugin_url = '<?= B2S_PLUGIN_URL; ?>';
    var b2s_post_formats = <?= json_encode(array('post' => array(esc_html__('Link Post', 'blog2social'), esc_html__('Image Post', 'blog2social')), 'image' => array(esc_html__('Image with frame', 'blog2social'), esc_html__('Image cut out','blog2social')))); ?>;
    var b2s_is_calendar = true;
</script>

<div class="modal fade b2s-delete-sched-modal" tabindex="-1" role="dialog" aria-labelledby="b2s-delete-sched-modal" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name=".b2s-delete-sched-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php esc_html_e('Delete entries form the scheduling', 'blog2social') ?></h4>
            </div>
            <div class="modal-body">
                <b><?php esc_html_e('You are sure, you want to delete entries from the scheduling?', 'blog2social') ?> </b>
                <br>
                (<?php esc_html_e('Number of entries', 'blog2social') ?>:  <span id="b2s-delete-confirm-post-count"></span>)
                <input type="hidden" value="" id="b2s-delete-confirm-post-id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php esc_html_e('NO', 'blog2social') ?></button>
                <button class="btn btn-danger b2s-sched-delete-confirm-btn"><?php esc_html_e('YES, delete', 'blog2social') ?></button>
                <button class="btn btn-danger b2s-sched-delete-confirm-multi-btn" style="display:none;"><?php esc_html_e('YES, delete', 'blog2social') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="b2s-post-ship-item-post-format-modal" class="modal fade" role="dialog" aria-labelledby="b2s-post-ship-item-post-format-modal" aria-hidden="true" data-backdrop="false" style="z-index: 1070">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-post-ship-item-post-format-modal">&times;</button>
                <h4 class="modal-title"><?php esc_html_e('Choose your', 'blog2social') ?> <span id="b2s-post-ship-item-post-format-network-title"></span> <?php esc_html_e('Post Format', 'blog2social') ?>
                    <?php if (B2S_PLUGIN_USER_VERSION >= 2) { ?>
                        <?php esc_html_e('for:', 'blog2social') ?> <span id="b2s-post-ship-item-post-format-network-display-name"></span>
                    <?php } ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        $settingsItem = new B2S_Settings_Item();
                        echo $settingsItem->setNetworkSettingsHtml();
                        echo $settingsItem->getNetworkSettingsHtml();
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <br>
                            <div class="b2s-post-format-settings-info" data-network-id="1" style="display:none;">
                                <b><?php esc_html_e('Define the default settings for the custom post format for all of your Facebook accounts in the Blog2Social settings.', 'blog2social'); ?></b>
                            </div>
                            <div class="b2s-post-format-settings-info" data-network-id="2" style="display:none;">
                                <b><?php esc_html_e('Define the default settings for the custom post format for all of your Twitter accounts in the Blog2Social settings.', 'blog2social'); ?></b>
                            </div>
                            <div class="b2s-post-format-settings-info" data-network-id="3" style="display:none;">
                                <b><?php esc_html_e('Define the default settings for the custom post format for all of your LinkedIn accounts in the Blog2Social settings.', 'blog2social'); ?></b>
                            </div>
                            <div class="b2s-post-format-settings-info" data-network-id="12" style="display:none;">
                                <b><?php esc_html_e('Define the default settings for the custom post format for all of your Instagram accounts in the Blog2Social settings.', 'blog2social'); ?></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="b2s-network-select-image" class="modal fade" role="dialog" aria-labelledby="b2s-network-select-image" aria-hidden="true" style="z-index: 1070">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name="#b2s-network-select-image">&times;</button>
                <h4 class="modal-title"><?php esc_html_e('Select image for', 'blog2social') ?> <span class="b2s-selected-network-for-image-info"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="b2s-network-select-image-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="b2sTwitterInfoModal" tabindex="-1" role="dialog" aria-labelledby="b2sTwitterInfoModal" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name="#b2sTwitterInfoModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php esc_html_e('Select Twitter profile:', 'blog2social') ?></h4>
            </div>
            <div class="modal-body">
                <?php esc_html_e('To comply with the Twitter TOS and to avoid duplicate posts, autoposts will be sent to your primary Twitter profile.', 'blog2social') ?> <a target="_blank" href="<?php echo B2S_Tools::getSupportLink('network_tos_faq_032018') ?>"><?php esc_html_e('More information', 'blog2social') ?></a>
            </div>
        </div>
    </div>
</div>