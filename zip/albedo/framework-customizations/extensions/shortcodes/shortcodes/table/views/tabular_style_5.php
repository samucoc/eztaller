<?php
	if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
	if ( is_admin()){
		return;
	}
?>
<div class="fw-table style-5">
	<?php include 'table.php'; ?>
</div>
