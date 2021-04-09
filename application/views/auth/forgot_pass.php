<?php
$attrs = [
    'id' => 'forgot_pass_form', 
    'class' => 'ajax_form material-form', 
    'data-type' => 'none',
    'data-redirect' => '_void',
    'data-msg' => 'Instructions to reset your password has been sent to your email'
];
xform_open('api/account/forgot_pass', $attrs);
    xform_group_grid('Email', 'email', 'email', '', true, ['id' => 'email'], ['class' => 'floating-label']);
    xform_notice();
    xform_submit('Recover', $attrs['id'], ['class' => 'btn-theme ripple btn-raised btn-block btn-submit']);
xform_close();