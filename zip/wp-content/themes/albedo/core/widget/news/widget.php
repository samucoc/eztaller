<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_news_widget_register' );

	function wplab_albedo_news_widget_register() {
		register_widget( 'wplab_albedo_news_widget' );
	}

	class wplab_albedo_news_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_news_widget', 'description' => esc_html__('A widget that displays latest blog posts', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_news_widget' );

			parent::__construct( 'wproto_news_widget', esc_html__( '[ALBEDO] Latest News', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-news-variable', wplab_albedo_utils::locate_uri( '/core/widget/news/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;

			switch( $instance['query_type'] ) {
				default:
				case('recent'):

					$posts = $wplab_albedo_core->model('post')->get( array(
						'posts_per_page' 	=> $instance['count'],
						'order' 					=> 'date',
						'sort' 						=> 'DESC',
						'post_type' 			=> 'post',
						'with_thumbnail_only' => true
					));

				break;
				case('most_commented'):

					$posts = $wplab_albedo_core->model('post')->get( array(
						'posts_per_page' 	=> $instance['count'],
						'order' 					=> 'comment_count',
						'sort' 						=> 'DESC',
						'post_type' 			=> 'post',
						'with_thumbnail_only' => true
					));

				break;
				case('random'):

					$posts = $wplab_albedo_core->model('post')->get( array(
						'posts_per_page' 	=> $instance['count'],
						'order' 					=> 'rand',
						'sort' 						=> 'DESC',
						'post_type' 			=> 'post',
						'with_thumbnail_only' => true
					));

				break;
			}

		?>

		<?php echo $args['before_widget']; ?>

		<!-- widget title -->
		<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

			<?php echo $args['before_title']; ?>

				<?php echo apply_filters( 'widget_title', $instance['title'] ); ?>

			<?php echo $args['after_title']; ?>

		<?php endif; ?>

		<!-- widget content -->
		<div class="style-<?php echo esc_attr( $instance['style'] ); ?>">
		<?php if( $posts->have_posts() ): ?>
		<ul>
			<?php while( $posts->have_posts() ): $posts->the_post(); ?>

			<?php $has_post_thumb = has_post_thumbnail(); ?>
			<li<?php if( ! $has_post_thumb ): ?>class="without-thumb"<?php endif; ?>>
				<?php if( $has_post_thumb && $instance['style'] != 'text' ): ?>
				<a href="<?php the_permalink(); ?>">
				<div class="thumb">

					<?php
						echo wplab_albedo_media::img( array(
							'width' => 80,
							'height' => 80,
							'url' => wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) ),
							'lazy' => true
						));
					?>

				</div>
				</a>

				<?php endif; ?>
				<div class="element-content">
					<a href="<?php the_permalink(); ?>" class="title">
						<?php if( $instance['style'] != 'text' ): ?>
						<div class="time"><?php the_time( get_option( 'date_format') ); ?></div>
						<?php endif; ?>
						<div class="title-text">
							<?php the_title(); ?>
						</div>
						<div class="author">
							<?php the_author(); ?>
						</div>
						<?php if( $instance['style'] == 'text' ): ?>
						<div class="time"><?php the_time( get_option( 'date_format') ); ?></div>
						<?php endif; ?>
					</a>
				</div>
			</li>
			<?php endwhile; wp_reset_postdata(); ?>
		</ul>

		<?php if( isset( $instance['display_all_news_link'] ) && $instance['display_all_news_link'] ): ?>
		<a class="button style-grey size-small" href="<?php echo esc_attr( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php echo strip_tags( $instance['read_all_title'] ); ?></a>
		<?php endif; ?>

		<?php endif; ?>

		</div>

		<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['title'] = strip_tags( str_replace( '\'', "&#39;", $new_instance['title'] ) );
			$instance['style'] = isset( $new_instance['style'] ) ? strip_tags( $new_instance['style'] ) : 'default';
			$instance['query_type'] = isset( $new_instance['query_type'] ) ? strip_tags( $new_instance['query_type'] ) : 'recent';
			$instance['read_all_title'] = isset( $new_instance['read_all_title'] ) ? strip_tags( $new_instance['read_all_title'] ) : '';
			$instance['count'] = isset( $new_instance['count'] ) ? absint( $new_instance['count'] ) : 1;
			$instance['display_all_news_link'] = isset( $new_instance['display_all_news_link'] ) ? absint( $new_instance['display_all_news_link'] ) : 0;

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {

			//Set up some default widget settings.
			$defaults = array(
				'title' => esc_html__( 'Recent News', 'albedo' ),
				'query_type' => 'recent',
				'style' => 'default',
				'count' => 3,
				'display_all_news_link' => 1,
				'read_all_title' => esc_html__( 'Read All News', 'albedo' ),
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Widget title:', 'albedo'); ?></label>
				<input type="text" style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e('Style:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" class="widefat">
					<option <?php echo $instance['style'] == 'default' ? 'selected="selected"' : ''; ?> value="default"><?php esc_html_e('Square thumbnails', 'albedo'); ?></option>
					<option <?php echo $instance['style'] == 'rounded' ? 'selected="selected"' : ''; ?> value="rounded"><?php esc_html_e('Rounded Thumbnails', 'albedo'); ?></option>
					<option <?php echo $instance['style'] == 'text' ? 'selected="selected"' : ''; ?> value="text"><?php esc_html_e('Without Thumbnails', 'albedo'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"><?php esc_html_e('Display type:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>" class="widefat">
					<option <?php echo $instance['query_type'] == 'recent' ? 'selected="selected"' : ''; ?> value="recent"><?php esc_html_e('Recent posts', 'albedo'); ?></option>
					<option <?php echo $instance['query_type'] == 'most_commented' ? 'selected="selected"' : ''; ?> value="most_commented"><?php esc_html_e('Most commented posts', 'albedo'); ?></option>
					<option <?php echo $instance['query_type'] == 'random' ? 'selected="selected"' : ''; ?> value="random"><?php esc_html_e('Random posts', 'albedo'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e('Posts count:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" class="widefat">
					<?php for( $i=1; $i<11; $i++ ): ?>
					<option <?php echo $instance['count'] == $i ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</p>
			<p>
				<input type="checkbox" <?php checked( $instance['display_all_news_link'], 1 ); ?> name="<?php echo esc_attr( $this->get_field_name( 'display_all_news_link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_all_news_link' ) ); ?>" value="1" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'display_all_news_link' ) ); ?>"><?php esc_html_e('Display Link to All News', 'albedo'); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'read_all_title' ) ); ?>"><?php esc_html_e('Read All title:', 'albedo'); ?></label>
				<input type="text" style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'read_all_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_all_title' ) ); ?>" value="<?php echo esc_attr( $instance['read_all_title'] ); ?>" />
			</p>
			<?php
		}

	}
