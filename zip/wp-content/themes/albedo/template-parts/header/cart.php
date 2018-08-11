<?php
/**
* Header cart widget template
**/
if( wplab_albedo_utils::is_woocommerce() ):
	$count = WC()->cart->get_cart_contents_count();
?>
<div class="menu-layout-item item-cart">

<a href="javascript:;" class="header-cart-toggle toggler">
	<span class="count"><?php echo $count; ?></span>
</a>

<div class="widget-holder">
	<?php the_widget( 'WC_Widget_Cart' ); ?>
</div>

</div>
<?php endif;
