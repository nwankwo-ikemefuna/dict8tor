<?php
$redirect_url = base_url('login');
$attrs = [
    'id' => 'reset_pass_form', 
    'class' => 'ajax_form material-form', 
    'data-type' => 'redirect',
    'data-redirect' => $redirect_url,
    'data-msg' => "Password reset successful. Redirecting... <p>If you are not automatically redirected, <a href='{$redirect_url}'>click here</a></p>"
];
xform_open('api/account/reset_pass', $attrs);
    xform_group_grid('Email', 'email', 'email', '', true, ['id' => 'email'], ['class' => 'floating-label']);
    xform_group_grid('Password', 'password', 'password', '', true, ['id' => 'password'], ['class' => 'floating-label']);
    xform_group_grid('Confirm Password', 'c_password', 'password', '', true, ['id' => 'c_password'], ['class' => 'floating-label']);
    xform_notice();
    xform_submit('Reset', $attrs['id'], ['class' => 'btn-theme ripple btn-raised btn-block btn-submit']);
xform_close();