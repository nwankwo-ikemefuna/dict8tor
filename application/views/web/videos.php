<div id="content">
    <div class="page-content-wrap">
        <div class="container">
            <div class="isotope two-collumn clearfix portfolio-holder" data-isotope-options='{"itemSelector" : ".item","layoutMode" : "fitRows","transitionDuration":"0.7s","fitRows" : {"columnWidth":".item"}}'>
                <?php
                foreach ($records as $row) { ?>
                    <div class="item">
                        <div class="project">
                            <div class="project-image">
                                <div class="responsive-iframe">
                                    <iframe src="<?php echo youtube_embed_url($row->content); ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0&amp;" allowfullscreen="true"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </div>
            <?php echo pagination_links($pagination_links, 'pagination'); ?>
        </div>
    </div>
</div>