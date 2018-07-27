<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
	$attributes[] = 'data-min-distance="' . absint( $atts['min_distance'] ) . '"';

	if( count( $atts['items'] ) > 0 ):
?>
<div <?php echo implode( ' ', $attributes ); ?> class="horizontal-timeline <?php echo implode( ' ', $classes ); ?>">

	<div class="timeline">
		<div class="events-wrapper">
			<div class="events">
				<ol>
					<?php $i=0; foreach( $atts['items'] as $item ): $i++; ?>
					<?php $date = date( 'd/m/Y', strtotime( $item['date'] ) ); ?>
					<li><a href="javascript:;" data-date="<?php echo $date; ?>" <?php if( $i == 1 ): ?>class="selected"<?php endif; ?>><?php echo $date ; ?></a></li>
					<?php endforeach; ?>
				</ol>

				<span class="filling-line" aria-hidden="true"></span>
			</div>
		</div>

		<div class="timeline-navigation">
			<a href="javascript:;" class="prev inactive"></a>
			<a href="javascript:;" class="next"></a>
		</div>
	</div>

	<div class="events-content">
		<ol>
			<?php $i=0; foreach( $atts['items'] as $item ): $i++; ?>
			<?php $date = date( 'd/m/Y', strtotime( $item['date'] ) ); ?>
			<li <?php if( $i == 1 ): ?>class="selected"<?php endif; ?> data-date="<?php echo $date; ?>">
				<div class="item-content"><?php echo wp_kses_post( $item['content'] ); ?></div>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>

</div>
<?php endif;
