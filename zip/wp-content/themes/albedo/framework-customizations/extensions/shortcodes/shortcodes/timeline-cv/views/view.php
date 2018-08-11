<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';

	if( count( $atts['items'] ) > 0 ):

	$date_format = $atts['date_format'];
?>
<div <?php echo implode( ' ', $attributes ); ?> class="cv-timeline <?php echo implode( ' ', $classes ); ?>">
	<div class="items">
		<?php $i=0; foreach( $atts['items'] as $item ): $i++; ?>
		<div class="item">

			<div class="dot"></div>

			<div class="dates">

				<?php
					$start_date = date( $date_format, strtotime( $item['date_start'] ) );
					$end_date = date( $date_format, strtotime( $item['date_end'] ) );

					echo $start_date;

					if( $item['date_end'] <> '' ) {
						echo ' - ' . $end_date;
					}
				?>

			</div>

			<div class="text">
				<div class="position"><?php echo wp_kses_post( $item['position'] ) ; ?></div>
				<div class="website"><a target="_blank" href="http://<?php echo esc_attr( $item['url'] ) ; ?>"><?php echo wp_kses_post( $item['url'] ) ; ?></a></div>
			</div>

		</div>
		<?php endforeach; ?>
	</div>
	<span class="filling-line"></span>
</div>
<?php endif;
