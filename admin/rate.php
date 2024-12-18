<?php 
function get_exchange_rate($buy_currency){
    require_once ('../db/db.php');
    require_once ('../db/daily_exchange_crud.php');
    $key = "b12a2a800465395edab5dc62";
    $req_url = "https://v6.exchangerate-api.com/v6/$key/latest/$buy_currency";
    $response_json = file_get_contents($req_url);
    if(false !== $response_json) {
        try {
            $response = json_decode($response_json);
            if('success' === $response->result) {

                echo "<pre>";
                $i=0;
                // var_dump($response);
                $resultsList = ["MMK","JPY","USD","THB","PHP"];
                $date = date("Y-m-d H:i:s", time());
                foreach ($resultsList as $sell_currency) {
                    $i++;
                    $currency_code = $response->conversion_rates->$sell_currency;
                    //var_dump($response->conversion_rates->$sell_currency+(($response->conversion_rates->$sell_currency)*0.02));
                    //var_dump($response->conversion_rates->$sell_currency-(($response->conversion_rates->$sell_currency)*0.02));
                    $buy_rate  = $currency_code-($currency_code*0.02);
                    $sell_rate = $currency_code+($currency_code*0.02);
                    var_dump("buy rate for $sell_currency = ".$buy_rate,"sell rate for $sell_currency = ".$sell_rate);
                    var_dump($i);
                    update_daily($mysqli, $i, $sell_rate, $buy_rate, $date);
                }
                var_dump("Last update time is ".$response->time_last_update_utc);
                var_dump("Next update time is ".$response->time_next_update_utc);
            }
        }
        catch(Exception $e) {
            echo "Api error";
        }
    }
}

get_exchange_rate("USD");
