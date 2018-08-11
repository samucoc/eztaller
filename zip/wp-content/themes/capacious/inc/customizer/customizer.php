<?php 

/**
		 * Color Option
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_panel(
	        'capacious_color_info', 
	        	array(
	        		'priority'       => 7,
	            	'capability'     => 'edit_theme_options',
	            	'theme_supports' => '',
	            	'title'          => esc_html__( 'Theme Color Option', 'capacious' ),
	            ) 
	    );


/* 
-----------------------------------------------------------------------------*/

/**
		 * Basic Colors Options 
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_basic_color_option',
		        array(
		            'title'		=> esc_html__( 'Basic Colors Options ', 'capacious' ),
		            'panel'     => 'capacious_color_info',
		            'priority'  => 4,
		        )
	    );  
	
	$wp_customize->add_setting(
	        'capacious_primary_color_option', 
	            array(
	                'default' => $default['capacious_primary_color_option'],
	                'sanitize_callback' => 'sanitize_hex_color',
	             
		       	)
	    );
	
	  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'capacious_primary_color_option', array(
				'label' => esc_html__( 'Primary Color', 'capacious' ),
				'section' => 'capacious_basic_color_option',
				 'priority' => 14,
				
			) ) ); 
   	
/*-------------------------------------------------------------------------------------------------*/

 /**
		 * HomePage Settings Panel on customizer
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_panel(
	        'capacious_homepage_settings_panel', 
	        	array(
	        		'priority'       => 5,
	            	'capability'     => 'edit_theme_options',
	            	'theme_supports' => '',
	            	'title'          => esc_html__( 'HomePage Settings', 'capacious' ),
	            ) 
	    );


/*********************** Home page content show/Hide **********************/

