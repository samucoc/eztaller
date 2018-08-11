<?php global $post; ?>

<div class="wedocs-feedback-wrap wedocs-hide-print">
	<?php
		$positive = (int) get_post_meta( $post->ID, 'positive', true );
		$negative = (int) get_post_meta( $post->ID, 'negative', true );

		$positive_title = $positive ? sprintf( _n( '%d person found this useful', '%d persons found this useful', $positive, 'albedo' ), number_format_i18n( $positive ) ) : esc_html__( 'No votes yet', 'albedo' );
		$negative_title = $negative ? sprintf( _n( '%d person found this not useful', '%d persons found this not useful', $negative, 'albedo' ), number_format_i18n( $negative ) ) : esc_html__( 'No votes yet', 'albedo' );
	?>

	<h6><?php esc_html_e( 'Was this article helpful to you?', 'albedo' ); ?></h6>

	<span class="vote-link-wrap">
		<a href="#" class="button size-small style-green wedocs-tip positive" data-id="<?php the_ID(); ?>" data-type="positive" title="<?php echo esc_attr( $positive_title ); ?>">
			<?php esc_html_e( 'Yes', 'albedo' ); ?>

			<?php if ( $positive ) { ?>
				<span class="count">(<?php echo number_format_i18n( $positive ); ?>)</span>
			<?php } ?>
		</a>
		<a href="#" class="button size-small style-blue wedocs-tip negative" data-id="<?php the_ID(); ?>" data-type="negative" title="<?php echo esc_attr( $negative_title ); ?>">
			<?php esc_html_e( 'No', 'albedo' ); ?>

			<?php if ( $negative ) { ?>
				<span class="count">(<?php echo number_format_i18n( $negative ); ?>)</span>
			<?php } ?>
		</a>
	</span>
</div>
