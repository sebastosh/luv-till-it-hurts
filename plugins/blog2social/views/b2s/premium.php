
<div class="b2s-container">
    <div class="b2s-inbox">
        <div class="col-md-12 del-padding-left">
            <div class="col-md-9 del-padding-left del-padding-right">
                <!--Header|Start - Include-->
                <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/header.phtml'); ?>
                <!--Header|End-->
                <div class="clearfix"></div>
                <!--Content|Start-->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2 class="b2s-premium-h2"><?php _e('Your current license:', 'blog2social') ?>
                            <span class="b2s-key-name">
                                <?php
                                $versionType = unserialize(B2S_PLUGIN_VERSION_TYPE);
                                if (defined("B2S_PLUGIN_TRAIL_END") && strtotime(B2S_PLUGIN_TRAIL_END) > time()) {
                                    echo 'FREE-TRIAL (' . $versionType[B2S_PLUGIN_USER_VERSION] . ')';
                                } else {
                                    echo $versionType[B2S_PLUGIN_USER_VERSION];
                                }
                                ?>
                            </span>
                        </h2>
                        <?php if (defined("B2S_PLUGIN_TRAIL_END") && strtotime(B2S_PLUGIN_TRAIL_END) > time()) { ?>
                            <p> <span class="b2s-text-bold"><?php _e("End of Trial", "blog2social") ?></span>: <?php echo B2S_Util::getCustomDateFormat(B2S_PLUGIN_TRAIL_END, trim(strtolower(substr(B2S_LANGUAGE, 0, 2))), false); ?> 
                                <a class="b2s-text-bold" href="<?php echo B2S_Tools::getSupportLink('affiliate'); ?>" target="_blank">   <?php _e('Upgrade', 'blog2social') ?></a>
                            </p>
                            <br>
                        <?php } ?>

                        <p><?php _e('Upgrade to Blog2Social Premium and get even smarter with social media automation: Schedule your posts for the best time or recurringly with the Best Time Scheduler or the Social Media Calendar. Post to pages, groups and multiple accounts per network. ', 'blog2social') ?>
                            <a target="_blank" class="b2s-btn-link" href="<?php echo B2S_Tools::getSupportLink('affiliate'); ?>"><?php _e('Learn more', 'blog2social') ?></a></p>
                        <div class="clearfix"></div>
                        <br>
                        <div class="b2s-key-area">
                            <div class="input-group col-md-6 col-sm-12 col-xs-12">
                                <input class="form-control input-sm b2s-key-area-input" placeholder="<?php _e('Enter license key and change your version', 'blog2social'); ?>" value="" type="text">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm b2s-key-area-btn-submit"><?php _e('Activate Licence', 'blog2social'); ?></button>
                                </span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <hr class="b2s-premium-line">
                        <div class="clearfix"></div>
                        <h2 class="b2s-premium-go-to-text">
                            <?php _e('Go Premium and get even smarter with social media automation', 'blog2social') ?>
                        </h2>
                        <p class="b2s-text-bold"><?php _e("The free version of Blog2Social offers you a whole bunch of great features for automatic sharing on all connected social media networks. For those who want to achieve even more, Blog2Social Premium is your social media solution of choice:", "blog2social") ?></p>
                        <div class="col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0">
                            <div class="row">
                                <div class="col-md-3 col-hide-padding-left">
                                    <div class="thumbnail text-center">
                                        <img class="b2s-feature-img-with-90" src="<?php echo plugins_url('/assets/images/features/pages-groups.png', B2S_PLUGIN_FILE); ?>" alt="Auto-Posting">
                                    </div>
                                    <p class="text-center">
                                        <span class="b2s-text-bold"><?php _e('Pages and groups', 'blog2social') ?></span><br>
                                        <?php _e('Share your posts on pages and in groups on Facebook, LinkedIn, XING, VK and Medium.', 'blog2social') ?>
                                    </p>
                                </div>
                                <div class="col-md-3  col-hide-padding-left">
                                    <div class="thumbnail text-center">
                                        <img class="b2s-feature-img-with-90" src="<?php echo plugins_url('/assets/images/features/gmb-post.png', B2S_PLUGIN_FILE); ?>" alt="Customization">
                                    </div>
                                    <p class="text-center">
                                        <span class="b2s-text-bold"><?php _e('Google My Business', 'blog2social') ?></span><br>
                                        <?php _e('Schedule and share your blog posts as Google My Business posts to update your business listing and to add fresh content for your company.', 'blog2social') ?>
                                    </p>
                                </div>
                                <div class="col-md-3 col-hide-padding-left">
                                    <div class="thumbnail text-center">
                                        <img class="b2s-feature-img-with-90" src="<?php echo plugins_url('/assets/images/features/licenses.png', B2S_PLUGIN_FILE); ?>" alt="Scheduling">
                                    </div>
                                    <p class="text-center">
                                        <span class="b2s-text-bold"><?php _e('More users and accounts', 'blog2social') ?></span><br>
                                        <?php _e('Add multiple users and accounts per network. Define sharing-profiles for selected network bundles.', 'blog2social') ?>
                                    </p>
                                </div>
                                <div class="col-md-3 col-hide-padding-left">
                                    <div class="thumbnail text-center">
                                        <img class="b2s-feature-img-with-90" src="<?php echo plugins_url('/assets/images/features/support.png', B2S_PLUGIN_FILE); ?>" alt="Network">
                                    </div>
                                    <p class="text-center">
                                        <span class="b2s-text-bold"><?php _e('Premium support', 'blog2social') ?></span><br>
                                        <?php _e('Regular updates and priority support per e-mail and phone.', 'blog2social') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row b2s-premium-btn-group">
                                <a class="btn btn-primary" href="<?php echo B2S_Tools::getSupportLink('affiliate'); ?>" target="_blank">   <?php _e('Show me plans and prices', 'blog2social') ?></a>
                                <a class="btn btn-primary" href="<?php echo B2S_Tools::getSupportLink('feature'); ?>" target="_blank">   <?php _e('Show all premium features', 'blog2social') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Content|End-->
            </div>
            <?php require_once (B2S_PLUGIN_DIR . 'views/b2s/html/sidebar.phtml'); ?>
        </div>
    </div>
</div>
