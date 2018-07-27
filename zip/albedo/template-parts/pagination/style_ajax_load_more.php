<?php

/**
	* Pagination / AJAX-Load more button style
**/
global $wp_query;
$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
$max_num_pages = isset( $tpl_settings['max_num_pages'] ) ? absint( $tpl_settings['max_num_pages'] ) : $wp_query->max_num_pages;
$next_page = absint( $tpl_settings['paged'] ) + 1;

$button_attributes = array();
$button_attributes[] = 'data-posts-container-id="posts-container-id-' . esc_attr( $tpl_settings['id'] ) . '"';
$button_attributes[] = 'data-next-page="' . esc_attr( $next_page ) . '"';
$button_attributes[] = 'data-max-pages="' . esc_attr( $max_num_pages ) . '"';
$button_attributes[] = 'data-atts="' . htmlspecialchars( json_encode( $tpl_settings ), ENT_QUOTES, 'UTF-8' ) . '"';

?>

<div class="pagination style-ajax">
	<a href="javascript:;" style="<?php echo $max_num_pages == 1 ? 'display: none' : ''; ?>" <?php echo implode( ' ', $button_attributes ); ?> class="ajax-pagination-button button style-<?php echo esc_attr( $tpl_settings['pagination']['yes']['pagination_style']['ajax_load_more']['button_style'] ); ?>"><?php echo wp_kses_post( $tpl_settings['pagination']['yes']['pagination_style']['ajax_load_more']['button_text'] ); ?></a>
</div>
