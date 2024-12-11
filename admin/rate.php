<?php 
    // Fetching JSON
$req_url = 'https://v6.exchangerate-api.com/v6/b12a2a800465395edab5dc62/latest/USD';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

		// Decoding
		$response = json_decode($response_json);

		// Check for success
		if('success' === $response->result) {

			
			$EUR_price = round(($base_price * $response->conversion_rates->EUR), 2);
            
		}

    }
    catch(Exception $e) {
        echo "Api error";
    }
   
   
}

