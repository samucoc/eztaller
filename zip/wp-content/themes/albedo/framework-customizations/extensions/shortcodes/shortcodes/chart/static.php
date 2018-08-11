<?php

if (!function_exists('_action_wplab_albedo_shortcode_chart_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_chart_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;

		$shortcode = 'chart';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$chart_type = $atts['type'];

		$id = $atts['id'];
		$labels = $values = $colors = array();

		foreach ($atts['items'] as $key => $item ):
			$labels[] = "'" . $item['title'] . "'";
			$values[] = $item['value'];

			$color = isset( $item['color'] ) ? $item['color'] : '';

			$colors[] = "'" . $color . "'";
		endforeach;

		wp_enqueue_script( 'chartjs');

		$script = '';

		if( $chart_type == 'line' ) {

			$script = "
	new Chart( document.getElementById('shortcode-" . $id . "'), {
		type: 'line',
		data: {
			labels: [" . implode(',', $labels) . "],
			datasets: [ {
				label: '" . $atts['label'] . "',
				fill: false,
				lineTension: 0.1,
				backgroundColor: '#0081ff',
				borderColor: '#0081ff',
				borderCapStyle: 'butt',
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter',
				pointBorderColor: '#0081ff',
				pointBackgroundColor: '#fff',
				pointBorderWidth: 1,
				pointHoverRadius: 5,
				pointHoverBackgroundColor: 'rgba(75,192,192,1)',
				pointHoverBorderColor: 'rgba(220,220,220,1)',
				pointHoverBorderWidth: 1,
				pointRadius: 1,
				pointHitRadius: 10,
				data: [" . implode(',', $values) . "],
			} ]
		}
	});
			";

		} elseif( $chart_type == 'bar' ) {

			$script = "
	new Chart( document.getElementById('shortcode-" . $id . "'), {
		type: 'bar',
		data: {
			labels: [" . implode(',', $labels) . "],
			datasets: [ {
				label: '" . $atts['label'] . "',
				fill: false,
				lineTension: 0.1,
				backgroundColor: '#0081ff',
				borderColor: '#0081ff',
				borderCapStyle: 'butt',
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter',
				pointBorderColor: '#0081ff',
				pointBackgroundColor: '#fff',
				pointBorderWidth: 1,
				pointHoverRadius: 5,
				pointHoverBackgroundColor: 'rgba(75,192,192,1)',
				pointHoverBorderColor: 'rgba(220,220,220,1)',
				pointHoverBorderWidth: 1,
				pointRadius: 1,
				pointHitRadius: 10,
				data: [" . implode(',', $values) . "],
			} ]
		}
	});
			";

		} elseif( $chart_type == 'pie' ) {

			$script = "
	new Chart( document.getElementById('shortcode-" . $id . "'), {
				type: 'pie',
				data: {
				labels: [" . implode(',', $labels) . "],
				datasets: [
			{
				data: [" . implode(',', $values) . "],
				backgroundColor: [ " . implode(',', $colors) . " ]
			}]
		}
	});
			";

		}

		wp_add_inline_script( 'chartjs', $script );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:chart',
		'_action_wplab_albedo_shortcode_chart_enqueue_dynamic_css'
	);

endif;
