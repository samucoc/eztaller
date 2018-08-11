<?php
	if (!defined('FW')) die('Forbidden');
	if ( is_admin()){
		return;
	}
?>

<div class="row">
	<?php echo do_shortcode($content); ?>
</div>
