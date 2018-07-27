<?php

	wp_enqueue_style(
		'wplab-albedo-mailchimp',
		wplab_albedo_utils::locate_uri( '/css/front/less/plugins/mailchimp.less'), false, _WPLAB_ALBEDO_CACHE_TIME_
	);
