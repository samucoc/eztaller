<?php
	if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
	if ( is_admin()){
		return;
	}
?>
<div class="fw-table style-2">
	<?php include 'table.php'; ?>
</div>