/**
		 * Hide Home Page Conent
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_hide_home_content_section',
		        array(
		            'title'		=> esc_html__( 'Hide Front Page Content', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 6,
		        )
	    );

	    /**
	     * Switch option to Hide Home Page Conent
	     *
	     * @since 1.0.0
	     */

        $wp_customize->add_setting(
	        'capacious_homepage_hide_front_page_option',
		        array(
		            'default' => $default['capacious_homepage_hide_front_page_option'] ,
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );

	    $choices= capacious_homepage_hide_front_page_option();
	    $wp_customize->add_control(
	        'capacious_homepage_hide_front_page_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Hide Front Page Content', 'capacious' ),
		            'description' 	=> esc_html__( 'You may want to hide front page content and want to show only Feature section. Check this to hide front page content.', 'capacious' ),
		            'section' => 'capacious_hide_home_content_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );



/*-------------------------------------------------------------------------------------------------*/
		/**
		 * Slider Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_slider_section',
		        array(
		            'title'		=> esc_html__( 'Slider Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 6,
		        )
	    );

	    /**
	     * Switch option for Homepage Slider Section
	     *
	     * @since 1.0.0
	     */

 $wp_customize->add_setting(
	        'capacious_homepage_slider_option',
		        array(
		            'default' => $default['capacious_homepage_slider_option'] ,
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
  $choices = capacious_homepage_slider_option(); 
	    $wp_customize->add_control(
	        'capacious_homepage_slider_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Slider Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for homepage Slider Section.', 'capacious' ),
		            'section' => 'capacious_slider_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );
     

     /**
	     * Field for Section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_slider_section_id', 
	            array(
	                'default' =>  $default['capacious_slider_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	                
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_slider_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Home Section Id', 'capacious' ),
		            'section' => 'capacious_slider_section',
		            'priority' => 6
	            )
	    );

  /**
	     * Dropdown available category for homepage slider
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_slider_cat_id',
		        array(
		            'default' =>  $default['capacious_slider_cat_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	   $wp_customize->add_control( new Capacious_Customize_Category_Control(
	        $wp_customize,
	        'capacious_slider_cat_id', 
		        array(
		            'label' => esc_html__( 'Slider Category', 'capacious' ),
		            'description' => esc_html__( 'Select cateogry for Homepage Slider Section', 'capacious' ),
		            'section' => 'capacious_slider_section',
		            'priority' => 8
		        )
		    )
	    );


    /**
	     * Upload image control for section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_slider_section_image',
		        array(
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'esc_url_raw'
		        )
	    );

	    $wp_customize->add_control( new WP_Customize_Image_Control(
	        $wp_customize,
	        'capacious_slider_section_image',
	        	array(
	            	'label'      => esc_html__( 'Section  Background Image', 'capacious' ),
	               	'section'    => 'capacious_slider_section',
	               	'priority' => 9
	           	)
	       	)
	   	);

    

/*----------------------------------------------------------------------------------------------*/
		/**
		 * Quote Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_quote_section',
		        array(
		            'title'		=> esc_html__( 'Quote Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 9,
		        )
	    );

	    /**
	     * Switch option for Homepage Quote Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_quote_option',
		        array(
		            'default' =>  $default['capacious_homepage_quote_option'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
  $choices = capacious_homepage_quote_option();
 $wp_customize->add_control(
	        'capacious_homepage_quote_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( ' Quote Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Quote Section.', 'capacious' ),
		            'section' => 'capacious_quote_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );


	    /**
	     * Field for quote title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_quote_section_title', 
	            array(
	                'default' => $default['capacious_quote_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	                 )
	    );
	    $wp_customize->add_control(
	        'capacious_quote_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Quote Title', 'capacious' ),
		            'section' => 'capacious_quote_section',
		            'priority' => 14
	            )
	    );

	    	    
     /**
	     * Field for Get In Touch button text
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_quote_get_a_quate_txt', 
	            array(
	                'default' => $default['capacious_quote_get_a_quate_txt'],
	                'sanitize_callback' => 'sanitize_text_field',
	                'transport' => 'refresh'
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_quote_get_a_quate_txt',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Get a quote Button', 'capacious' ),
		            'section' => 'capacious_quote_section',
		            'priority' => 15
	            )
	    );

   /**
	     * Field for Get In Touch button text Link
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_quote_get_a_quate_link', 
	            array(
	                'default' =>  $default['capacious_quote_get_a_quate_link'],
	                'sanitize_callback' => 'esc_url_raw',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_quote_get_a_quate_link',
	            array(
		            'type' => 'url',
		            'label' => esc_html__( 'Get a quote Button Link', 'capacious' ),
		            'section' => 'capacious_quote_section',
		            'priority' => 15
	            )
	    );


/*----------------------------------------------------------------------------------------------*/
		/**
		 * About Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_about_section',
		        array(
		            'title'		=> esc_html__( 'About Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 9,
		        )
	    );

	    /**
	     * Switch option for Homepage About Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_about_option',
		        array(
		            'default' => $default['capacious_homepage_about_option'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
   
        $choices=capacious_homepage_about_option();
        $wp_customize->add_control(
	        'capacious_homepage_about_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'About Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage About Section.', 'capacious' ),
		            'section' => 'capacious_about_section',
		            'choices'   =>  $choices,
		            'priority' =>5
	            )
	    );

       /**
	     * Field for section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_about_section_id', 
	            array(
	                'default' => $default['capacious_about_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_about_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'About Us Section Id', 'capacious' ),
		            'section' => 'capacious_about_section',
		            'priority' => 11
	            )
	    );

	    /**
	     * Field for section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_about_section_title', 
	            array(
	                'default' =>  $default['capacious_about_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	                
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_about_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_about_section',
		            'priority' => 11
	            )
	    );

	    /**
	     * Field for section sub title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_about_section_sub_title', 
	            array(
	                'default' =>  $default['capacious_about_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_about_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_about_section',
		            'priority' => 12
	            )
	    );

	    /**
	     * Dropdown available pages for homepage about section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_about_page_id',
		        array(
		            'default' => $default['capacious_about_page_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	    $wp_customize->add_control(
	        'capacious_about_page_id', 
		        array(
		        	'type' => 'dropdown-pages',
		            'label' => esc_html__( 'About us Page', 'capacious' ),
		            'description' => esc_html__( 'Select page for Homepage About Section', 'capacious' ),
		            'section' => 'capacious_about_section',
		            'priority' => 13
		        )
	    );


  

/*--------------------------------------------------------------------------------------------------------------*/
		/**
		 * Our Services Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_services_section',
		        array(
		            'title'		=> esc_html__( 'Our Services Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 20,
		        )
	    );

	    /**
	     * Switch option for Homepage Service Section
	     *
	     * @since 1.0.0
	     */
$wp_customize->add_setting(
	        'capacious_homepage_service_option',
		        array(
		            'default' => $default['capacious_homepage_service_option'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
	   
  $choices= capacious_homepage_service_option();	   
  $wp_customize->add_control(
	        'capacious_homepage_service_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Services Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Our Services  Section.', 'capacious' ),
		            'section' => 'capacious_services_section',
		            'choices'   =>$choices,
		            'priority' =>5
	            )
	    );

/**
	     * Field for section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_services_section_id', 
	            array(
	                'default' => $default['capacious_services_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_services_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Services Section Id', 'capacious' ),
		            'section' => 'capacious_services_section',
		            'priority' => 6
	            )
	    );


	    /**
	     * Field for section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_services_section_title', 
	            array(
	                'default' => $default['capacious_services_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_services_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_services_section',
		            'priority' => 10
	            )
	    );

	    /**
	     * Field for section sub title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_services_section_sub_title', 
	            array(
	                'default' => $default['capacious_services_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_services_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_services_section',
		            'priority' => 15
	            )
	    );


	      
	    /**
	     * Upload image control for section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_services_section_image',
		        array(
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'esc_url_raw'
		        )
	    );

	    $wp_customize->add_control( new WP_Customize_Image_Control(
	        $wp_customize,
	        'capacious_services_section_image',
	        	array(
	            	'label'      => esc_html__( 'Section Image', 'capacious' ),
	               	'section'    => 'capacious_services_section',
	               	'priority' => 18
	           	)
	       	)
	   	);

	   
	$service_priority = 30;
	 $capacious_default_service_icon = array( 'fa-desktop', 'fa-print', 'fa-paint-brush', 'fa-mobile','fa-flash','fa-support' );
    $capacious_separator_label = array( 'First', 'Second', 'Third', 'Forth', 'Fifth', 'Sixth' );
    
    foreach ( $capacious_separator_label as $icon_key => $icon_value ) {    	
		
	     /**
	     * Section separator
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_service_icon_sec_separator_'.$icon_key,
		        array(
		            'default' => '',
		            'sanitize_callback' => 'sanitize_text_field',
		        )
	    );
	    $wp_customize->add_control(new Capacious_Customize_Section_Separator(
	        $wp_customize, 
	            'capacious_service_icon_sec_separator_'.$icon_key, 
	            array(
	                'type' 		=> 'capacious_separator',
	                'label' 	=> sprintf(esc_html__( '%s Service', 'capacious' ), $capacious_separator_label[$icon_key] ),
	                'section' 	=> 'capacious_services_section',
	                'priority'  => $service_priority,
	            )	            	
	        )
	    );

	    /**
	     * Icon list for service tab
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_service_icon_'.$icon_key,
		        array(
		            'default' => $capacious_default_service_icon[$icon_key],
		            'sanitize_callback' => 'sanitize_text_field',
		        )
	    );
	    $wp_customize->add_control( new Capacious_Customize_Icons_Control(
	        $wp_customize, 
	        'capacious_service_icon_'.$icon_key, 
	            array(
	                'type' 		=> 'capacious_icons',	                
	                'label' 	=> sprintf(esc_html__( '%s Service Icon','capacious' ), $capacious_separator_label[$icon_key] ),
	                'description' 	=> esc_html__( 'Choose the icon from lists.', 'capacious' ),
	                'section' 	=> 'capacious_services_section',
	                'priority'  => $service_priority,
	            )	            	
	        )
	    );

	 $service_priority = $service_priority+5;
	    	  
	    /**
	     * Dropdown available pages for homepage service section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_service_page_id_'.$icon_key,
		        array(
		            'default' => '0',
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	    $wp_customize->add_control(
	        'capacious_service_page_id_'.$icon_key,
		        array(
		        	'type' => 'dropdown-pages',
		            'label' =>sprintf(esc_html__( '%s Service Page', 'capacious' ), $capacious_separator_label[$icon_key] ),

		            'description' => esc_html__( 'Select page for Homepage Service Section', 'capacious' ),
		            'section' => 'capacious_services_section',
		            'priority' => $service_priority
		        )
	    );
	    $service_priority = $service_priority+5;
	}


/*--------------------------------------------------------------------------------------------------------------*/

/**
		 * Satisfied Clients
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_satisfied_clients_section',
		        array(
		            'title'		=> esc_html__( 'Satisfied Clients Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 20,
		        )
	    );

	    /**
	     * Switch option for Homepage Satisfied Clients Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_satisfied_clients_option',
		        array(
		            'default' => $default['capacious_homepage_satisfied_clients_option'],
		            'transport' => 'refresh',
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );

       $choices= capacious_homepage_satisfied_clients_option();
        $wp_customize->add_control(
	        'capacious_homepage_satisfied_clients_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Satisfied Clients Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Satisfied Clients Section.', 'capacious' ),
		            'section' => 'capacious_satisfied_clients_section',
		            'choices'   =>  $choices,
		            'priority' =>5
	            )
	    );


	    /**
	     * Field for Satisfied Clients section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_satisfied_clients_section_title', 
	            array(
	                'default' =>  $default['capacious_satisfied_clients_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	                  )
	    );
	    $wp_customize->add_control(
	        'capacious_satisfied_clients_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_satisfied_clients_section',
		            'priority' => 11
	            )
	    );

	     /**
	     * Field for section sub title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_satisfied_clients_section_sub_title', 
	            array(
	                'default' => $default['capacious_satisfied_clients_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_satisfied_clients_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_satisfied_clients_section',
		            'priority' => 15
	            )
	    );

      
       /**
	     * Field for section description
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_satisfied_clients_section_description', 
	            array(
	                'default' => $default['capacious_satisfied_clients_section_description'],
	                'sanitize_callback' => 'wp_kses_post',
	                
		       	)
	    );    
	    $wp_customize->add_control(
	        'capacious_satisfied_clients_section_description',
	            array(
		            'type' => 'textarea',
		            'label' => esc_html__( 'Section Description', 'capacious' ),
		            'section' => 'capacious_satisfied_clients_section',
		            'priority' => 16
	            )
	    );


	    /**
	     * Dropdown available categories for homepage Satisfied Clients section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_satisfied_clients_section_cat_id',
		        array(
		            'default' => $default['capacious_satisfied_clients_section_cat_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	   
$wp_customize->add_control( new capacious_Customize_Category_Control(
	        $wp_customize,
	        'capacious_satisfied_clients_section_cat_id', 
		        array(
		            'label' => esc_html__( 'Satisfied Clients Category', 'capacious' ),
		            'description' => esc_html__( 'Select Category for Homepage Satisfied Clients Section', 'capacious' ),
		            'section' => 'capacious_satisfied_clients_section',
		            'priority' => 20
		        )
		    )
	    );


	    /**
	     * Upload image control for Satisfied Clients section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_satisfied_clients_bg_image',
		        array(
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'esc_url_raw'
		        )
	    );

	    $wp_customize->add_control( new WP_Customize_Image_Control(
	        $wp_customize,
	        'capacious_satisfied_clients_bg_image',
	        	array(
	            	'label'      => esc_html__( 'Section Background Image', 'capacious' ),
	               	'section'    => 'capacious_satisfied_clients_section',
	               	'priority' => 25
	           	)
	       	)
	   	);
   
	

/*---------------------------------------------------------------------------------------*/
		/**
		 * Meet Our Team*
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_our_team_section',
		        array(
		            'title'		=> esc_html__( 'Meet Our Team', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 25,
		        )  
	    );

	    /**
	     * Switch option for Meet Our Team Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_our_team_option',
		        array(
		            'default' => $default['capacious_homepage_our_team_option'],
		            'transport' => 'refresh',
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
     $choices= capacious_homepage_our_team_option();
    $wp_customize->add_control(
	        'capacious_homepage_our_team_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Meet Our Team Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Meet Our Team Section.', 'capacious' ),
		            'section' => 'capacious_our_team_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );

/**
	     * Field for section ID
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_our_team_section_id', 
	            array(
	                'default' => $default['capacious_our_team_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	                
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_our_team_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Team Section Id', 'capacious' ),
		            'section' => 'capacious_our_team_section',
		            'priority' => 6
	            )
	    );


	    /**
	     * Field for section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_our_team_section_title', 
	            array(
	                'default' =>  $default['capacious_our_team_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	              	)
	    );
	    $wp_customize->add_control(
	        'capacious_our_team_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_our_team_section',
		            'priority' => 11
	            )
	    );

	    /**
	     * Field for section sub title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_our_team_section_sub_title', 
	            array(
	                'default' =>  $default['capacious_our_team_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_our_team_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_our_team_section',
		            'priority' => 12
	            )
	    );
	    
	    /**
	     * Dropdown available category for homepage our team
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_our_team_cat_id',
		        array(
		            'default' =>  $default['capacious_our_team_cat_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	    $wp_customize->add_control( new capacious_Customize_Category_Control(
	        $wp_customize,
	        'capacious_our_team_cat_id', 
		        array(
		            'label' => esc_html__( 'Section Category', 'capacious' ),
		            'description' => esc_html__( 'Select cateogry for Homepage Our Team Section', 'capacious' ),
		            'section' => 'capacious_our_team_section',
		            'priority' => 25
		        )
		    )
	    );
    

/*---------------------------------------------------------------------------------------*/
		/**
		 * Meet Testimonials*
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_testimonials_section',
		        array(
		            'title'		=> esc_html__( 'Testimonials', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 27,
		        )  
	    );

	    /**
	     * Switch option for Testimonials Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_testimonials_option',
		        array(
		            'default' =>  $default['capacious_homepage_testimonials_option'] ,
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
$choices = capacious_homepage_testimonials_option();
 $wp_customize->add_control(
	        'capacious_homepage_testimonials_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Testimonials Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Testimonials Section.', 'capacious' ),
		            'section' => 'capacious_testimonials_section',
		            'choices'   =>$choices,
		            'priority' =>5
	            )
	    );

      	    
      /**
	     * Field for section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_testimonial_section_id', 
	            array(
	                'default' => $default['capacious_testimonial_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_testimonial_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Testimonials Section Id', 'capacious' ),
		            'section' => 'capacious_testimonials_section',
		            'priority' => 12
	            )
	    );	    


	    /**
	     * Dropdown available category for homepage Testimonials
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_testimonials_cat_id',
		        array(
		            'default' => $default['capacious_testimonials_cat_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	    $wp_customize->add_control( new capacious_Customize_Category_Control(
	        $wp_customize,
	        'capacious_testimonials_cat_id', 
		        array(
			            'label' => esc_html__( 'Section Category', 'capacious' ),
			            'description' => esc_html__( 'Select cateogry for Homepage Testimonials Section', 'capacious' ),
			            'section' => 'capacious_testimonials_section',
			            'priority' => 25
		            )
		    )
	    );
    
     /**
	     * Upload image control for section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_testimonials_section_image',
		        array(
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'esc_url_raw'
		        )
	    );

	    $wp_customize->add_control( new WP_Customize_Image_Control(
	        $wp_customize,
	        'capacious_testimonials_section_image',
	        	array(
	            	'label'      => esc_html__( 'Testimonials Background Image', 'capacious' ),
	               	'section'    => 'capacious_testimonials_section',
	               	'priority' => 29
	           	)
	       	)
	   	);

    


 

/*---------------------------------------------------------------------------------------*/
		/**
		 * Blog Section*
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_blog_section',
		        array(
		            'title'		=> esc_html__( 'Blog', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 27,
		        )  
	    );

	    /**
	     * Switch option for Blog Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_blog_option',
		        array(
		            'default' => $default['capacious_homepage_blog_option'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
 $choices = capacious_homepage_blog_option();
 $wp_customize->add_control(
	        'capacious_homepage_blog_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Blog Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Blog Section.', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );

 /**
	     * Field for Blog section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_blog_section_id', 
	            array(
	                'default' => $default['capacious_blog_section_id'],
	                'sanitize_callback' => 'sanitize_text_field',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_blog_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Blog Section Id', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'priority' => 11
	            )
	    );

 
 /**
	     * Field for section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_blog_section_title', 
	            array(
	                'default' => $default['capacious_blog_section_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	                
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_blog_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'priority' => 11
	            )
	    );

	    /**
	     * Field for section sub title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_blog_section_sub_title', 
	            array(
	                'default' => $default['capacious_blog_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_blog_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'priority' => 12
	            )
	    );

  /**
	     * Field for View All Button
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_blog_section_view_all_text', 
	            array(
	                'default' => $default['capacious_blog_section_view_all_text'],
	                'sanitize_callback' => 'sanitize_text_field',
	              
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_blog_section_view_all_text',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'View All Button Text', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'priority' => 12
	            )
	    );



 /**
	     * Select Field category
	     *
	     * @since 1.0.0
	     */
	    
	    $wp_customize->add_setting(
	        'capacious_blog_categories_id',
		        array(
		            'default'           =>$default['capacious_blog_categories_id'],
		            'capability' => 'edit_theme_options',
		            'sanitize_callback' => 'absint'
		        )
	    );
	   
	     $wp_customize->add_control( new Capacious_Customize_Category_Control(
	        $wp_customize,
	        'capacious_blog_categories_id', 
		        array(
		            'label' => esc_html__( 'Section Category', 'capacious' ),
		            'description' => esc_html__( 'Select cateogry for Homepage Blog Section', 'capacious' ),
		            'section' => 'capacious_blog_section',
		            'priority' => 20,
		            
		        )
		    )
	    );

    /*-------------------------------------------------------------------------------------------------*/
		/**
		 * Contact Us Section
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_contact_section',
		        array(
		            'title'		=> esc_html__( 'Contact Us Section', 'capacious' ),
		            'panel'     => 'capacious_homepage_settings_panel',
		            'priority'  => 45,
		        )
	    );

	    
	    /**
	     * Switch option for Contact Us Section
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_homepage_contact_option',
		        array(
		            'default' => $default['capacious_homepage_contact_option'],
		            'sanitize_callback' => 'capacious_sanitize_select',
		        )
	    );
      
      $choices = capacious_homepage_contact_option();
       $wp_customize->add_control(
	        'capacious_homepage_contact_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Contact Us Section Option', 'capacious' ),
		            'description' 	=> esc_html__( 'Show/hide option for Homepage Contact Us Section.', 'capacious' ),
		            'section' => 'capacious_contact_section',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );


    /**
	     * Field for section Id
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_contact_section_id', 
	            array(
	                'default' =>  $default['capacious_contact_section_id'] ,
	                'sanitize_callback' => 'sanitize_text_field',
	            
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_contact_section_id',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Contact Us Section Id', 'capacious' ),
		            'section' => 'capacious_contact_section',
		            'priority' => 10
	            )
	    );



	    /**
	     * Field for section title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_contact_section_title', 
	            array(
	                'default' => $default['capacious_contact_section_title'] ,
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_contact_section_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Title', 'capacious' ),
		            'section' => 'capacious_contact_section',
		            'priority' => 10
	            )
	    );

	    /**
	     * Field for section sub-title
	     *
	     * @since 1.0.0
	     */
	    $wp_customize->add_setting(
	        'capacious_contact_section_sub_title', 
	            array(
	                'default' => $default['capacious_contact_section_sub_title'],
	                'sanitize_callback' => 'sanitize_text_field',
	               
		       	)
	    );
	    $wp_customize->add_control(
	        'capacious_contact_section_sub_title',
	            array(
		            'type' => 'text',
		            'label' => esc_html__( 'Section Sub Title', 'capacious' ),
		            'section' => 'capacious_contact_section',
		            'priority' => 15
	            )
	    );

	    /**
	     * Field for Text Area
	     *
	     * @since 1.0.0
	     */
		$wp_customize->add_setting(
			'capacious_contact_section_form_editor',
			array(
				'capability'         => 'edit_theme_options',
			     'sanitize_callback'  => 'wp_kses_post'
			)
		);

		$wp_customize->add_control( 
			'capacious_contact_section_form_editor',
				array(
					 'type' => 'textarea',
					'label'       => esc_html__( 'Contact Form', 'capacious' ),
					'description' => esc_html__( 'Use contact form 7 shortcode.', 'capacious' ),
					'section'     => 'capacious_contact_section',
					'priority'	  => 20
				)
			
		);



	    


	 

   