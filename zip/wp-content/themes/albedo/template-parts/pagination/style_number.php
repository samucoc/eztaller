<?php
/**
	* Pagination / Numeric style
**/
global $wp_query;
$tpl_settings = get_query_var('wplab_albedo_tpl_settings');

$max_num_pages = isset( $tpl_settings['max_num_pages'] ) ? absint( $tpl_settings['max_num_pages'] ) : $wp_query->max_num_pages;

// do not display pagination template if we have just one page
if( $max_num_pages <= 1 ) {
	return;
}

$paged = get_query_var('paged');
$permalinks_enabled = get_option( 'permalink_structure') != '';
$format = $permalinks_enabled ? 'page/%#%/' : '&paged=%#%';
$big = 9999999;
$base = $permalinks_enabled && !is_search() ? $base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) : $base = @add_query_arg('paged','%#%');

?>
<div class="pagination-container container">
	<div class="row">
		<div class="col-md-12">
			<div class="pagination style-numeric">
			<?php
				echo paginate_links( array(
					'format' => $format,
					'base' => $base,
					'current' => max( 1, $paged ),
					'total' => $max_num_pages,
					'prev_text' => esc_html__( 'Prev page', 'albedo'),
					'next_text' => esc_html__( 'Next page', 'albedo'),
					'mid_size' => 1
				));
			?>
			</div>
		</div>
	</div>
</div>
