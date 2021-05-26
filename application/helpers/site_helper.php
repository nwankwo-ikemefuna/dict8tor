<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_site_languages() {
    $languages = [
        ['key' => 'english', 'title' => 'English', 'alias' => 'EN'],
        ['key' => 'efik', 'title' => 'Efik', 'alias' => 'Efik']
    ];
    return $languages;
}

function lang_string($key) {
    $ci =& get_instance();
    $str = $ci->lang_strings[$key] ?? '';
    return $str;
}
function get_currency_code() {
    return IN_NIGERIA ? CU_NAIRA : '$';
}

function web_share_icons($url, $snippet = '', $wrapper_class = 'share-wrap', $ul_class = 'social-icons share', $show_hint = true) { ?>
    <div class="<?php echo $wrapper_class; ?>">
        <?php
        if ($show_hint) { ?>
            <span class="share-title"><?php echo lang_string('share_this'); ?>:</span>
            <?php 
        } ?>
        <ul class="<?php echo $ul_class; ?>">
            <li><?php echo facebook_share_link($url, '<i class="icon-facebook"></i>Facebook</a>', 'sh-facebook'); ?></li>
            <li><?php echo linkedin_share_link($url, '<i class="icon-linkedin"></i>Linkedin</a>', 'sh-linkedin'); ?></li>
            <li><?php echo twitter_share_link($url, $snippet, '<i class="icon-twitter"></i>Twitter</a>', 'sh-twitter'); ?></li>
            <li><?php echo whatsapp_share_link($url, $snippet, '<i class="icon-whatsapp"></i>WhatsApp</a>', 'sh-whatsapp'); ?></li>
        </ul>
    </div>
    <?php
}

function portal_image_widget($image, $title, $fieldset_class = '', $fieldset_inline_style = '') { ?>
    <fieldset class="scheduler-border image_widget <?php echo $fieldset_class; ?>" style="<?php echo $fieldset_inline_style; ?>">
        <legend class="scheduler-border"><?php echo $title; ?></legend>
        <div style="background: grey; padding: 10px;">
            <img class="" src="<?php echo get_uploaded_file($image); ?>">
        </div>
    </fieldset>
    <?php 
}

function portal_video_widget($url, $title, $fieldset_class = '') { ?>
    <fieldset class="scheduler-border video_widget <?php echo $fieldset_class; ?>">
        <legend class="scheduler-border"><?php echo $title; ?></legend>
        <div style="background: grey; padding: 10px;">
            <iframe src="<?php echo youtube_embed_url($url); ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0" allowfullscreen></iframe>
        </div>
    </fieldset>
    <?php 
}