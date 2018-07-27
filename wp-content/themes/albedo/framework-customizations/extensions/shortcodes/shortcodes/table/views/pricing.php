<?php
	if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
	if ( is_admin()){
		return;
	}
?>
<div class="fw-pricing style-1">
	<?php include 'pricing_table.php'; ?>
</div>
