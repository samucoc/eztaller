<?php
/**
* Single portfolio post: details section
**/
$post_id = get_the_ID();
/** a client name **/
$client_name = fw_get_db_post_option( $post_id, 'client_name' );
/** project URL **/
$project_url = fw_get_db_post_option( $post_id, 'project_url' );
/** display post categories ? **/
$display_post_categories = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_cats' ), FILTER_VALIDATE_BOOLEAN );
/** display post likes ? **/
$display_post_likes = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_likes' ), FILTER_VALIDATE_BOOLEAN );
/** display share links? **/
$display_share_links = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_share_links' ), FILTER_VALIDATE_BOOLEAN );
?>

<?php if( $display_post_likes || $display_share_links || $client_name <> '' || $project_url <> '' ): ?>
<!--
	Project additional data
-->
<div class="portfolio-details">

	<?php if( $display_post_categories ): ?>
	<dl>
		<dt><?php esc_html_e('In', 'albedo'); ?>:</dt>
		<dd><?php echo wplab_albedo_front::get_categories(); ?></dd>
	</dl>
	<?php endif; ?>

	<?php if( $client_name <> '' ): ?>
	<dl>
		<dt><?php esc_html_e('Client', 'albedo'); ?>:</dt>
		<dd><?php echo wp_kses_post( $client_name ); ?></dd>
	</dl>
	<?php endif; ?>

	<?php if( $project_url <> '' ): ?>
	<dl>
		<dt><?php esc_html_e('URL', 'albedo'); ?>:</dt>
		<dd><a href="<?php echo esc_attr( $project_url ); ?>" target="_blank"><?php echo wplab_albedo_utils::get_domain_name( $project_url ); ?></a></dd>
	</dl>
	<?php endif; ?>

	<?php if( $display_share_links ): ?>
	<dl>
		<dt><?php esc_html_e('Share', 'albedo'); ?>:</dt>
		<dd><?php echo wplab_albedo_front::share_links( true ); ?></dd>
	</dl>
	<?php endif; ?>

	<?php if( $display_post_likes ): ?>
	<dl id="post-likes">
		<dt><?php esc_html_e('Likes', 'albedo'); ?>:</dt>
		<dd>

			<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>

			<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?>" data-post-id="<?php the_ID(); ?>" id="like-post">
				<span>
				<?php
					$likes = absint( get_post_meta( $post_id, 'likes', true ) );
					printf( _nx( '1 Like', '%1$s Likes', $likes, 'post likes', 'albedo' ), number_format_i18n( $likes ) );
				?>
				</span>
			</a>

		</dd>
	</dl>
	<?php endif; ?>

</div>
<?php endif;
