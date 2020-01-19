<?php

class ecr_PostcodeNotFoundException extends Exception{}

function getPostcodeCoordinates($postcode) {
    $api_url = "https://api.postcodes.io/postcodes?q=";

    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $api_url . urlencode($postcode),
        CURLOPT_RETURNTRANSFER => 1,
    );
    curl_setopt_array($ch, $options);

    $response = json_decode(curl_exec($ch), true);
    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if($response_code !== 200 || $response['status'] !== 200) throw new Exception('postcodes.io API returned status code ' . $response_code . '. ' . $api_url . $postcode);
    if($response['result'] == NULL || count($response['result']) == 0) throw new ecr_PostcodeNotFoundException('Postcode not found.');

    return array(
        'lat' => $response['result'][0]['latitude'],
        'long' => $response['result'][0]['longitude']
    );
}

// { 'lat': FLOAT, 'long': FLOAT }
function distanceBetweenPoints($from, $to) {
    $R = 6371; // Radius of earth = 6371km

    $dLat = deg2rad($from['lat'] - $to['lat']);
    $dLong = deg2rad($from['long'] - $to['long']);

    // hav(x) = sin^2(x/2)
    // angle in great circle (in radians) = d/r 
    // h = hav(O) = hav(dLat) + cos(lat1)cos(lat2)hav(dLong)
    // d = r archav(h) = 2r arcsin(sqrt h)

    $h = sin($dLat/2)*sin($dLat/2) + 
        cos(deg2rad($from['lat']))*cos(deg2rad($to['lat']))
        *sin($dLong/2)*sin($dLong/2);
    $d = 2*$R * asin(sqrt($h));
    
    return $d;
}

function distanceBetweenPostcodes($fromcode, $tocode) {
    $fromCoords = getPostcodeCoordinates($fromcode);
    $toCoords = getPostcodeCoordinates($tocode);

    return distanceBetweenPoints($fromCoords, $toCoords);
}
add_filter('climatestrike_postcode_distance', 'distanceBetweenPostcodes', 10, 2); // Priority 10, accepted args 2
