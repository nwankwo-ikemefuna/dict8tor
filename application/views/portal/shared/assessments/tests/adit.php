<?php 
xform_open('api/assessments/'.$page, xform_attrs());
    xform_notice(); 
    ?>
    <div class="row">
        <div class="<?php echo grid_col(12, '', 6); ?>">
            <?php
            if ($page == 'edit') { 
                xform_input('id', 'hidden', $row->id);
            } 
            xform_input('group_id', 'hidden', $group_id);
            xform_group_list('Course', 'course_id', 'select', adit_value($row, 'course_id'), false, 
                ['options' => $courses, 'text_col' => 'name', 'blank' => true, 'extra' => ['id' => 'course_id', 'class' => 'to_clear']]
            );
            xform_group_list('Title', 'title', 'text', adit_value($row, 'title'), true, ['class' => 'to_clear']);
            xform_group_list('Pass Mark (%)', 'passmark', 'number', adit_value($row, 'passmark'), true, ['class' => 'to_clear', 'min' => 0, 'max' => 100]);
            xform_group_list('Questions to answer <small class="text-muted">(leave blank or put 0 to answer all)</small>', 'to_answer', 'number', adit_value($row, 'to_answer', 0), false, ['class' => 'to_clear', 'min' => 0, 'help' => 'Great if question shuffling is enabled']);
            xform_check('Shuffle questions', 'shuffle', 'checkbox', 'shuffle', 1, ($page == 'edit' && $row->shuffle == 1),  false, false, ['class' => 'to_clear']);
            xform_check('Provide score feedback after marking', 'score_feedback', 'checkbox', 'score_feedback', 1, ($page == 'edit' && $row->score_feedback == 1), false, false, ['class' => 'to_clear']); 
            xform_check('Provide full feedback after marking', 'feedback', 'checkbox', 'feedback', 1, ($page == 'edit' && $row->feedback == 1), false, false, ['class' => 'to_clear']); ?>
        </div>
        <div class="<?php echo grid_col(12, '', 6); ?>">
            <?php
            xform_group_list('Duration (in minutes)', 'duration', 'number', adit_value($row, 'duration'), true, ['class' => 'to_clear', 'min' => 0]);
            xform_group_html_datepicker_list('Available From', 'open_date', 'datetime-local', adit_value($row, 'open_date', date('Y-m-d H:i')), true, true); 
            xform_group_html_datepicker_list('Unavailable From', 'close_date', 'datetime-local', adit_value($row, 'close_date', date('Y-m-d H:i')), false, true, [], [], ['id' => 'close_date_box', 'style' => ($page == 'edit' && $row->leave_open) ? 'display:none' : 'display:block']); 
            xform_check('Leave available indefinitely', 'leave_open', 'checkbox', 'leave_open', 1, ($page == 'edit' && $row->leave_open == 1), false, false, ['class' => 'to_clear', 'id' => 'leave_open']);
            xform_group_list('Instructions', 'instructions', 'textarea', adit_value($row, 'instructions', '', true), false, ['class' => 'to_clear']);
            ?>
        </div>
    </div>
    <?php 
xform_close();
