<?php
/**
		 * Theme Option
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_panel(
	        'capacious_theme_options', 
	        	array(
	        		'priority'       => 7,
	            	'capability'     => 'edit_theme_options',
	            	'theme_supports' => '',
	            	'title'          => esc_html__( ' Theme Option', 'capacious' ),
	            ) 
	    );

/*----------------------------------------------------------------------------------------------*/
    /**
		 * Header Info Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_top_header_info_section', 
	        	array(
	        		'priority'       => 6,
	               	'title'          => esc_html__( 'Top Header Info', 'capacious' ),
	               	'panel'     => 'capacious_theme_options',
	            ) 
	    );


 $wp_customize->add_setting(
	        'capacious_top_header_section',
		        array(
		            'default' => $default['capacious_top_header_section'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
 $choices=capacious_top_header_section();
$wp_customize->add_control(
    'capacious_top_header_section',
        array(
            'type' => 'radio',
            'label' => esc_html__( 'Top Header Info Option', 'capacious' ),
            'description' 	=> esc_html__( 'Show/hide option for Top Header Info Section.', 'capacious' ),
            'section' => 'capacious_top_header_info_section',
            'choices'   => $choices,
            'priority' =>5
        )
);


        /**
	     * Field for Fonsome Icon
	     *
	     * @since 1.0.0
	     */
         $wp_customize->add_setting(
	        'capacious_phone_number_icon', 
	            array(
	                'default' => $default['capacious_phone_number_icon'],
	                'sanitize_callback' => 'sanitize_text_field',
	               	)
	      );

         $wp_customize->add_control(
	        'capacious_phone_number_icon',
	            array(
		            'type' => 'text',
		            'description' 	=> esc_html__( 'Insert Fontawesome Class Name', 'capacious' ),
		            'section' => 'capacious_top_header_info_section',
		            'priority' => 6
	            )
	    );

    /**
	     * Field for Top Header Phone Number
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_top_header_phone_no', 
	            array(
	                'default' => $default['capacious_top_header_phone_no'], 
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_top_header_phone_no',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Phone Number', 'capacious' ),
		            'section' => 'capacious_top_header_info_section',
		            'priority' => 8
	            )
	    );	

/**
	     * Field for Fonsome Icon
	     *
	     * @since 1.0.0
	     */
         $wp_customize->add_setting(
	        'capacious_email_icon', 
	            array(
	                'default' => $default['capacious_email_icon'],
	                'sanitize_callback' => 'sanitize_text_field',
	                
		       	)
	      );

         $wp_customize->add_control(
	        'capacious_email_icon',
	            array(
		            'type' => 'text',
		            'description' 	=> esc_html__( 'Insert Fontawesome Class Name', 'capacious' ),
		            'section' => 'capacious_top_header_info_section',
		            'priority' => 8
	            )
	    );

      /**
	     * Field for Top Header Email Address
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_top_header_email', 
	            array(
	                'default' =>  $default['capacious_top_header_email'],
	                'sanitize_callback' => 'sanitize_email',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_top_header_email',
	            array(
		            'type' => 'email',
		            'label' => esc_html__( 'Email Address', 'capacious' ),
		            'section' => 'capacious_top_header_info_section',
		            'priority' => 8
	            )
	    );	

	  /*-------------------------------------------------------------------------------------------*/
		/**
		 * Breadcrumb Options
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_breadcrump_option',
		        array(
		            'title'		=> esc_html__( 'Breadcrumb Options', 'capacious' ),
		            'panel'     => 'capacious_theme_options',
		            'priority'  => 6,
		        )
	    );  
    
      /**
		 * Breadcrumb Option
	  */
        $wp_customize->add_setting(
	        'capacious_breadcrump_option', 
	            array(
	                'default'           =>  $default['capacious_breadcrump_option'],
	                'sanitize_callback' => 'capacious_sanitize_select',
	               
		       	)
	    );
	   
	 $choices=capacious_breadcrump_option();   
     $wp_customize->add_control('capacious_breadcrump_option',
            array(
            'label'      => esc_html__('Breadcrumb Options','capacious'),
	        'section'   => 'capacious_breadcrump_option',
	         'choices'   => $choices,
            'type'	  	=> 'select',
            'priority'  => 10
         )
    ); 
    
/*-------------------------------------------------------------------------------------------*/
		/**
		 * Search Placeholder
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_search_option',
		        array(
		            'title'		=> esc_html__( 'Search', 'capacious' ),
		            'panel'     => 'capacious_theme_options',
		            'priority'  => 12,
		        )
	    );  
    
      /**
		 *Search Placeholder
	  */
        $wp_customize->add_setting(
	        'capacious_post_search_placeholder_option', 
	            array(
	                'default'           => $default['capacious_post_search_placeholder_option'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		          	)
	       );
	    
	   $wp_customize->add_control('capacious_post_search_placeholder_option',
            array(
            'label'      => esc_html__('Search Placeholder','capacious'),
           'section'   => 'capacious_search_option',
            'type'	  	=> 'text',
            'priority'  => 10
         )
    );   

/*-------------------------------------------------------------------------------------------*/
		/**
		 * Copyright Text
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_footer_text_option',
		        array(
		            'title'		=> esc_html__( 'Footer Option', 'capacious' ),
		           'panel'     => 'capacious_theme_options',
		            'priority'  => 12,
		        )
	    );  
    
      /**
		 *CopyRight Text
	  */
        $wp_customize->add_setting(
	        'capacious_copyright_text_option', 
	            array(
	                'default'           =>  $default['capacious_copyright_text_option'],
	                'sanitize_callback' => 'wp_kses_post',
	               
		       	)
	    );
	    
	   $wp_customize->add_control('capacious_copyright_text_option',
            array(
            'label'      => esc_html__('Copyright','capacious'),
           'section'   => 'capacious_footer_text_option',
            'type'	  	=> 'text',
            'priority'  => 10
         )
    );   

 
/*-------------------------------------------------------------------------------------------*/
		/**
		 * Reset Options
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_reset_option',
		        array(
		            'title'		=> esc_html__( 'Reset Options', 'capacious' ),
		           'panel'     => 'capacious_theme_options',
		            'priority'  => 12,
		        )
	    );  
    
      /**
		 *Reset Options
	  */
        $wp_customize->add_setting(
	        'capacious_reset_value_option', 
	            array(
	                'default'           =>'do-not-reset',
	                'sanitize_callback' => 'capacious_sanitize_select',
	                'transport' => 'postMessage'
	            	)
	    );
	    $reset_option = capacious_reset_option();
	   $wp_customize->add_control('capacious_reset_value_option',
            array(
            'label'      => esc_html__('Reset Options','capacious'),
            'description'    => sprintf( __( 'Caution: Reset theme Color and Fonts settings.Refresh the page after saving to view the effects', 'capacious' )),
            'section'   => 'capacious_reset_option',
            'type'	  	=> 'select',
            'choices'   => $reset_option,
            'priority'  => 10
         )
    );   
