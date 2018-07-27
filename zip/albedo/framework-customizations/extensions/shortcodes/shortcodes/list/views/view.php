<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
$style = array( $atts['style'] );

$style[] = 'style-' . $atts['type'];

if( isset( $atts['margins'] ) ) {
	$style[] = 'margins-' . $atts['margins'];
}

/**
 * @var array $atts
 */
?>
<?php

	//$atts['text']
	preg_match_all( "/^\*(.*)$/m", $atts['text'], $matches );

	if( strpos( $atts['type'], 'ul') !== false ):
	?>
	<ul class="<?php echo implode( ' ', $style ); ?>">
		<?php foreach( $matches[0] as $k=>$element ): ?>
		<li><?php echo trim( str_replace('*', '', $element ) ); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php
	else:
	?>
	<ol class="<?php echo implode( ' ', $style ); ?>">
		<?php foreach( $matches[0] as $k=>$element ): ?>
		<li><?php echo trim( str_replace('*', '', $element ) ); ?></li>
		<?php endforeach; ?>
	</ol>
	<?php
	endif;
