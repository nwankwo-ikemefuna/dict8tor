                </main>

                <aside id="sidebar" class="col-md-4 col-sm-12">
                    
                    <!-- search widget -->
                    <div class="widget widget-bg">
                        <div class="join-us style-3">
                            <?php
                            $attrs = [
                                'id' => 'search_blog_form', 
                                'class' => 'ajax_form join-form', 
                                'data-type' => 'redirect', 
                                'data-redirect' => '_dynamic',
                            ];
                            xform_open('api/blog/search', $attrs); ?>
                                <button type="submit" class="btn btn-style-4 f-right btn-search"></button>
                                <div class="input-holder">
                                    <input type="text" name="q" placeholder="<?php echo lang_string('search'); ?>" required>
                                </div>
                                <em class="ajax_form_processing" data-persist="1"><?php echo lang_string('searching'); ?>...</em>
                                <?php
                            xform_close(); ?>
                        </div>
                    </div>

                    <!-- blog categories widget -->
                    <div class="widget widget-bg">
                        <h5 class="wt-title"><?php echo lang_string('categories'); ?></h5>
                        <ul class="custom-list type-1">
                            <?php 
                            foreach ($blog_categories as $row) { ?>
                                <li><a href="<?php echo base_url('blog/categories/'.$row->slug); ?>"><?php echo $row->title; ?></a></li>
                                <?php
                            } ?>
                        </ul>
                    </div>

                    <!-- featured video widget -->
                    <div class="widget widget-holder">
                        <div class="widget-youtube">
                            <h5 class="wt-title"><?php echo lang_string('featured_video'); ?></h5>
                            <div class="responsive-iframe">
                                <iframe src="<?php echo youtube_embed_url($this->site_info->intro_video); ?>?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- featured posts widget -->
                    <div class="widget widget-bg">
                        <h5 class="wt-title"><?php echo lang_string('featured_posts'); ?></h5>
                        <div class="events-holder">
                            <?php
                            foreach ($featured_posts as $row) { ?>
                                <div class="event-item">
                                    <div class="event-date type-2"></div>
                                    <div class="event-info">
                                        <h6 class="event-link"><a href="<?php echo blog_article_url($row->date_created, $row->slug); ?>" class="text-bold"><?php echo $row->title; ?></a></h6>
                                        <time class="entry-date" datetime="<?php echo date('Y-m-d', strtotime($row->date_created)); ?>"><?php echo date('M d, Y', strtotime($row->date_created)); ?></time>
                                    </div>
                                </div>
                                <?php 
                            } ?>
                        </div>
                        <a href="<?php echo base_url('blog'); ?>" class="info-btn"><?php echo lang_string('more_news'); ?></a>
                    </div>

                    <!-- subscription widget -->
                    <div class="widget widget-bg2">
                        <h5 class="wt-title"><?php echo lang_string('subscribe_to_newsletter'); ?></h5>
                        <div class="join-us style-4">
                            <p><?php echo lang_string('subscribe_to_be_updated'); ?></p>
                            <?php
                            $attrs = [
                                'id' => 'subscribe_blog_form', 
                                'class' => 'ajax_form join-form', 
                                'data-type' => 'none', 
                                'data-redirect' => '_void', 
                                'data-clear' => 1,
                                'data-msg' => lang_string('subscription_thank_you')
                            ];
                            xform_open('api/web/subscribe', $attrs); ?>
                                <input type="email" name="email" placeholder="<?php echo lang_string('email_address'); ?>" required>
                                <input type="text" name="phone" placeholder="<?php echo lang_string('phone'); ?>" required>
                                <?php
                                xform_notice('status_msg', '', false); 
                                ?>
                                <p class="ajax_form_processing text-white"><em>Subscribing...</em></p>
                                <button type="submit" class="btn btn-style-6 btn-big"><?php echo lang_string('subscribe'); ?></button>
                                <?php
                            xform_close(); ?>
                        </div>
                    </div>

                </aside>

            </div>
        </div>
    </div>
</div>