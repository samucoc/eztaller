<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}

global $wplab_albedo_core;

$id = esc_attr( $atts['id'] );
$atts['tax_query_type'] = isset( $atts['taxonomy_query']['tax_query_type'] ) ? $atts['taxonomy_query']['tax_query_type'] : '';
$atts['tax_query_terms'] = '';

if( $atts['tax_query_type'] == 'only' ) {
	$cats_str = $atts['taxonomy_query']['only']['cats_include'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
} elseif( $atts['tax_query_type'] == 'except' ) {
	$cats_str = $atts['taxonomy_query']['except']['cats_exclude'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
}

$display_pagination = filter_var( $atts['display_pagination'], FILTER_VALIDATE_BOOLEAN );

/**
 * Get posts
 **/
$query_args = array(
	'type' => $atts['tax_query_type'] <> '' ? $atts['tax_query_type'] : 'all',
	'posts_per_page' => isset( $atts['posts_per_page'] ) && $atts['posts_per_page'] <> '' ? absint( $atts['posts_per_page'] ) : 9,
	'terms' => $atts['tax_query_terms'],
	'term_field' => 'slug',
	'post_type' => 'fw-portfolio',
	'tax_name' => 'fw-portfolio-category',
	'paged' => 1,
	'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
	'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
);

$posts = $wplab_albedo_core->model('post')->get( $query_args );
$posts_count = $posts->post_count;

if( $posts->have_posts() ):
?>

<div id="shortcode-<?php echo esc_attr( $id ); ?>" data-slide-time="<?php echo esc_attr( $atts['slide_time'] ); ?>" data-autoplay-time="<?php echo esc_attr( $atts['autoplay_time'] ); ?>" class="photo-fullscreen-gallery">
	<div id="photos-container-id-<?php echo esc_attr( $atts['id'] ); ?>" class="photos mask-<?php echo esc_attr( $atts['effect'] ); ?>">

		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php $photo_url = get_the_post_thumbnail_url();?>
			<div class="photo" style="background-image: url(<?php echo esc_attr( $photo_url ); ?>);">
				<div class="overlay"></div>
				<div class="slide-content">

					<?php if( filter_var( $atts['display_title']['enabled'], FILTER_VALIDATE_BOOLEAN ) && 'vertical' == $atts['display_title']['yes']['title_position'] ): ?>
						<h2 class="h1 title-pos-vertical"><span><?php the_title(); ?></span></h2>
					<?php endif; ?>

					<footer class="<?php if( !$display_pagination ): ?>no-pagination<?php endif; ?>">

						<?php if( filter_var( $atts['display_title']['enabled'], FILTER_VALIDATE_BOOLEAN ) && 'vertical' != $atts['display_title']['yes']['title_position'] ): ?>
							<h2 class="h1"><?php the_title(); ?></h2>
						<?php endif; ?>

						<?php $desc = get_the_excerpt(); if( filter_var( $atts['display_desc'], FILTER_VALIDATE_BOOLEAN ) && $desc <> '' ): ?>
							<div class="photo-description"><?php echo wp_kses_post( $desc ); ?></div>
						<?php endif; ?>

						<?php if( filter_var( $atts['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<div class="photo-author"><?php esc_html_e( 'Photo by', 'albedo'); ?> <span><?php the_author(); ?></span></div>
						<?php endif; ?>

					</footer>

				</div>
			</div>

		<?php endwhile; wp_reset_postdata(); ?>

	</div>
	<?php if( $display_pagination ): ?>
	<div class="pages">
		<div class="pages-container">
			<?php for( $i=1; $i<=$posts_count; $i++ ): ?>
			<a href="javascript:;" class="pagination-link"><?php echo str_pad( $i, 2, '0', STR_PAD_LEFT); ?></a>
			<?php endfor; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if( filter_var( $atts['display_arrows']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<nav class="arrows style-<?php echo esc_attr( $atts['display_arrows']['yes']['arrows_style'] ); ?>">
		<div class="arrows-container">
			<div class="arrow previous"><span><?php esc_html_e( 'Prev Photo', 'albedo'); ?></span></div>
			<div class="arrow next"><span><?php esc_html_e( 'Next Photo', 'albedo'); ?></span></div>
		</div>
	</nav>
	<?php endif; ?>

</div>
<?php endif;
