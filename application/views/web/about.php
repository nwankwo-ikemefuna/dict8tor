<div id="content" class="about-page">
    <div class="page-content-wrap2">
        

        <?php
        if ($this->site_info->about_intro) { ?>
            <div class="page-section type5 half-bg-col">
                <div class="img-col-left"><div class="col-bg" data-bg="<?php echo base_url('uploads/pix/info/'.$this->site_info->about_intro_photo); ?>"></div></div>
                <div class="container extra-size">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <h3><?php echo lang_string('about'); ?> <?php echo $this->candidate_info->display_name_short; ?></h3>
                            <div class="content-element3">
                                <?php echo $this->site_info->about_intro; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } 

        if ($this->site_info->about_public_service) { ?>
            <div class="page-section-bg type5 half-bg-col">
                <div class="img-col-right"><div class="col-bg" data-bg="<?php echo base_url('uploads/pix/info/'.$this->site_info->about_public_service_photo); ?>"></div></div>
                <div class="container extra-size">
                    <div class="row">
                        <div class="col-md-6">
                            <h3><?php echo lang_string('public_service'); ?></h3>
                            <div class="content-element3">
                                <?php echo $this->site_info->about_public_service; ?>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
            <?php 
        } 

        if ($this->site_info->about_family) { ?>
            <div class="page-section type5 half-bg-col content-element7">
                <div class="img-col-left"><div class="col-bg" data-bg="<?php echo base_url('uploads/pix/info/'.$this->site_info->about_family_photo); ?>"></div></div>
                <div class="container extra-size">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <h3><?php echo $this->candidate_info->display_name_short; ?><?php echo lang_string('s_ownership') . ' ' . lang_string('family'); ?> </h3>
                            <div class="content-element3">
                                <?php echo $this->site_info->about_family; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } ?>

        <div class="container extra-size">
            <?php echo web_share_icons(base_url('about'), '', 'share-wrap style-2'); ?>
        </div>

    </div>
</div>