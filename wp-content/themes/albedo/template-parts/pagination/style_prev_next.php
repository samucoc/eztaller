<?php

/**
	* Pagination / Prev-next links style
**/

global $wp_query;
$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings' );
$max_num_pages = isset( $tpl_settings['max_num_pages'] ) ? absint( $tpl_settings['max_num_pages'] ) : $wp_query->max_num_pages;
// do not display pagination template if we have just one page
if( $max_num_pages <= 1 ) {
	return;
}

?>
<div class="pagination-container container">
	<div class="row">
		<div class="col-md-12">
			<div class="pagination style-prev-next">
				<div class="alignleft"><?php previous_posts_link( esc_html__( 'Prev', 'albedo' ), $max_num_pages ); ?></div>
				<div class="alignright"><?php next_posts_link( esc_html__( 'Next', 'albedo' ), $max_num_pages ); ?></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
