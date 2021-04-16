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

function donation_amounts() {
    if (IN_NIGERIA) {
        $amounts = [1000, 5000, 10000, 25000, 50000, 100000, 250000];
    } else {
        $amounts = [10, 50, 100, 250, 500, 1000, 2500];
    }
    return $amounts;
}

function get_currency_code() {
    return IN_NIGERIA ? CU_NAIRA : '$';
}

function web_icons() {
    $icons = [
        //basic
        'basic-accelerator', 'basic-alarm', 'basic-anchor', 'basic-anticlockwise', 'basic-archive', 'basic-archive-full', 
        'basic-ban', 'basic-battery-charge', 'basic-battery-empty', 'basic-battery-full', 'basic-battery-half', 'basic-bolt', 'basic-book-pen', 'basic-book-pencil', 'basic-bookmark',
        'basic-calculator', 'basic-calendar', 'basic-cards-diamonds', 'basic-cards-hearts', 'basic-case', 'basic-chronometer', 'basic-clessidre', 'basic-clock', 'basic-clockwise', 'basic-cloud', 'basic-club', 'basic-compass', 'basic-cup',
        'basic-diamonds', 'basic-display', 'basic-download', 
        'basic-exclamation', 'basic-eye', 'basic-eye-closed', 
        'basic-female', 'basic-flag1', 'basic-flag2', 'basic-floppydisk', 'basic-folder', 'basic-folder-multiple', 
        'basic-gear', 'basic-geolocalize-01', 'basic-geolocalize-05', 'basic-globe', 'basic-gunsight', 
        'basic-hammer', 'basic-headset', 'basic-heart', 'basic-heart-broken', 'basic-helm', 'basic-home', 
        'basic-info', 'basic-ipod',
        'basic-joypad',
        'basic-key', 'basic-keyboard', 
        'basic-laptop', 'basic-life-buoy', 'basic-lightbulb', 'basic-link', 'basic-lock', 'basic-lock-open', 
        'basic-magic-mouse', 'basic-magnifier', 'basic-magnifier-minus', 'basic-magnifier-plus', 'basic-mail', 'basic-mail-multiple', 'basic-mail-open', 'basic-mail-open-text', 'basic-male', 'basic-map', 'basic-message', 'basic-message-multiple', 'basic-message-txt', 'basic-mixer2', 'basic-mouse',
        'basic-notebook', 'basic-notebook-pen', 'basic-notebook-pencil',  
        'basic-paperplane', 'basic-pencil-ruler', 'basic-pencil-ruler-pen', 'basic-photo', 'basic-picture', 'basic-picture-multiple', 'basic-pin1', 'basic-pin2', 'basic-postcard', 'basic-postcard-multiple', 'basic-printer', 
        'basic-question', 
        'basic-rss', 
        'basic-server', 'basic-server2', 'basic-server-cloud', 'basic-server-download', 'basic-server-upload', 'basic-settings', 'basic-share', 'basic-sheet', 'basic-sheet-multiple', 'basic-sheet-pen', 'basic-sheet-pencil', 'basic-sheet-txt', 'basic-signs', 'basic-smartphone', 'basic-spades', 'basic-spread', 'basic-spread-bookmark', 'basic-spread-text', 'basic-spread-text-bookmark', 'basic-star',
        'basic-tablet', 'basic-target', 'basic-todo', 'basic-todo-pen', 'basic-todo-pencil', 'basic-todo-txt', 'basic-todolist-pen', 'basic-todolist-pencil', 'basic-trashcan', 'basic-trashcan-full', 'basic-trashcan-refresh', 'basic-trashcan-remove', 
        'basic-upload', 'basic-usb',
        'basic-video', 
        'basic-watch', 'basic-webpage', 'basic-webpage-img-txt', 'basic-webpage-multiple', 'basic-webpage-txt', 'basic-world',
        //ecommerce
        'ecommerce-banknote', 'ecommerce-banknotes', 
        'ecommerce-creditcard', 
        'ecommerce-diamond', 
        'ecommerce-gift', 
        'ecommerce-money',
        'ecommerce-naira',
        'ecommerce-receipt-naira',
        'ecommerce-safe',
        'ecommerce-ticket',
        'ecommerce-won',
    ];
    return $icons;
}

function blog_article_url($date_created, $slug, $full_url = true) {
    $url = 'post/'.date('Y-m-d', strtotime($date_created)).'/'.$slug;
    if (!$full_url) return $url;
    return base_url($url);
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

function portal_image_widget($image, $title, $fieldset_class = '') { ?>
    <fieldset class="scheduler-border image_widget <?php echo $fieldset_class; ?>">
        <legend class="scheduler-border"><?php echo $title; ?></legend>
        <div style="background: grey; padding: 10px;">
            <img class="" src="<?php echo base_url($image); ?>">
        </div>
    </fieldset>
    <?php 
}

function portal_video_widget($url, $title, $fieldset_class = '') { ?>
    <fieldset class="scheduler-border video_widget <?php echo $fieldset_class; ?>">
        <legend class="scheduler-border"><?php echo $title; ?></legend>
        <div style="background: grey; padding: 10px;">
            <iframe src="<?php echo youtube_embed_url($url); ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
        </div>
    </fieldset>
    <?php 
}