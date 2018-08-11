<?php

//Json stocks index symbols
function consulting_get_stocks_indexes_symbols() {

    $transient_name = 'consulting_get_stocks_indexes_symbols';
    $json = get_transient($transient_name);
    if (false === $json) {
        $path = get_template_directory() . '/inc/stock-indexes/stock-indexes.json';
        $json = json_decode(file_get_contents($path), true);
        //set_transient($transient_name, $json);
    }

    delete_transient($transient_name, $json);

    return $json;
}

//Yahoo API symbols settings
function consulting_currencies_stocks_api($indexes) {
    $stocks_transient = get_theme_mod( 'stocks_transient' );

    $transient_name = 'stm_currency_and_stocks_' . sanitize_title(implode('_', $indexes)) . '_' . $stocks_transient;

    if ( false === ( $result = get_transient( $transient_name ) ) ) {
        $queryNumber = rand(1, 2);

        $curly = array();
        $result = array();

        $mh = curl_multi_init();

        foreach ($indexes as $id => $d) {

            $curly[$id] = curl_init();

            $url = 'https://query' . $queryNumber . '.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=' . $d . '&fields=regularMarketPrice,regularMarketChange,regularMarketChangePercent,currency';
            curl_setopt($curly[$id], CURLOPT_URL, $url);
            curl_setopt($curly[$id], CURLOPT_HEADER, 0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, 0);

            curl_multi_add_handle($mh, $curly[$id]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        foreach ($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            $result[$id] = json_decode($result[$id], true);
            $result[$id] = array_shift($result[$id]['quoteResponse']['result']);
            curl_multi_remove_handle($mh, $c);
        }

        curl_multi_close($mh);

        set_transient( $transient_name, $result, $stocks_transient);

    }

    //delete_transient( $transient_name, $result, $stocks_transient);

    return ($result);
}

//Send to ajax
function stm_get_prices() {
    $r = array();
    $indexes = (!empty($_GET['indexes'])) ? sanitize_text_field($_GET['indexes']) : '';
    if(!empty($indexes)) {
        $indexes = explode(', ', $indexes);
        $r = consulting_currencies_stocks_api($indexes);
    }

    wp_send_json($r);
}

add_action( 'wp_ajax_stm_get_prices', 'stm_get_prices' );
add_action( 'wp_ajax_nopriv_stm_get_prices', 'stm_get_prices' );

//Yahoo API symbols and dates settings
function consulting_currencies($indexes, $range='1d', $interval='1h', $fill_color, $point_color){

    $stocks_transient = get_theme_mod( 'stocks_transient' );

    $transient_name = 'stm_currency_and_' . sanitize_title(implode('_', $indexes)) . '_' . $range . '_' . $interval . '_' . $stocks_transient;

    if ( false === ( $result = get_transient( $transient_name ) ) ) {
        $queryNumber = rand(1, 2);

        $curly = array();
        $result = array();

        $mh = curl_multi_init();

        foreach ($indexes as $id => $d) {

            $curly[$id] = curl_init();

            $url = 'https://query' . $queryNumber . '.finance.yahoo.com/v7/finance/spark?&symbols=' . $d . '&range=' . $range . '&interval=' . $interval;

            curl_setopt($curly[$id], CURLOPT_URL, $url);
            curl_setopt($curly[$id], CURLOPT_HEADER, 0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, 0);

            curl_multi_add_handle($mh, $curly[$id]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        foreach ($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            $result[$id] = json_decode($result[$id], true);
            $result[$id] = array_shift($result[$id]['spark']['result']['0']['response']);
            $result[$id]['fill_color'] = $fill_color[$id];
            $result[$id]['point_color'] = $point_color[$id];
            curl_multi_remove_handle($mh, $c);
        }

        curl_multi_close($mh);


        $result = consulting_generate_result($result);


        set_transient( $transient_name, $result, $stocks_transient);

    }

    //delete_transient( $transient_name, $result, $stocks_transient);

    return ($result);
}

function consulting_generate_result($result) {

    $response = array();


    foreach($result as $item => $value) {

        $close_prices = $result[$item]['indicators']['quote'][0]['close'];
        $timestamps = $result[$item]['timestamp'];
        $fill_color = $result[$item]['fill_color'];
        $point_color = $result[$item]['point_color'];
        $labels = array();
        foreach ($timestamps as $timestamp) {
            $labels[] = date_i18n('D h:i', $timestamp);
        }
        $key = $value['meta']['symbol'];
        $response['indexes'][] = [
            'label' => $key,
            'data' => $close_prices,
            'backgroundColor' => $fill_color,
            'borderColor' => $point_color,
            'pointRadius' => 0,
            'borderWidth' => 1,
        ];

        $response['labels'] = $labels;
    }

    return $response;
}

//Send history to ajax
function stm_get_history() {
    $r = array();
    $indexes = (!empty($_GET['indexes'])) ? sanitize_text_field($_GET['indexes']) : '';
    $range = (!empty($_GET['range'])) ? sanitize_text_field($_GET['range']) : '1d';
    $interval = (!empty($_GET['interval'])) ? sanitize_text_field($_GET['interval']) : '1h';
    $fill_color = (!empty($_GET['fill_color'])) ? sanitize_text_field($_GET['fill_color']) : '';
    $point_color = (!empty($_GET['point_color'])) ? sanitize_text_field($_GET['point_color']) : '';
    if(!empty($indexes)) {
        $indexes = explode(', ', $indexes);
        $fill_color = explode(', ', $fill_color);
        $point_color = explode(', ', $point_color);
        $r = consulting_currencies($indexes, $range, $interval, $fill_color, $point_color);
    }

    wp_send_json($r);
}

add_action( 'wp_ajax_stm_get_history', 'stm_get_history' );
add_action( 'wp_ajax_nopriv_stm_get_history', 'stm_get_history' );