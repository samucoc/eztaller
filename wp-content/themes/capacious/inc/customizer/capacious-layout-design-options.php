<?php
/**
		 * Layout/Design Option
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_panel(
	        'capacious_design_layout_options', 
	        	array(
	        		'priority'       => 7,
	            	'capability'     => 'edit_theme_options',
	            	'theme_supports' => '',
	            	'title'          => esc_html__( ' Layout/Design Option', 'capacious' ),
	            ) 
	    );

	  /*-------------------------------------------------------------------------------------------*/
		/**
		 * Sidebar Option
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_default_sidbar_layout_option',
		        array(
		            'title'		=> esc_html__( 'Default Sidebar Layout Option', 'capacious' ),
		            'panel'     => 'capacious_design_layout_options',
		            'priority'  => 6,
		        )
	    );  
    
      /**
		 * Sidebar Option
	  */
        $wp_customize->add_setting(
	        'capacious_sidebar_layout_option', 
	            array(
	                'default'           => $default['capacious_sidebar_layout_option'] ,
	                'sanitize_callback' => 'capacious_sanitize_select',
	                'transport' => 'refresh'
		       	)
	    );
	    
		
     $layout = capacious_sidebar_layout();
     $wp_customize->add_control('capacious_sidebar_layout_option',
            array(
           'label'      => esc_html__('Default Sidebar Layout','capacious'),
	        'description' => esc_html__('Home/front page does not have sidebar. Inner Pages like blog, archive single page/post Sidebar Layout. However single page/post sidebar can be overridden.', 'capacious'),
	        'section'   => 'capacious_default_sidbar_layout_option',
            'type'	  	=> 'select',
             'choices'   => $layout,
            'priority'  => 10
         )
    ); 
    
               		 
   
    
 /*-------------------------------------------------------------------------------------------*/
		/**
		 * Author Info Options
		 *
		 * @since 1.0.0
		 */
		$wp_customize->add_section(
	        'capacious_author_info_option',
		        array(
		            'title'		=> esc_html__( 'Author Info Options', 'capacious' ),
		            'panel'     => 'capacious_design_layout_options',
		            'priority'  => 6,
		        )
	    );  
    
      /**
		 * Show Author Info
	  */
        $wp_customize->add_setting(
	        'capacious_show_author_info_option', 
	            array(
	                'default'           =>  $default['capacious_show_author_info_option'],
	                'sanitize_callback' => 'capacious_sanitize_select',
	                'transport' => 'refresh'
		       	)
	    );
	    
		$choices=capacious_show_author_info_option();
      $wp_customize->add_control(
	        'capacious_show_author_info_option',
	            array(
		            'type' => 'radio',
		            'label' => esc_html__( 'Show/Hide Show Author Info', 'capacious' ),
		            'section' => 'capacious_author_info_option',
		            'choices'   => $choices,
		            'priority' =>5
	            )
	    );

   

