<?php

/**
	* Pagination / AJAX-Infinite style
**/
global $wp_query;
$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
$max_num_pages = isset( $tpl_settings['max_num_pages'] ) ? absint( $tpl_settings['max_num_pages'] ) : $wp_query->max_num_pages;

$next_page = absint( $tpl_settings['paged'] ) + 1;

$attributes = array();
$attributes[] = 'data-posts-container-id="posts-container-id-' . esc_attr( $tpl_settings['id'] ) . '"';
$attributes[] = 'data-next-page="' . esc_attr( $next_page ) . '"';
$attributes[] = 'data-max-pages="' . esc_attr( $max_num_pages ) . '"';
$attributes[] = 'data-atts="' . htmlspecialchars( json_encode( $tpl_settings ), ENT_QUOTES, 'UTF-8' ) . '"';
?>

<div <?php echo implode(' ', $attributes ); ?> class="pagination style-infinite" style="<?php echo $max_num_pages == 1 ? 'display: none' : ''; ?>">
	<div class="text"><?php esc_html_e( 'Loading...', 'albedo' ); ?></div>
</div>
