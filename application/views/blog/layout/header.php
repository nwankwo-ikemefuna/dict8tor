<div id="content">

    <div class="page-content-wrap">
        <div class="container">

            <?php 
            if ($breadcrumbs) { ?>
                <div class="breadcrumbs-wrap with-bg2">
                    <div class="container">
                        <h1 class="page-title"><?php echo $page_title; ?></h1>
                        <ul class="breadcrumbs">
                            <?php
                            foreach ($breadcrumbs as $title => $url) { ?>
                                <li>
                                    <?php 
                                    //last one? no link required
                                    if ($url == '*') { 
                                        echo $title;
                                    } else { ?>
                                        <a href="<?php echo base_url($url); ?>"><?php echo $title; ?></a>
                                        <?php
                                    } ?>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </div>
                </div>
                <?php 
            } ?>
        
            <div class="row">
                <main id="main" class="col-md-8 col-sm-12">