<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';

	if( count( $atts['items'] ) > 0 ):
	if( is_rtl() ) {
		//$atts['items'] = array_reverse( $atts['items'] );
	}

	if( filter_var( $atts['is_sticky'], FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'sticky';
	}

?>
<div <?php echo implode( ' ', $attributes ); ?> class="vertical-timeline <?php echo implode( ' ', $classes ); ?>">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-4 col col-events" data-scroll-offset="<?php echo absint( $atts['scroll_offset_top'] ); ?>">

			<div class="events">
				<?php $i=0; foreach( $atts['items'] as $item ): $i++; ?>
				<?php $date = date( $atts['date_format'], strtotime( $item['date'] ) ); ?>
				<a href="javascript:;" class="event <?php if( $i == 1 ): ?>selected<?php endif; ?>">
					<span class="date"><span class="date-desktop"><?php echo $date ; ?></span><span class="date-mobile"><?php echo date( $atts['date_format_mobile'], strtotime( $item['date'] ) ); ?></span></span>
					<span class="title"><?php echo wp_kses_post( $item['title'] ) ; ?></span>
					<span class="dot"></span>
				</a>
				<?php endforeach; ?>

				<span class="filling-line"></span>
			</div>

		</div>
		<div class="col-md-1 col col-space"></div>
		<div class="col-md-7 col-sm-7 col-xs-7 col col-content">
			<div class="events-text">
				<?php $i=0; foreach( $atts['items'] as $item ): $i++; ?>
				<div class="item-content fadeIn <?php if( $i == 1 ): ?> selected<?php endif; ?>">
					<?php
						$title = wp_kses_post( $item['title'] );
						if( $title <> ''):
					?>
					<h2><?php echo $title; ?></h2>
					<?php endif; echo wp_kses_post( $item['content'] ); ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</div>
<?php endif;
