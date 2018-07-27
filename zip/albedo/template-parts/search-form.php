<?php
	/**
	 * Search form template part
	 **/
	$ajax_search = wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_settings_option( 'ajax_search/enabled' ), FILTER_VALIDATE_BOOLEAN );
?>
<form class="search-form <?php if( $ajax_search ): ?>ajax-search-form<?php endif; ?>" action="<?php echo get_site_url(); ?>" method="get">
	<input class="s" data-min-chars="<?php echo $ajax_search ? absint( fw_get_db_settings_option( 'ajax_search/yes/ajax_search_min_letter' ) ) : ''; ?>" type="search" name="s" value="" placeholder="<?php echo $ajax_search ? esc_html__( 'Start typing to search...', 'albedo' ) : esc_html__( 'Type and hit enter...', 'albedo' ); ?>" />
</form>
