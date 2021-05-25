<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function email_call2action_red($url, $caption) {
	return '<table>
				<tr>
					<td style="background-color: #cc0821; border-color: #cc0821; border: 2px solid #cc0821; padding: 10px; text-align: center;">
						<a style="display: block; color: #ffffff; font-size: 17px; text-decoration: none; font-size: 18px;" href="' .$url. '">'
							.$caption. ' &raquo;
						</a>
					</td>
				</tr>
			</table>';
}

function email_call2action_blue($url, $caption) {
	return '<table>
				<tr>
					<td style="background-color: #0e67bf; border-color: #0e67bf; border: 2px solid #0e67bf; padding: 10px; text-align: center;">
						<a style="display: block; color: #ffffff; font-size: 17px; text-decoration: none; text-transform: capitalize;" href="' .$url. '">'
							.$caption.
						'</a>
					</td>
				</tr>
			</table>';
}

function email_header($subject) {
	return 	'<center>
				<a href="' . base_url() . '">
					<img src="' . SITE_LOGO .'">
				</a>
			</center>';
}

function email_footer() {
	$ci =& get_instance();
	return 	'<br /><br /><hr style="color: #f2f2f2"> 
			<center>
				<a href="' . base_url() . '">' . SITE_NAME . '</a>. 
				Powered by <a href="' . SITE_AUTHOR_URL . '">' . SITE_AUTHOR . '</a>
			</center>';
}

function invoice_header($recipient_name, $recipient_email, $recipient_address, $due = null) {
	$id = generate_code(8);
	$table_style = 'width: 100%; line-height: inherit; text-align: left;';
	return '
		<div style="
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif;
			color: #555;">
            <table cellpadding="0" cellspacing="0" style="'.$table_style.'">
				<tr>
					<td colspan="2">
						<table style="'.$table_style.'">
							<tr>
								<td style="font-size: 45px; line-height: 45px; color: #333;">
									<img src="'.SITE_LOGO.'" style="width:100%; max-width:160px;">
								</td>
								<td style="padding-bottom: 20px; text-align: right;">
									Invoice #: '.$id.'<br>
									Created: '.date('F d, Y ').
									(strlen($due) ? '<br> Due: '.$due : '') .
								'</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table style="'.$table_style.'">
							<tr>
								<td style="padding-bottom: 40px;">
									'.SITE_NAME.'.<br>
									'.SITE_LOCATION.'.<br>
								</td>
								<td style="padding-bottom: 40px; text-align: right;">
									'.$recipient_name.'.<br>
									'.$recipient_address.'.<br>
									'.$recipient_email.'
								</td>
							</tr>
						</table>
					</td>
				</tr>';
}

function invoice_footer() {
	return '</table></div>';
}

function invoice_item_heading($key, $value) {
	$td_style = 'background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;';
	$markup = '<tr>';
	$markup .= '<td style="'.$td_style.'">'.$key.'</td>';
	$markup .= '<td style="'.$td_style.' text-align: right;">'.$value.'</td>';
	$markup .= '</tr>';
	return $markup;
}

function invoice_item($key, $value) {
	$td_style = 'border-bottom: 1px solid #eee;';
	$markup = '<tr>';
	$markup .= '<td style="'.$td_style.'">'.$key.'</td>';
	$markup .= '<td style="'.$td_style.' text-align: right;">'.$value.'</td>';
	$markup .= '</tr>';
	return $markup;
}

function invoice_total($key, $value) {
	$td_style = 'border-top: 2px solid #eee; font-weight: bold;';
	$markup = '<tr>';
	$markup .= '<td style="">'.$key.'</td>';
	$markup .= '<td style="'.$td_style.' text-align: right;">'.$value.'</td>';
	$markup .= '</tr>';
	return $markup;
}

function extract_emails($records, $field = 'email') {
	$emails = [];
	foreach ($records as $row) {
		if (isset($row->$field) && !empty($row->$field)) {
			$emails[] = $row->$field; 
		}
	}
	return $emails;
}

function send_mail($from, $to, $subject, $message, $sender_name = SITE_NAME, $attachment = NULL) {
	$ci =& get_instance();
	//[if mso] is hack for Microsoft Outlook, which does not support css margin and max-width properties
	$x_message = '
		<!--[if mso]>
			<div style="text-align: center">
				<table><tr><td width="650">
		<![endif]-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: auto; max-width: 650px; border: 2px solid #f2f2f2; padding: 15px 50px;">
			<tr>
				<td>' . email_header($subject) . $message. email_footer() . '</td>
			</tr>
		</table>
		<!--[if mso]>
				</td></tr></table>
			</div>
		<![endif]-->'; 
	$ci->email->from($from, $sender_name); 
	if (is_array($to)) {
		$ci->email->bcc($to);
	} else {
		$ci->email->to($to);
	}
	$ci->email->subject($subject); 
	$ci->email->message($x_message);
	if ($attachment) $ci->email->attach($attachment);
	return @$ci->email->send();
}