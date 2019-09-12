<?php
/* Data */
require_once (B2S_PLUGIN_DIR . 'includes/B2S/Post/Filter.php');
require_once (B2S_PLUGIN_DIR . 'includes/Util.php');
$b2sShowByDate = isset($_GET['b2sShowByDate']) ? trim($_GET['b2sShowByDate']) : "";
?>

<div>
    <div class="b2s-inbox">
        <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/header.phtml'); ?>
        <!--Filter Start-->
        <div class="b2s-post">
            <div class="grid-body">
                <!--Navbar Start-->
                <div class="col-md-12 pull-left b2s-post-menu del-padding-left">
                    <a class="btn btn-primary b2s-post-btn btn-sm b2s-post-all" href="#" onclick="jQuery('#b2sType').val('all');b2sSortFormSubmit()"><?php _e('Latest Posts', 'blog2social') ?></a>
                    <a class="btn btn-link b2s-post-btn btn-sm b2s-post-sched" href="#" onclick="jQuery('#b2sType').val('sched');b2sSortFormSubmit()">
                        <?php _e('Scheduled Posts', 'blog2social') ?> <?php echo (B2S_PLUGIN_USER_VERSION == 0 ? '<span class="label label-success">' . __("PREMIUM", "blog2social") . '</span>' : '' ); ?>  </a>
                </div>
                <hr class="pull-left">
                <!--Navbar Ende-->
                <!-- Filter Post Start-->
                <form class="b2sSortForm form-inline pull-left" action="#">
                    <input id="b2sType" type="hidden" value="all" name="b2sType">
                    <input id="b2sShowByDate" type="hidden" value="<?php echo $b2sShowByDate; ?>" name="b2sShowByDate">
                    <input id="b2sPagination" type="hidden" value="0" name="b2sPagination">
                    <input id="b2sShowPagination" type="hidden" value="0" name="b2sShowPagination">
                    <input id="b2sPostsPerPage" type="hidden" value="3" name="b2sPostsPerPage">
                </form>
                <!-- Filter Post Ende-->
                <br>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--Filter End-->
        <div class="b2s-sort-area">
            <div class="b2s-loading-area">
                <br>
                <div class="b2s-loader-impulse b2s-loader-impulse-md"></div>
                <div class="clearfix"></div>
            </div>
            <div class="row b2s-sort-result-area">
                <div class="col-md-12">
                    <ul class="list-group b2s-sort-result-item-area"></ul>
                    <br>
                    <nav class="b2s-sort-pagination-area text-center"></nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade b2s-delete-publish-modal" tabindex="-1" role="dialog" aria-labelledby="b2s-delete-publish-modal" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="b2s-modal-close close" data-modal-name=".b2s-delete-publish-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _e('Delete entries from the reporting', 'blog2social') ?></h4>
            </div>
            <div class="modal-body">
                <b><?php _e('You are sure, you want to delete entries from the reporting?', 'blog2social') ?></b>
                <br>
                (<?php _e('Number of entries', 'blog2social') ?>:  <span id="b2s-delete-confirm-post-count"></span>)
                <input type="hidden" value="" id="b2s-delete-confirm-post-id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php _e('NO', 'blog2social') ?></button>
                <button class="btn btn-danger b2s-publish-delete-confirm-btn"><?php _e('YES, delete', 'blog2social') ?></button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="b2sLang" value="<?php echo substr(B2S_LANGUAGE, 0, 2); ?>">
<input type="hidden" id="b2sUserLang" value="<?php echo strtolower(substr(get_locale(), 0, 2)); ?>">
