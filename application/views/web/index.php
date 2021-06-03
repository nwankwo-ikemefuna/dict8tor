
<div class="dict8_note_help">
	<p>Click on the green microphone icon <i class="fa fa-microphone text-success"></i> to dictate your notes. Start dictating when it turns red <i class="fa fa-microphone text-danger"></i> and pulsating. Click on it again to pause/stop dictating.
	<a href="javascript:;" data-toggle="collapse" data-target="#dict8_help_more" class="text-info with_arrow_double_updown">More help <i class="fa fa-angle-double-down arrow_double_updown"></i></a></p>
	<div id="dict8_help_more" class="collapse">
		<ul>
			<li>Microphone permission is required to use <?php echo SITE_NAME; ?>. Select allow when prompted by your browser.</li>
			<li>Internet connectivity is required.</li>
			<li><?php echo SITE_NAME; ?> works on the following browsers: Chrome desktop (recommended for best experience), Chrome mobile, Android browser, Edge and Samsung Internet. It may also work on Safari (desktop and mobile).</li>
			<li>For accurate results, ensure your environment is noise-free.</li>
			<li>To add punctuations (such as period, comma, colon, semicolon, question mark, quotes, apostrophe, etc), space or any special character, stop dictating and type the character.</li>
			<li>Copy your notes or export to PDF and download when done. You may also save for later (<a href="#saved_notes_section" class="text-info">see here</a>).</li>
			<li>Your last notes will remain in the box even if you refresh this page or close your browser, unless you deliberately clear them.</li>
		</ul>
	</div>
</div>

<?php
$attrs = ['id' => 'dict8_form', 'class' => 'm-b-50'];
xform_open('api/web/note_actions', $attrs); ?>
	<div class="speech2text_section speech2text_interim_wrapper">
		<textarea name="note" id="s2t_dict8_note" class="form-control" rows="17"></textarea>
		<?php echo speech2text('s2t_dict8_note', 'textarea', '', true); ?>
		<span class="final_output"></span>
		<span class="interim_output"></span>
	</div>
	<?php
	xform_notice('status_msg', '', false);
	?>
	<button type="button" class="btn btn-secondary btn-sm btn-confident clickable" id="copy_note" title="Copy notes to clickboard"><i class="fa fa-copy"></i> Copy</button>
	<button type="button" class="btn btn-info btn-sm note_action btn-confident clickable" data-action="export_pdf" title="Export notes to PDF and download"><i class="fa fa-file-pdf-o"></i> PDF</button>
	<button type="button" class="btn btn-success btn-sm btn-confident clickable" id="save_note" title="Save notes for later"><i class="fa fa-save"></i> Save</button>
	<button type="button" class="btn btn-danger btn-sm btn-confident clickable" id="clear_note" title="Clear notes field"><i class="fa fa-trash-o"></i> Clear</button>
	<?php
xform_close();
?>

<hr />

<div class="row m-t-50">
	<div class="col-12 text-center">
		<?php echo web_share_icons(base_url(''), SITE_DESCRIPTION, 'share-wrap', 'social-icons share', true); ?>
	</div>
</div>