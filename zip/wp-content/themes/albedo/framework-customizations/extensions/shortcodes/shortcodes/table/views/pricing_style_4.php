<?php
	if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
	if ( is_admin()){
		return;
	}
?>
<div class="fw-pricing style-4">
	<?php include 'pricing_table.php'; ?>
</div>
