<?php
/**
 * Define sanitize functions for customizer fields
 *
 * @package Canyon Themes
 * @subpackage capacious
 * @since 1.0.0
 */

/**
 * Sanitize number field
 *
 * @since 1.0.0
 */
function capacious_sanitize_number( $input ) {
    $output = intval($input);
     return $output;
}

/**
 * Sanitize checkbox field
 *
 * @since 1.0.0
 */
if ( !function_exists('capacious_sanitize_checkbox') ) :
        function capacious_sanitize_checkbox( $checked )
        {
            // Boolean check.
            return ( ( isset( $checked ) && true == $checked ) ? true : false );
        }
    endif;


/**
 * Sanitizing the select callback example
 *
 * @since capacious 1.0.0
 *
 * @param $input
 * @param $setting
 * @return sanitized output
 *
 */
if ( !function_exists('capacious_sanitize_select') ) :
    function capacious_sanitize_select( $input, $setting ) {

        // Ensure input is a slug.
        $input = sanitize_key( $input );

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
endif;

if ( !function_exists('capacious_sanitize_dropdown_pages') ) :

function capacious_sanitize_dropdown_pages( $page_id, $setting ) {
    $page_id = absint( $page_id );
    // If $page_id is an ID of a published page, return it; otherwise, return the default.
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

endif;
