<?php 
/** load static stylesheet **/
wp_enqueue_style( 'wplab-albedo-contact-info', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/contact_info.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
wp_enqueue_style( 'wplab-albedo-contact-info-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/contact_info_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
