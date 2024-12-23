<?php 
function get_exchange_rate($mysqli){
    $key = "b12a2a800465395edab5dc62";
    $buy_currencies_from_db = select_only_buy_code($mysqli);
    $sell_currencies_from_db = select_only_sell_code($mysqli);
    $buy_currency_arr = [];
    $sell_currency_arr = [];
    $date_validate  = select_date($mysqli);
    while ($buy_currencies = $buy_currencies_from_db->fetch_assoc()) {
       array_push($buy_currency_arr, $buy_currencies['buy_currency_code']);
    }
    while ($sell_currencies = $sell_currencies_from_db->fetch_assoc()) {
        array_push($sell_currency_arr, $sell_currencies['sell_currency_code']);
    }
    foreach ($buy_currency_arr as $buy_currency) {
        $req_url = "https://v6.exchangerate-api.com/v6/$key/latest/$buy_currency";
        $response_json = file_get_contents($req_url);
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    echo "<pre>";
                    $date = date("Y-m-d", time());
                    foreach ($sell_currency_arr as $sell_currency) {
                        // $sell_currency = $sell_currencies['sell_currency_code'];
                        $currency_code = $response->conversion_rates->$sell_currency;
                        $buy_rate  =  $currency_code-($currency_code*0.02);
                        $sell_rate =  $currency_code+($currency_code*0.02);
                        // var_dump("$buy_currency buy rate for $sell_currency is $buy_rate");
                        // var_dump("$buy_currency sell rate for $sell_currency is $sell_rate");
                        if($date_validate['date'] == $date){
                            update_daily($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency);
                        } else {
                            add_new_rate($mysqli, $sell_rate, $buy_rate, $date, $buy_currency, $sell_currency);
                        }
                        
                    }
                }
            }
            catch(Exception $e) {
                echo "Api error";
            }
        }
    }
}



