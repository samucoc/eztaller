<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_post_author_widget_register' );

	function wplab_albedo_post_author_widget_register() {
		register_widget( 'wplab_albedo_post_author_widget' );
	}

	class wplab_albedo_post_author_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_post_author_widget', 'description' => esc_html__('A widget that displays information about post author', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_post_author_widget' );

			parent::__construct( 'wproto_post_author_widget', esc_html__( '[ALBEDO]: Post Author', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-post-author-variable', wplab_albedo_utils::locate_uri( '/core/widget/post-author/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {

			if( is_singular() ):
				global $wplab_albedo_core;
				$post_author_id = get_post_field( 'post_author', get_the_ID() );
				echo $args['before_widget']; ?>

				<!-- widget content -->
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( $post_author_id, 50 ); ?>
					</div>
					<div class="author-name">
						<span><?php esc_html_e( 'Posted by', 'albedo'); ?>:</span>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
					</div>
				</div>

				<div class="author-description">
					<?php the_author_meta( 'description'); ?>
				</div>

				<div class="author-social-icons">
					<?php foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ): ?>

						<?php
							$url = get_the_author_meta( $k, $post_author_id );
							if( $url <> '' ):
						?>
						<a href="<?php echo esc_attr( $url ); ?>"><i class="<?php echo esc_attr( $wplab_albedo_core->cfg['social_icons'][ $k ] ); ?>"></i></a>
						<?php endif; ?>

					<?php endforeach; ?>
				</div>

			<?php
				echo $args['after_widget'];
			endif;

		}


	}
