<?php 
xform_open('api/assessment_questions/'.$page, xform_attrs());
    xform_notice(); 
    ?>
    <div class="row">
        <div class="<?php echo grid_col(12, '', 7); ?>">
            <?php
            if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
            xform_input('ass_id', 'hidden', $ass_id); ?>
            <div class="smt_wrapper">
                <?php
                xform_group_list('Question*', 'question', 'textarea', adit_value($row, 'question'), false, ['class' => 'smt_question', 'data-height' => 200]);
                $this->summernote->config([
                    'path' => SCHOOL_PIX_DIR.'/assessments',
                    'size' => 200, 
                    'resize' => false,
                    'content' => adit_value($row, 'question')
                ]); ?>
            </div>
            <?php
            xform_group_list('Order', 'order', 'number', adit_value($row, 'order', 1), true, ['min' => 1]);
            xform_group_list('Mark', 'mark', 'number', adit_value($row, 'mark'), true, ['min' => 0, 'class' => 'to_clear']); 
            $diff_levels = assessment_difficulty_levels();
            xform_group_list('Difficulty Level', 'diff_level', 'select', adit_value($row, 'diff_level'), false, 
                ['options' => $diff_levels, 'blank' => true]
            ); ?>
        </div>
        <div class="<?php echo grid_col(12, '', 5); ?>">
            <div class="form-group">
                <label class="form-control-label">Type*</label>
                <select name="type" class="form-control selectpicker">
                    <?php 
                    $labels = [
                        ASS_QT_SINGLE => 'Add options and select 1 correct answer. Score cannot be modified during marking.',
                        ASS_QT_MULT => 'Add options and select 1 or more correct answers. Score cannot be modified during marking.',
                        ASS_QT_SHORT => 'Specify a short, unambiguous answer to the question. Score may be modified during marking.',
                        ASS_QT_ESSAY => 'Answer is completely subjective, therefore, no answer is required. Score is given during marking.',
                    ];
                    foreach (assessment_question_types() as $q_type => $q_text) { 
                        $data_id = 'type_'.$q_type; 
                        $data_label = $labels[$q_type]; 
                        $selected = ($page == 'edit' && $row->type == $q_type) ? 'selected' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $q_type; ?>" data-id="<?php echo $data_id; ?>" data-label="<?php echo $data_label; ?>"><?php echo $q_text; ?></option>
                        <?php
                    } ?>
                </select>
            </div>
            <div class="">
                <label class="form-control-label">Options and/or Answer(s)</label> 
                <div id="type_label">
                    <?php echo ($page == 'edit') ? $labels[$row->type] : $labels[ASS_QT_SINGLE]; ?>
                </div>
                <?php 
                if ($page == 'edit') {
                    $first_display = $row->type == ASS_QT_SINGLE ? 'block' : 'none';
                } else{
                    $first_display = 'block';
                } ?>
                <div class="qtype_container" id="type_<?php echo ASS_QT_SINGLE; ?>" style="display: <?php echo $first_display; ?>">
                    <?php _opt_ans_area('radio', 'single', $page, $row); ?>
                </div>
                <div class="qtype_container" id="type_<?php echo ASS_QT_MULT; ?>" style="display: <?php echo ($page == 'edit' && $row->type == ASS_QT_MULT) ? 'block' : 'none'; ?>">
                    <?php _opt_ans_area('checkbox', 'mult', $page, $row); ?>
                </div>
                <div class="form-group qtype_container" id="type_<?php echo ASS_QT_SHORT; ?>" style="display: <?php echo ($page == 'edit' && $row->type == ASS_QT_SHORT) ? 'block' : 'none'; ?>">
                    <input type="text" class="form-control to_clear" name="answer_short" value="<?php echo ($page == 'edit') ? $row->answer : ''; ?>">
                </div>
            </div>
        </div>
    </div>
    <?php 
xform_close();

function _opt_ans_area($type, $append, $page, $row) { ?>
    <input type="hidden" name="answer_obj" value="<?php echo ($page == 'edit') ? $row->answer : ''; ?>" class="to_clear">
    <div class="opt_ans_area">
        <?php 
        if ($page == 'edit' && in_array($row->type, [ASS_QT_SINGLE, ASS_QT_MULT])) {
            $options = json_decode($row->options);
            //patch for explode(',', 0) returning null. TODO: Investigate bug later
            $answers_arr = $row->answer === '0' ? [0] : split_us($row->answer);
            foreach ($options as $key => $option) {
                $checked = in_array($key, $answers_arr);
                _obj_field($type, $append, $option, $checked);
            }
        } else {
            _obj_field($type, $append, '', false);
        } ?>
    </div>
    <button type="button" class="btn btn-info pull-right add_opt_ans" title="Add option"><i class="fa fa-plus"></i></button>
    <?php
}

function _obj_field($type, $append, $value, $checked) { ?>
    <div class="form-group opt_ans">
        <div class="input-group">
            <input type="text" class="form-control to_clear" name="options_<?php echo $append; ?>[]" value="<?php echo $value; ?>">
            <span class="input-group-addon">
                <input type="<?php echo $type; ?>" name="answer_<?php echo $append; ?>[]" class="answer_check to_clear" <?php echo $checked ? 'checked' : ''; ?> />
            </span>
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger remove_opt_ans" title="Remove option"><i class="fa fa-remove"></i></button>
            </span>
        </div>
    </div>
    <?php
} 

//double encode to handle double quotes, new lines, etc
$json = json_encode(json_encode(['question' => adit_value($row, 'question')])); ?>
<script type="text/javascript">
    $(document).ready(function(){
        summernote_init(".smt_question", {picture: true}, {height: 100});
        //load instruction into field
        var json = JSON.parse(<?php echo $json; ?>);
        $('[name="question"]').summernote('code', json.question);
    });
</script>