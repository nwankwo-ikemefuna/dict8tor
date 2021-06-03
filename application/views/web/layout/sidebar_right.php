<div class="card m-b-20" id="saved_notes_section" style="display: none;">
    <div class="card-header">
        <h5 class="mb-0">My Saved Notes</h5>
    </div>
    <div class="card-body">
        <div id="saved_notes"></div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-danger btn-sm btn-confident clickable" id="delete_all_saved_notes" title="Delete all saved notes"><i class="fa fa-trash-o"></i> Delete All</button>
    </div>
</div>

<?php

adsense_ad_unit('sidebar_square', ['slot' => '7395920235']);

$custom_ads_arr = [
    [
        'title' => 'Manage your school efficiently', 
        'content' => 'Quick School Manager (QSM) is a cloud based school management system that makes managing educational institutions easy and efficient.', 
        'button_text' => 'Learn more',
        'button_link' => 'https://qschoolmanager.com/',
    ],
    [
        'title' => 'Earn money while browsing', 
        'content' => 'Get paid for using your data on the internet.', 
        'button_text' => 'Learn more',
        'button_link' => 'https://refer.gener8ads.com/r/Cn67x6',
    ],
];
foreach ($custom_ads_arr as $ad) { ?>
    <div class="card m-b-20">
        <div class="card-body">
            <h5 class="card-title"><?php echo $ad['title']; ?></h5>
            <p class="card-text"><?php echo $ad['content']; ?></p>
            <a href="<?php echo $ad['button_link']; ?>" class="btn btn-info btn-sm btn-confident" target="_blank"><?php echo $ad['button_text']; ?></a>
        </div>
    </div>
    <?php
}

adsense_ad_unit('sidebar_vertical', ['slot' => '2467027187']);