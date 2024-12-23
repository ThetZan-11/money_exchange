<?php 
function get_exchange_rate(){
    require_once '../db/db.php';
    require_once '../db/daily_exchange_crud.php';
    $key = "b12a2a800465395edab5dc62";
    $base_currency_list = ["USD","MMK","JPY","THB","EUR"];
    foreach ($base_currency_list as $buy_currency) {
        $req_url = "https://v6.exchangerate-api.com/v6/$key/latest/$buy_currency";
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    echo "<pre>";
                    
                    $resultsList = ["USD","MMK","JPY","THB","EUR"];
                    $date = date("Y-m-d H:i:s", time());
                    foreach ($resultsList as $sell_currency) {
                        $currency_code = $response->conversion_rates->$sell_currency;
                        $buy_rate  =  $currency_code-($currency_code*0.02);
                        $sell_rate =  $currency_code+($currency_code*0.02);
                        var_dump("$buy_currency sell rate for $sell_currency = ".$sell_rate,"$buy_currency buy rate for $sell_currency = ".$buy_rate);
                        update_daily($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency);
                    }
                }
            }
            catch(Exception $e) {
                echo "Api error";
            }
        }
    }
}

get_exchange_rate();


