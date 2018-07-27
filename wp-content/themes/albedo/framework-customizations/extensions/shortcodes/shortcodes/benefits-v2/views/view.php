<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	global $wplab_albedo_core;

	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );
	$attributes[] = 'id="shortcode-' . $id . '"';

	$cols = absint( $atts['cols'] );
	$column = 12/$cols;

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';

	$terms = isset( $atts['query_type'][ $atts['query_type']['type'] ]['terms'] ) ? $atts['query_type'][ $atts['query_type']['type'] ]['terms'] : '';

	$items = $wplab_albedo_core->model('post')->get( array(
		'post_type' => 'benefits',
		'type' => $atts['query_type']['type'],
		'posts_per_page' => -1,
		'order' => $atts['order_by'],
		'sort' => $atts['sort_by'],
		'tax_name' => 'benefits_category',
		'terms' => $terms
	) );

	if( filter_var( $atts['scroll_nav'], FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'sticky-nav';
	}

	$classes[] = esc_attr( $atts['effect'] );

	if( $items->have_posts() ):

	$display_filters = filter_var( $atts['display_filters']['enabled'], FILTER_VALIDATE_BOOLEAN );

?>
<div <?php echo implode(' ', $attributes ); ?> class="shortcode-benefits-v2 <?php echo implode(' ', $classes ); ?> style-<?php echo esc_attr( $atts['style'] ); ?>">

	<div class="container-fluid">
		<div class="row">
			<?php if( $display_filters ): ?>
			<div class="col-md-4 col-nav">

				<nav data-top-offset="<?php echo esc_attr( $atts['scroll_nav_offset_top'] ); ?>" id="shortcode-benefits-v2-nav-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-benefits-v2-filters" data-target-id="shortcode-benefits-v2-posts-id-<?php echo esc_attr( $atts['id'] ); ?>">
					<?php
						$terms_q = array(
							'hide_empty' => true
						);

						if( $atts['query_type']['type'] == 'include' ) {
							$terms_q['include'] = $terms;
						} elseif( $atts['query_type']['type'] == 'exclude' ) {
							$terms_q['exclude'] = $terms;
						} elseif( $atts['query_type']['type'] == 'all_child' ) {
							$terms_q['parent'] = isset( $terms[0] ) ? $terms[0] : '';
						}

						$terms = get_terms( 'benefits_category', $terms_q );

						if( count( $terms ) > 0 ) {
							$filter_num = 0;
							if( filter_var( $atts['display_filters']['yes']['all_button'], FILTER_VALIDATE_BOOLEAN ) ) {
								$filter_num++;
								$filter_num_text = $atts['style'] == 'alt' ? '01' : '';
								echo '<a href="javascript:;" class="current" data-term="*"> ';

								if( ! is_rtl() ) {
									echo '<span class="num">' . $filter_num_text . '</span>';
								}

								echo '<span class="title">' . esc_html__('All', 'albedo') . '</span>';

								if( is_rtl() ) {
									echo '<span class="num">' . $filter_num_text . '</span>';
								}

								echo '</a>';
							}

							foreach( $terms as $term ) {
								$filter_num++;
								$filter_num_text = $atts['style'] == 'alt' ? sprintf( '%02d', $filter_num ) : '';
								echo '<a href="javascript:;" data-term=".' . $term->slug . '"> ';

								if( ! is_rtl() ) {
									echo '<span class="num">' . $filter_num_text . '</span>';
								}

								echo '<span class="title">' . $term->name . '</span>';

								if( is_rtl() ) {
									echo '<span class="num">' . $filter_num_text . '</span>';
								}

								echo '<span class="desc">' . $term->description . '</span>';

								echo '</a>';
							}
						}
					?>
				</nav>

			</div>
			<?php endif; ?>
			<div class="masonry-grid cols-<?php echo $cols; ?> <?php echo $display_filters ? 'col-md-8' : 'col-md-12'; ?>">

				<ul id="shortcode-benefits-v2-posts-id-<?php echo esc_attr( $atts['id'] ); ?>" class="grid">

					<?php while ( $items->have_posts() ): $items->the_post(); ?>

					<?php
						$link = fw_get_db_post_option( get_the_ID(), 'link' );
						$icon_style = '';
						if( filter_var( fw_get_db_post_option( get_the_ID(), 'custom_shadow/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
							$icon_style = 'box-shadow: ' . fw_get_db_post_option( get_the_ID(), 'custom_shadow/yes/shadow_h_length' ) . 'px ' . fw_get_db_post_option( get_the_ID(), 'custom_shadow/yes/shadow_v_length' ) . 'px ' . fw_get_db_post_option( get_the_ID(), 'custom_shadow/yes/shadow_blur_radius' ) . 'px 0px ' . fw_get_db_post_option( get_the_ID(), 'custom_shadow/yes/shadow_color' );
						}

						$terms = wp_get_post_terms( get_the_ID(), 'benefits_category' );
						$terms_array = array();
						if( count( $terms ) > 0 ) {
							foreach( $terms as $term ) {
								$terms_array[] = $term->slug;
							}
						}

					?>

					<li class="item grid-item <?php echo implode( ' ', $terms_array ); ?>">
						<div class="item-inside">
							<?php
								$icon = fw_get_db_post_option( get_the_ID(), 'icon' );
								if( $icon['type'] == 'icon-font' ):
								wp_enqueue_style( $icon['pack-name'], $icon['pack-css-uri'], false, _WPLAB_ALBEDO_CACHE_TIME_ );
							?>

							<div style="<?php echo esc_attr( $icon_style ); ?>" class="icon style-icon <?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
								<i class="<?php echo esc_attr( $icon['icon-class'] ); ?>"></i>
							</div>

							<?php elseif( $icon['type'] == 'custom-upload' ): ?>

							<?php
								$url = isset( $icon['url'] ) && $icon['url'] <> '' ? $icon['url'] : '';
								$info = new SplFileInfo( $url );
							?>

							<div style="<?php echo esc_attr( $icon_style ); ?>" class="icon <?php echo $info->getExtension() == 'svg' ? 'style-icon' : ''; ?> ">
								<div class="<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
									<img src="<?php echo esc_attr( $url ); ?>" alt="" class="image-svg" />
								</div>
							</div>

							<?php endif; ?>

							<div class="item-text">
								<h2><a href="<?php echo $link <> '' ? esc_attr( $link ) : get_permalink( get_the_ID() ); ?>"><?php the_title(); ?></a></h2>

								<?php the_excerpt(); ?>

							</div>
						</div>
					</li>
					<?php endwhile; ?>

				</ul>

			</div>
		</div>
	</div>

</div>
<?php wp_reset_postdata(); endif;
