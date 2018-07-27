<?php
	if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
	if ( is_admin()){
		return;
	}
?>
<div class="fw-pricing style-2">
	<?php include 'pricing_table.php'; ?>
</div>
