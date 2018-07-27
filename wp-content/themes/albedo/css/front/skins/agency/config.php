<?php

	$this->default_options = array(
		'onepage_scroll_offset' => 100,
		/**
			Custom CSS
		**/
		'custom_css_code' => 'body {
// background-color: #777;
}',
		/**
			Lightbox
		**/
		'lightbox_effect' => 'lg-fade',
		'lightbox_easing' => '0.770, 0.000, 0.175, 1.000',
		'lightbox_thumbnails' => 'yes',
		'lightbox_captions' => 'yes',
		'lightbox_fullscreen' => 'yes',
		'lightbox_zoom' => 'yes',
		'lightbox_download' => 'no',
		'lightbox_autoplay' => 'no',
		'lightbox_autoplay_speed' => 5000,
		/**
			General options
		**/
		'lazy_loading' => 'yes',
		'css_animations_mobile' => 'no',
		'smooth_scrolling' => 'no',
		'custom_scrollbar' => 'no',
		'custom_inputs' => 'yes',
		/**
			Preloader
		**/
		'preloader_style' => 'hidden',
		'preloader_image' => '',
		'preloader_image_2x' => '',
		'custom_preloader_image_width' => 50,
		'custom_preloader_image_height' => 50,
		/**
			Woocommerce
		**/
		'shop_title' => esc_html__( 'Shop', 'albedo' ),
		'woo_posts_count' => 9,
		'woo_products_per_row' => 3,
		'woo_related_products_number' => 3,
		'woo_related_products_cols' => 3,
		'woo_products_style' => 'style_1',
		'woo_single_post_style' => 'style_1',
		'woo_pagination_style' => 'style_1',
		'woo_ordering_boxes' => 'yes',
		/**
			Layout
		**/
		'layout_type' => 'default',
		/**
			Sidebar
		**/
		'sidebar_size' => 4,
		'sidebar_gap' => 'no',
		'hide_sidebar_on_mobiles' => 'no',
		'scroll_last_widget' => 'yes',
		'scroll_last_widget_offset' => '170',
		'widgets_style' => 'boxed',
		/**
			Blog
		**/
		'blog_single_post_style' => 'boxed',
		'blog_single_comment_form_style' => 'white_alt',
		'blog_single_comment_form_inputs_style' => 'rounded',
		'blog_single_display_featured_image' => 'yes',
		'blog_single_display_post_title' => 'yes',
		'blog_single_display_post_excerpt' => 'no',
		'blog_single_display_post_date' => 'yes',
		'blog_single_display_post_author' => 'yes',
		'blog_single_display_post_categories' => 'yes',
		'blog_single_display_post_comments_num' => 'yes',
		'blog_single_display_post_likes' => 'yes',
		'blog_single_display_post_tags' => 'yes',
		'blog_single_display_share_links' => 'yes',
		'blog_single_display_about_author' => 'yes',
		'blog_single_display_prev_next_posts' => 'yes',
		'blog_single_prev_next_posts_style' => 'links_boxed',
		/**
			Portfolio
		**/
		'portfolio_single_display_post_title' => 'yes',
		'portfolio_single_display_post_excerpt' => 'yes',
		'portfolio_single_display_post_thumb' => 'yes',
		'portfolio_single_display_post_gallery' => 'yes',
		'portfolio_single_display_post_cats' => 'yes',
		'portfolio_single_display_post_likes' => 'yes',
		'portfolio_single_display_share_links' => 'yes',
		'portfolio_single_display_prev_next_posts' => 'yes',
		'portfolio_single_prev_next_posts_style' => 'links_boxed',
		'portfolio_single_display_similar_posts' => 'yes',
		'portfolio_single_similar_posts_title' => esc_html__( 'You may also like:', 'albedo' ),
		'portfolio_single_similar_posts_desc' => '',
		'portfolio_single_similar_posts_style' => '3cold_grid',
		/**
			Page 404
		**/
		'page_404_style' => 'modern',
		'page_404_title_1' => esc_html__( '404', 'albedo' ),
		'page_404_title_2' => esc_html__( 'The Link You Folowed Probably Broken,
or the page has been removed...', 'albedo' ),
		'page_404_title_3' => '',
		'page_404_display_search' => 'yes',
		'page_404_display_home_btn' => 'yes',
		'page_404_home_btn_text' => esc_html__( 'Return to Home', 'albedo' ),
		'page_404_bg_img_position' => 'center center',
		'page_404_bg_img_repeat' => 'no-repeat',
		'page_404_bg_img_attachment' => 'scroll',
		'page_404_bg_img_cover' => 'cover',
		'page_404_bg_img_parallax' => 'no',
		'page_404_slider_header_mode' => 'no',
		'page_404_slider_footer_mode' => 'no',
		/**
		 * Top Bar
		 **/
		'top_bar_enabled' => 'no',
		'top_bar_responsive_at' => 995,
		'top_bar_sticky' => 'no',
		'top_bar_sticky_mobile' => 'no',
		'top_bar_hide_mobile' => 'no',
		/**
		 * Menu
		 **/
		'menu_style' => 'classic',
		'submenu_minimal_style' => 'style_1',
		'submenu_minimal_free_text' => '',
		'menu_search' => 'no',
		'menu_cart' => 'no',
		'menu_side_overlay' => 'no',
		'menu_responsive_at' => 1199,
		'menu_cta' => 'no',
		'menu_cta_button_text' => esc_html__('Contact Us', 'albedo'),
		'menu_cta_button_url' => 'https://themeforest.net/user/wplab/portfolio/?ref=wplab',
		'menu_cta_button_style' => 'green',
		'menu_items_right_margin' => '',
		'menu_items_left_margin' => '',
		'menu_scrolling' => 'yes',
		'menu_scrolling_style' => 'simple',
		'do_not_scroll_on_mobiles' => 'yes',
		'do_not_scroll_on_singles' => 'no',
		'menu_container_bg_enabled' => 'yes',
		'menu_scroll_container_bg_enabled' => 'yes',
		'menu_container_display_shadow' => 'yes',
		'menu_container_display_shadow_transp_header' => 'yes',
		/**
		 * Logo, favicon
		 **/
		'header_logo_type' => 'title',
		'header_logo_width' => '',
		'header_logo_height' => '',
		'header_logo_transp_width' => '',
		'header_logo_transp_height' => '',
		/**
		 * Sub-header & Breadcrumbs
		 **/
		'header_layout' => 'style_6',
		'display_header_page_title' => 'yes',
		'display_header_page_desc' => 'yes',
		'display_header_second_menu' => 'no',
		'display_header_breadcrumbs' => 'yes',
		'header_cta' => 'no',
		'header_cta_button_text' => esc_html__('Purchase', 'albedo'),
		'header_cta_button_url' => 'https://themeforest.net/user/wplab/portfolio/?ref=wplab',
		'header_cta_button_style' => 'green',
		/**
		 * Header effects
		 **/
		'header_parallax_effect' => '',
		'header_parallax_effect_parallax_speed' => '0.2',
		'header_mouse_parallax_invert_x' => 'yes',
		'header_mouse_parallax_invert_y' => 'yes',
		'header_mouse_parallax_depth' => '0.6',
		'header_mouse_parallax_limit_x' => '0',
		'header_mouse_parallax_limit_y' => '0',
		'header_mouse_parallax_scalar_x' => '0',
		'header_mouse_parallax_scalar_y' => '0',
		'header_mouse_parallax_friction_x' => '0',
		'header_mouse_parallax_friction_y' => '0',
		'header_mouse_parallax_origin_x' => '0',
		'header_mouse_parallax_origin_y' => '0',
		'header_media_effect' => '',
		'header_particleground_dot_color' => '#fafafa',
		'header_particleground_line_color' => '#fcfcfc',
		'header_particleground_particle_radius' => '7',
		'header_particleground_line_width' => '1',
		'header_particleground_curved_lines' => 'no',
		'header_particleground_parallax' => 'yes',
		'header_particleground_parallax_multiplier' => '5',
		'header_particleground_proximity' => '100',
		'header_particleground_min_speed_x' => '0.1',
		'header_particleground_max_speed_x' => '0.7',
		'header_particleground_min_speed_y' => '0.1',
		'header_particleground_max_speed_y' => '0.7',
		'header_particleground_direction_x' => 'center',
		'header_particleground_direction_y' => 'center',
		'header_particleground_destiny' => '1000',
		'header_particles_number' => '160',
		'header_particles_density' => 'yes',
		'header_particles_density_value' => '800',
		'header_particles_color' => '#ffffff',
		'header_particles_shape_type' => 'circle',
		'header_particles_stroke_width' => '0',
		'header_particles_stroke_color' => '#ffffff',
		'header_particles_polygon_sides' => '5',
		'header_particles_opacity' => '0.5',
		'header_particles_opacity_rand' => 'yes',
		'header_particles_animate_opacity' => 'yes',
		'header_particles_animate_opacity_speed' => '10',
		'header_particles_animate_opacity_size_min' => '5',
		'header_particles_animate_opacity_sync' => 'no',
		'header_particles_size' => '2',
		'header_particles_size_rand' => 'yes',
		'header_particles_animate_size' => 'no',
		'header_particles_animate_size_speed' => '32',
		'header_particles_animate_size_min' => '5',
		'header_particles_animate_sync' => 'yes',
		'header_particles_lines' => 'no',
		'header_particles_lines_distance' => '150',
		'header_particles_lines_color' => '#ffffff',
		'header_particles_lines_opacity' => '0.5',
		'header_particles_lines_width' => '1.4',
		'header_particles_move' => 'yes',
		'header_particles_move_direction' => 'none',
		'header_particles_move_rand' => 'yes',
		'header_particles_move_straight' => 'no',
		'header_particles_move_speed' => '2',
		'header_particles_move_out_mode' => 'none',
		'header_particles_onhover' => 'no',
		'header_particles_onhover_mode' => 'grab',
		'header_particles_onclick' => 'no',
		'header_particles_onclick_mode' => 'grab',
		'header_particles_grab_distance' => '400',
		'header_particles_grab_opacity' => '0.5',
		'header_particles_bubble_distance' => '400',
		'header_particles_bubble_size' => '4',
		'header_particles_bubble_duration' => '0.3',
		'header_particles_bubble_opacity' => '1',
		'header_particles_bubble_speed' => '3',
		'header_particles_repulse_distance' => '200',
		'header_particles_repulse_duration' => '0.4',
		'header_videobg_url' => '',
		'header_videobg_video_mute' => 'yes',
		'header_videobg_parallax_speed' => '',
		/**
		 * Footer
		 **/
		'footer_widgets' => 'yes',
		'footer_widgets_area' => 'sidebar-footer',
		'footer_widgets_cols' => '3',
		'footer_bar' => 'yes',
		'footer_bar_style' => 'classic',
		'footer_bar_text' => esc_html__( '&copy;2017 Albedo &mdash; Advanced Creative Multi-Purpose Theme', 'albedo' ),
		'gotop_link' => 'yes',
		'gotop_link_text' => esc_html__('Back to top', 'albedo'),
		'footer_forms_style' => 'dark',
		/**
		 * Footer effects
		 **/
		'footer_parallax_effect' => '',
		'footer_parallax_effect_parallax_speed' => '0.2',
		'footer_mouse_parallax_invert_x' => 'yes',
		'footer_mouse_parallax_invert_y' => 'yes',
		'footer_mouse_parallax_depth' => '0.6',
		'footer_mouse_parallax_limit_x' => '0',
		'footer_mouse_parallax_limit_y' => '0',
		'footer_mouse_parallax_scalar_x' => '0',
		'footer_mouse_parallax_scalar_y' => '0',
		'footer_mouse_parallax_friction_x' => '0',
		'footer_mouse_parallax_friction_y' => '0',
		'footer_mouse_parallax_origin_x' => '0',
		'footer_mouse_parallax_origin_y' => '0',
		'footer_media_effect' => '',
		'footer_particleground_dot_color' => '#fafafa',
		'footer_particleground_line_color' => '#fcfcfc',
		'footer_particleground_particle_radius' => '7',
		'footer_particleground_line_width' => '1',
		'footer_particleground_curved_lines' => 'no',
		'footer_particleground_parallax' => 'yes',
		'footer_particleground_parallax_multiplier' => '5',
		'footer_particleground_proximity' => '100',
		'footer_particleground_min_speed_x' => '0.1',
		'footer_particleground_max_speed_x' => '0.7',
		'footer_particleground_min_speed_y' => '0.1',
		'footer_particleground_max_speed_y' => '0.7',
		'footer_particleground_direction_x' => 'center',
		'footer_particleground_direction_y' => 'center',
		'footer_particleground_destiny' => '1000',
		'footer_particles_number' => '160',
		'footer_particles_density' => 'yes',
		'footer_particles_density_value' => '800',
		'footer_particles_color' => '#ffffff',
		'footer_particles_shape_type' => 'circle',
		'footer_particles_stroke_width' => '0',
		'footer_particles_stroke_color' => '#ffffff',
		'footer_particles_polygon_sides' => '5',
		'footer_particles_opacity' => '0.5',
		'footer_particles_opacity_rand' => 'yes',
		'footer_particles_animate_opacity' => 'yes',
		'footer_particles_animate_opacity_speed' => '10',
		'footer_particles_animate_opacity_size_min' => '5',
		'footer_particles_animate_opacity_sync' => 'no',
		'footer_particles_size' => '2',
		'footer_particles_size_rand' => 'yes',
		'footer_particles_animate_size' => 'no',
		'footer_particles_animate_size_speed' => '32',
		'footer_particles_animate_size_min' => '5',
		'footer_particles_animate_sync' => 'yes',
		'footer_particles_lines' => 'no',
		'footer_particles_lines_distance' => '150',
		'footer_particles_lines_color' => '#ffffff',
		'footer_particles_lines_opacity' => '0.5',
		'footer_particles_lines_width' => '1.4',
		'footer_particles_move' => 'yes',
		'footer_particles_move_direction' => 'none',
		'footer_particles_move_rand' => 'yes',
		'footer_particles_move_straight' => 'no',
		'footer_particles_move_speed' => '2',
		'footer_particles_move_out_mode' => 'none',
		'footer_particles_onhover' => 'no',
		'footer_particles_onhover_mode' => 'grab',
		'footer_particles_onclick' => 'no',
		'footer_particles_onclick_mode' => 'grab',
		'footer_particles_grab_distance' => '400',
		'footer_particles_grab_opacity' => '0.5',
		'footer_particles_bubble_distance' => '400',
		'footer_particles_bubble_size' => '4',
		'footer_particles_bubble_duration' => '0.3',
		'footer_particles_bubble_opacity' => '1',
		'footer_particles_bubble_speed' => '3',
		'footer_particles_repulse_distance' => '200',
		'footer_particles_repulse_duration' => '0.4',
		'footer_videobg_url' => '',
		'footer_videobg_pause_on_scroll' => 'yes',
		'footer_videobg_video_mute' => 'yes',
		'footer_videobg_parallax_speed' => '',
	);
