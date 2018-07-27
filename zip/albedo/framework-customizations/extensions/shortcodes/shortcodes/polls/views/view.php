<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */

$attributes = $classes = array();
/** unique id **/

$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';

$poll_id = absint( $atts['poll_id'] );
$poll_elements = fw_get_db_post_option( $poll_id, 'elements' );
$attributes[] = 'data-poll-id="' . esc_attr( $poll_id ) . '"';

$cols = absint( $atts['cols'] );
$column = 12/$cols;

if( is_array( $poll_elements ) && !empty( $poll_elements ) ):
?>

<div <?php echo implode( ' ', $attributes ); ?> class="shortcode-simple-polls <?php echo implode( ' ', $classes ); ?>">
	<?php $counter = 0; foreach ( $poll_elements as $key => $title ): ?>

		<?php if( $counter % $cols == 0 ): ?>
		<div class="row">
		<?php endif; $counter++; ?>

		<?php
			// check cookies for votes
			$voted = isset( $_COOKIE[ md5( 'wplab_albedo_poll_id_' . $poll_id . '_' . trim( $title ) ) ] ) ? filter_var( $_COOKIE[ md5( 'wplab_albedo_poll_id_' . $poll_id . '_' . trim( $title ) )], FILTER_VALIDATE_BOOLEAN ) : false;
		?>

		<div class="item vote-item col-md-<?php echo $column; ?>">
			<label><input type="checkbox" <?php if( $voted ): ?>checked="checked"<?php endif; ?> name="input-<?php echo $column; ?>" value="1" /> <?php echo wp_kses_post( $title ); ?></label>
		</div>

	<?php if( $counter % $cols == 0 ): ?>
	</div>
	<?php endif; ?>

	<?php endforeach; ?>

	<?php if( $counter%$cols != 0 ): ?>
	</div>
	<?php endif; ?>

</div>

<?php
endif;
