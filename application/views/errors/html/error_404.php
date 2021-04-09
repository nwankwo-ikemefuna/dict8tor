<?php flash_message('error_msg', 'danger'); ?>
<div class="text-center">
	<h2 class="text-bold">404 - Page Not Found!</h2>
	<p class="p-b-10">Sorry, this page doesn't exist.</p>
	<div>
		<?php 
		//coming from portal?
		if ($is_ajax) {
	        ajax_page_button('user', 'Save Me!', 'btn-info btn-rounded btn-lg');
	    } else { ?>
	    	<a href="<?php echo base_url(); ?>" class="btn btn-info btn-rounded btn-lg">Take Me Home</a>
	    <?php } ?>
	</div>
</div>