<?php

/**
* Portfolio post gallery part
**/

$atttibutes = array();
$atttibutes[] = 'data-row-height="360"';
$atttibutes[] = 'data-max-row-height="520"';
$atttibutes[] = 'data-margins="40"';
$atttibutes[] = 'data-captions="yes"';
$attributes[] = 'data-randomize="no"';
$atttibutes[] = 'id="single-portfolio-gallery"';

/** display post gallery in content? **/
$display_post_gallery = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_gallery' ), FILTER_VALIDATE_BOOLEAN );

if( $display_post_gallery && function_exists( 'fw_ext_portfolio_get_gallery_images') ):
	$portfolio_images = fw_ext_portfolio_get_gallery_images();

	if( !empty( $portfolio_images ) ):
		?>
		<div class="portfolio-single-gallery images-gallery justified-gallery overlay-color-dark with-shadows" <?php echo implode( ' ', $atttibutes ); ?>>
			<?php foreach ( $portfolio_images as $thumbnail ): ?>
			<figure data-src="<?php echo esc_attr( $thumbnail['url'] ); ?>">
				<a href="<?php echo esc_attr( $thumbnail['url'] ); ?>">
					<img src="<?php echo esc_attr( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( get_the_title( $thumbnail['attachment_id'] ) ); ?>" />
				</a>
				<figcaption class="caption"><?php echo get_the_title( $thumbnail['attachment_id'] ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
		<?php
	endif;

endif;
