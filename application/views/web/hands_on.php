<div id="content" class="about-page">
	<div class="page-content-wrap2">

		<div class="container">
			<div class="row">
				<main id="main" class="col-md-12">

					<div class="content-element4 m-t-30">
						<p><?php echo $row->content; ?></p>
					</div>

					<div class="join-us style-4">

						<?php
						function _hands_on_form($form_elements) {
							foreach ($form_elements as $element_arr) { ?>
								<div class="col-xs-12 col-sm-<?php echo $element_arr['col']; ?>">
									<?php
									$input_extra = $fg_extra = [];
									if (isset($element_arr['id']) && $element_arr['id']) {
										$input_extra['id'] = $element_arr['id'];
									}
									if (isset($element_arr['placeholder']) && $element_arr['placeholder']) {
										$input_extra['placeholder'] = $element_arr['placeholder'];
									}
									if ($element_arr['type'] == 'select') {
										if (isset($element_arr['options']) && $element_arr['options']) {
											$input_extra['options'] = $element_arr['options'];
											if (isset($element_arr['text_col']) && $element_arr['text_col']) {
												$input_extra['text_col'] = $element_arr['text_col'];
											}
											if (isset($element_arr['assoc']) && $element_arr['assoc']) {
												$input_extra['assoc'] = true;
											}
										}
									} 
									if ($element_arr['type'] == 'textarea') {
										if (isset($element_arr['rows']) && $element_arr['rows']) {
											$input_extra['rows'] = $element_arr['rows'];
										}
									}
									if (isset($element_arr['form_group_class']) && $element_arr['form_group_class']) {
										$fg_extra['class'] = $element_arr['form_group_class'];
									}
									if (isset($element_arr['hidden']) && $element_arr['hidden']) {
										$fg_extra['style'] = 'display: none;';
									}
									if (in_array($element_arr['type'], ['checkbox', 'radio'])) {
										xform_check($element_arr['title'], $element_arr['name'], $element_arr['type'], $element_arr['id'] ?? '',  $element_arr['value'] ?? 1, false);
									} elseif ($element_arr['type'] == 'datepicker') {
										xform_group_html_datepicker_list($element_arr['title'], $element_arr['name'], $element_arr['type'], $element_arr['value'] ?? '', $element_arr['required'], false, $input_extra, [], $fg_extra);
									} else {
										xform_group_list($element_arr['title'], $element_arr['name'], $element_arr['type'], $element_arr['value'] ?? '', $element_arr['required'], $input_extra, [], $fg_extra);
									}
									?>
								</div>
								<?php
							} 
						}

						$attrs = [
							'id' => 'hands_on_form',
							'class' => 'ajax_form join-form',
							'data-type' => 'none',
							'data-redirect' => '_void',
							'data-msg' => lang_string('hands_on_thank_you')
						];
						xform_open('api/web/hands_on', $attrs); ?>			

							<div class="tabs tabs-section type-2 horizontal clearfix">
								<ul class="tabs-nav clearfix">
									<li><a href="#tab_applicant">Applicant Details</a></li>
									<li><a href="#tab_grant">Grant Details</a></li>
									<li><a href="#tab_ngo">Organisation Details (Not-for-profit, if available)</a></li>
								</ul>
								<div class="tabs-content">

									<div id="tab_applicant">
										<?php echo xform_pre_notice(); ?>
										<div class="row">
											<?php _hands_on_form($form_elements_applicant); ?>
										</div>
									</div>

									<div id="tab_grant">
										<?php echo xform_pre_notice(); ?>
										<div class="row">
											<?php _hands_on_form($form_elements_grant); ?>
											<!-- <div class="col-sm-12">
												<div class="responsive-iframe">
													<iframe id="grant_project_video_preview" src="" allowfullscreen="true"></iframe>
												</div>
											</div> -->
										</div>
									</div>

									<div id="tab_ngo">
										<div class="row">
											<?php _hands_on_form($form_elements_ngo); ?>
										</div>
										<?php xform_notice('status_msg', '', false); ?>
										<button type="submit" class="btn btn-style-4" data-type="submit">Submit</button>
									</div>

								</div>
							</div>

							<?php
						xform_close(); ?>

					</div>

				</main>
			</div>
		</div>

	</div>
</div>