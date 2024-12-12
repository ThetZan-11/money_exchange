<?php 
function get_exchange_rate($buy_currency){
    $key = "b12a2a800465395edab5dc62";
    $req_url = "https://v6.exchangerate-api.com/v6/$key/latest/$buy_currency";
    $response_json = file_get_contents($req_url);
    if(false !== $response_json) {
        try {
            $response = json_decode($response_json);
            if('success' === $response->result) {
                echo "<pre>";
                $resultsList = ["MMK","JPY"];
                foreach ($resultsList as $sell_currency) {
                    var_dump($response->conversion_rates->$sell_currency+(($response->conversion_rates->$sell_currency)*0.02)) ;
                    var_dump($response->conversion_rates->$sell_currency-(($response->conversion_rates->$sell_currency)*0.02)) ;
                }
            }
        }
        catch(Exception $e) {
            echo "Api error";
        }
    }
}

get_exchange_rate("USD");
