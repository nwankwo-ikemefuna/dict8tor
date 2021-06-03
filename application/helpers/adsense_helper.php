<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function adsense_publisher_script() {
    if (!ADSENSE_CONFIG['enabled']) return '';
    return '<script data-ad-client="'.ADSENSE_CONFIG['publisher_id'].'" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
}

function adsense_ad_unit($type, array $config) {
    if (!ADSENSE_CONFIG['enabled'] || !ADSENSE_CONFIG[$type]) return '';
    ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="<?php echo ADSENSE_CONFIG['publisher_id']; ?>"
        data-ad-slot="<?php echo $config['slot']; ?>"
        data-ad-format="<?php echo $config['format'] ?? 'auto'; ?>"
        data-full-width-responsive="<?php echo $config['responsive_width'] ?? 'true'; ?>">
    </ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <?php
}