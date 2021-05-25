    <footer id="footer" class="footer-2">

        <div class="top-footer">
            <div class="container">
                <ul class="top-footer-menu">
                    <li class="<?php echo active_link($current_page, 'home', 'current'); ?>"><a href="<?php echo base_url(); ?>"><?php echo lang_string('home'); ?></a></li>
                    <li class="<?php echo active_link($current_page, 'about', 'current'); ?>"><a href="<?php echo base_url('about'); ?>"><?php echo lang_string('about'); ?></a></li>
                    <li class="<?php echo active_link($current_page, 'videos', 'current'); ?>"><a href="<?php echo base_url('videos'); ?>"><?php echo lang_string('videos'); ?></a></li>
                    <?php
                    if ($this->hands_on_info->published) { ?>
                        <li class="<?php echo active_link($current_page, 'hands_on', 'current'); ?>"><a href="<?php echo base_url('hands-on'); ?>"><?php echo lang_string('hands_on'); ?></a></li>
                        <?php
                    } ?>
                    <li class="<?php echo active_link($current_page, 'blog', 'current'); ?>"><a href="<?php echo base_url('blog'); ?>"><?php echo lang_string('blog'); ?></a></li>
                </ul>
            </div>
        </div>

        <div class="main-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="widget">
                            <h6 class="widget-title"><?php echo lang_string('subscribe_to_newsletter'); ?></h6>
                            <div class="join-us style-2">
                                <?php
                                $attrs = [
                                    'id' => 'subscribe2_form', 
                                    'class' => 'ajax_form join-form', 
                                    'data-type' => 'none', 
                                    'data-redirect' => '_void', 
                                    'data-clear' => 1,
                                    'data-msg' => lang_string('subscription_thank_you')
                                ];
                                xform_open('api/web/subscribe', $attrs); ?>
                                    <div class="input-holder">
                                        <input type="email" name="email" placeholder="<?php echo lang_string('email_address'); ?>" required>
                                        <input type="text" name="phone" placeholder="<?php echo lang_string('phone'); ?>" required>
                                    </div>
                                    <?php xform_notice('status_msg', '', false); ?>
                                    <button type="submit" class="btn btn-style-6 btn-big"><?php echo lang_string('subscribe'); ?></button>
                                    <?php
                                xform_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="widget">
                            <div class="align-center">
                                <a href="<?php echo base_url(); ?>" class="logo"><img src="<?php echo SITE_LOGO_WEB; ?>" alt="<?php echo SITE_NAME; ?>"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="widget align-right">
                            <?php
                            if ($this->candidate_info->sm_facebook || $this->candidate_info->sm_twitter || $this->candidate_info->sm_instagram) { ?>
                                <h6 class="widget-title"><?php echo lang_string('connect_with'); ?> <?php echo $this->candidate_info->display_name_short; ?></h6>
                                <ul class="social-icons">
                                    <?php
                                    if ($this->candidate_info->sm_facebook) { ?>
                                        <li><a href="<?php echo $this->candidate_info->sm_facebook; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                                        <?php 
                                    }
                                    if ($this->candidate_info->sm_twitter) { ?>
                                        <li><a href="<?php echo $this->candidate_info->sm_twitter; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                                        <?php 
                                    }
                                    if ($this->candidate_info->sm_instagram) { ?>
                                        <li><a href="<?php echo $this->candidate_info->sm_instagram; ?>" target="_blank"><i class="icon-instagram-5"></i></a></li>
                                        <?php 
                                    } ?>
                                </ul>
                                <?php 
                            } 
                            if ($this->is_campaign_phase) { ?>
                                <div class="button-holder">
                                    <a href="javascript:;" class="btn btn-style-6 btn-big donate_btn"><?php echo lang_string('donate'); ?></a>
                                </div>
                                <?php 
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="widget">
                        <p><?php echo $this->site_info->address; ?> &nbsp;|&nbsp; <?php echo lang_string('phone'); ?>: <span><?php echo $this->site_info->phone; ?></span> &nbsp;|&nbsp; <?php echo lang_string('email'); ?>: <a href="mailto:<?php echo $this->site_info->email; ?>" class="link-text"><?php echo $this->site_info->email; ?></a></p>
                    </div>
                    <div class="paid-by"><?php echo lang_string('powered_by'); ?> <a href="<?php echo SITE_AUTHOR_URL; ?>"><?php echo SITE_AUTHOR; ?></a></div>
                    <p><?php echo date('Y'); ?>. <?php echo SITE_NAME; ?></p>
                </div>
            </div>
        </div>

    </footer>

</div>
<!-- - - - - - - - - - - - end Wrapper - - - - - - - - - - - - - - -->

<?php csrf_input(); ?>

<?php
//General modals

//the guy that handles loading of stuff 
ajax_overlay_loader(); ?>

<!-- Vendors -->
<script src="<?php echo base_url(); ?>assets/web/template/js/libs/jquery.modernizr.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/js/libs/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/js/libs/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/js/libs/retina.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/instafeed.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/twitter/jquery.tweet.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/jquery.queryloader2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-validate/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/jquery-steps/js/jquery.steps.min.js"></script>
<!-- <script src="<?php //echo base_url(); ?>assets/vendors/selectpicker/js/bootstrap-select.min.js"></script> -->

<!-- Template scripts -->
<script src="<?php echo base_url(); ?>assets/web/template/js/plugins.js"></script>
<script src="<?php echo base_url(); ?>assets/web/template/js/script.js"></script>

<!-- General Custom scripts -->
<script src="<?php echo base_url(); ?>assets/common/js/general.js"></script>
<!-- Utils -->
<script src="<?php echo base_url(); ?>assets/common/js/ajax.js"></script>

<?php
//custom page-specific scripts
load_scripts($this->page_scripts, 'assets/web/custom/js'); 
?>

<?php 
$requested_resource = get_requested_resource_ajax();
?>
<script type="text/javascript">
    //pass vars to javascript
    var base_url = "<?php echo base_url(); ?>",
        c_controller = "<?php echo $this->c_controller; ?>",
        current_page = "<?php echo $current_page; ?>",
        is_loggedin = <?php echo json_encode((Bool)$this->session->user_loggedin); ?>,
        is_portal = false,
        csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>",
        ajax_requested_page = "<?php echo $requested_resource; ?>",
        date_today = "<?php echo date('d-m-Y'); ?>",
        current_datetime = "<?php echo date('Y-m-d H:i:s'); ?>";
</script>

</body>
</html>