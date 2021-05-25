<div class="event-item single-event">
    <div class="entry-attachment">
        <img src="<?php echo get_uploaded_file('pix/blog/'.$row->featured_image); ?>" alt="<?php echo $row->title; ?>">
    </div>
    <div class="event-info">
        <div class="entry-meta">
            <time class="entry-date" datetime="<?php echo date('Y-m-d', strtotime($row->date_created)); ?>"><?php echo date('M d, Y', strtotime($row->date_created)); ?></time>
            <span class="entry-cat"><?php echo lang_string('posted_in'); ?> <a href="<?php echo base_url('blog/categories/'.$row->category_slug); ?>"><?php echo $row->category_title; ?></a></span>
        </div>
        <div class="wysiwyg_content">
            <?php echo $row->content; ?>
        </div>
        <?php 
        if ($row->featured_video) { ?>
            <div class="responsive-iframe m-t-30">
                <iframe src="<?php echo $row->featured_video; ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
            </div>
            <?php
        } ?>
    </div>
    <div class="content-element4">
        <?php echo web_share_icons(blog_article_url($row->date_created, $row->slug), $row->title, 'share-wrap'); ?>
    </div>
</div>

<?php
if ($related_posts) { ?>
    <div class="content-element">	
        <h3>Related Posts</h3>
        <div class="events-holder type-2 small-events">
            <div class="row">
                <?php
                foreach ($related_posts as $rel_row) { ?>
                    <div class="col-xs-4">
                        <div class="event-item">
                            <div class="entry-attachment">
                                <?php 
                                if ($rel_row->featured_video) { ?>
                                    <div class="responsive-iframe">
                                        <iframe src="<?php echo $rel_row->featured_video; ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
                                    </div>
                                    <?php
                                } else { ?>
                                    <img src="<?php echo get_uploaded_file('pix/blog/'.$rel_row->featured_image); ?>" alt="<?php echo $rel_row->title; ?>">
                                    <?php
                                } ?>
                            </div>
                            <div class="event-info">
                                <h6 class="event-link"><a href="<?php echo blog_article_url($rel_row->date_created, $rel_row->slug); ?>" class="text-bold"><?php echo $rel_row->title; ?></a></h6>
                                <div class="entry-meta">
                                    <time class="entry-date" datetime="<?php echo date('Y-m-d', strtotime($rel_row->date_created)); ?>"><?php echo date('M d, Y', strtotime($rel_row->date_created)); ?></time>
                                    <span class="entry-cat"><?php echo lang_string('posted_in'); ?> <a href="<?php echo base_url('blog/categories/'.$rel_row->category_slug); ?>"><?php echo $rel_row->category_title; ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                } ?>
            </div>
        </div>
    </div>
    <?php 
}