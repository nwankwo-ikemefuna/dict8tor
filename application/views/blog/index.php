<?php
//search?
if (xget('q')) { ?>
    <h5><?php echo lang_string('showing_posts_having'); ?> <em><?php echo urldecode(xget('q')); ?></em></h5>
    <?php
}
?>

<div class="events-holder">
    <?php
    foreach ($records as $row) { ?>
        <div class="event-item">
            <div class="entry-attachment">
                <?php 
                if ($row->featured_video) { ?>
                    <div class="responsive-iframe">
                        <iframe src="<?php echo $row->featured_video; ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
                    </div>
                    <?php
                } else { ?>
                    <img src="<?php echo base_url('uploads/pix/blog/'.$row->featured_image); ?>" alt="<?php echo $row->title; ?>">
                    <?php
                } ?>
            </div>
            <div class="event-date">
                <div class="event-month"><?php echo date('M', strtotime($row->date_created)); ?></div>
				<div class="event-day"><?php echo date('d', strtotime($row->date_created)); ?></div>
            </div>
            <div class="event-info">
                <h4 class="event-link">
                    <a href="<?php echo blog_article_url($row->date_created, $row->slug); ?>"><?php echo $row->title; ?></a>
                </h4>
                <div class="entry-meta">
                    <span class="entry-cat"><?php echo lang_string('posted_in'); ?> <a href="<?php echo base_url('blog/categories/'.$row->category_slug); ?>"><?php echo $row->category_title; ?></a></span>
                </div>
                <?php echo article_snippet_word($row->content, 50); ?>
                <p><a href="<?php echo blog_article_url($row->date_created, $row->slug); ?>" class="info-btn"><?php echo lang_string('read_more'); ?></a></p>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php echo pagination_links($pagination_links, 'pagination'); ?>

                