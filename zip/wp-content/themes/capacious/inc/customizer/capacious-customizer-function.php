<?php
/**
 * Define some custom classes for capacious.
 * 
 * https://codex.wordpress.org/Class_Reference/WP_Customize_Control
 *
 * @package Canyon Themes
 * @subpackage capacious
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
   	
	/**
	 * A class to create a dropdown for all categories in your wordpress site
	 *
	 * @since 1.0.0
	 * @capacious public
	 */
	class Capacious_Customize_Category_Control extends WP_Customize_Control {
		
		/**
		 * Render the control's content.
		 *
		 * @return HTML
		 * @since 1.0.0
		 */
		public function render_content() {
			$dropdown = wp_dropdown_categories(
					array(
						'name'              => '_customize-dropdown-categories-' . $this->id,
						'echo'              => 0,
						'show_option_none'  => esc_html__( '&mdash; Select Category &mdash;', 'capacious' ),
						'option_none_value' => '0',
						'selected'          => $this->value(),
					)
			);

			// Hackily add in the data link parameter.
			$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

			printf(
				'<label class="customize-control-select"><span class="customize-control-title">%s</span><span class="description customize-control-description">%s</span> %s </label>',
				$this->label,
				$this->description,
				$dropdown
			);
		}
	}

	    

  /**
	 * A class to create a list of icons in customizer field
	 *
	 * @since 1.0.0
	 * @capacious
	 */
	class Capacious_Customize_Icons_Control extends WP_Customize_Control {

		/**
	     * The type of customize control being rendered.
	     *
	     * @since  1.0.0
	     * @access public
	     * @var    string
	     */
		public $type = 'capacious_icons';

		/**
	     * Displays the control content.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
		public function render_content() {

			$saved_icon_value = $this->value();
	?>
			<label>
			    <span class="capacious-customize-control-title"><h3><?php echo esc_html( $this->label ); ?></h3>
			    	
			    </span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<div class="capacious-customize-icons">
					<div class="selected-icon-preview"><?php if( !empty( $saved_icon_value ) ) { echo '<i class="fa '. esc_attr( $saved_icon_value ) .'"></i>'; } ?>
						
					</div>
					<input type="text" name="search" class="search" value="" placeholder="Search">
					<ul class="capacious-icons-list-wrapper">
						<?php 
							$capacious_icons_list = capacious_fontsome_icons_array();
						
							foreach ( $capacious_icons_list as $key => $icon_value ) {
								if( $saved_icon_value == $icon_value ) {
									echo '<li class="selected"><i class="fa '. esc_attr( $icon_value ) .'"></i></li>';
								} else {
									echo '<li><i class="fa '. esc_attr( $icon_value ) .'"></i></li>';
								}
							}
						?>
						
					</ul>
					<input type="hidden" class="capacious-icon-value" value="" <?php $this->link(); ?>>
				</div>

			</label>
	<?php
		}
	}

	/**
	 * A class to create a option separator in customizer section 
	 *
	 *@since 1.0.0
	 */
	class Capacious_Customize_Section_Separator extends WP_Customize_Control {
		/**
	     * The type of customize control being rendered.
	     *
	     * @since  1.0.0
	     * @access public
	     * @var    string
	     */
		public $type = 'capacious_separator';

		/**
	     * Displays the control content.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
		public function render_content() {
	?>
		<div class="capacious-customize-section-wrap">
			<label>
				<span class="capacious-customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>
		</div>
	<?php
		}
	}


}

