<div id="accordion">
    <?php 
    $card_data = [
        ['key' => 'applicant', 'title' => 'Applicant'],
        ['key' => 'grant', 'title' => 'Grant'],
        ['key' => 'ngo', 'title' => 'Organisation'],
    ];
    $i = 0;
    foreach ($card_data as $c_data) { ?>
        <div class="card">
            <div class="card-header" id="heading_<?php echo $c_data['key']; ?>">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#tab_<?php echo $c_data['key']; ?>" aria-expanded="<?php echo (bool)($i == 0); ?>" aria-controls="tab_<?php echo $c_data['key']; ?>">
                        <?php echo $c_data['title']; ?> Details
                    </button>
                </h5>
            </div>
            <div id="tab_<?php echo $c_data['key']; ?>" class="collapse <?php echo ($i == 0) ? 'show' : ''; ?>" aria-labelledby="heading_<?php echo $c_data['key']; ?>" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <?php
                        $column_data_arr = ${'form_elements_'.$c_data['key']};
                        foreach ($column_data_arr as $element_arr) { ?>
                            <div class="col-12 col-sm-<?php echo $element_arr['col']; ?>">
                                <?php
                                $column = isset($element_arr['render']) ? $element_arr['render'] : $element_arr['name'];
                                if ($element_arr['type'] == 'textarea') {
                                    data_show_list($element_arr['title'], $row->$column, '', 'bordered_data wysiwyg_content');
                                } else {
                                    if ($element_arr['name'] == 'grant_project_video') {
                                        $video_iframe = '<iframe width="100%" height="300px" src="'.youtube_embed_url($row->$column).'?rel=0&amp;showinfo=0&amp;autohide=2&amp;controls=0&amp;" allowfullscreen="true"></iframe>';
                                        data_show_list($element_arr['title'], $video_iframe);
                                    } else {
                                        data_show_grid($element_arr['title'], $row->$column);
                                    }
                                } ?>
                            </div>
                            <?php 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
</div>