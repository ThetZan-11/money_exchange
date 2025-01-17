<?php 
function get_exchange_rate($mysqli){
    $key = "b12a2a800465395edab5dc62";
    $buy_currencies_from_db = select_currency_code($mysqli);
    $sell_currencies_from_db = select_currency_code($mysqli);
    $buy_currency_arr = [];
    $sell_currency_arr = [];
    $date_validate  = select_date($mysqli);
    while ($buy_currencies = $buy_currencies_from_db->fetch_assoc()) {
        array_push($buy_currency_arr, $buy_currencies['currency_code']);
    }
    while ($sell_currencies = $sell_currencies_from_db->fetch_assoc()) {
        array_push($sell_currency_arr, $sell_currencies['currency_code']);
    }
    foreach ($buy_currency_arr as $index => $buy_currency) {
        $req_url = "https://v6.exchangerate-api.com/v6/$key/latest/$buy_currency";
        $response_json = file_get_contents($req_url);
        $buy_currency_id = $index+1;
        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if('success' === $response->result) {
                    echo "<p>";
                    $date = date("Y-m-d", time());
                    foreach ($sell_currency_arr as $index => $sell_currency) {
                        $sell_currency_id = $index+1;
                        $currency_code = $response->conversion_rates->$sell_currency;
                        $buy_rate  =  $currency_code-($currency_code*0.02);
                        $sell_rate =  $currency_code+($currency_code*0.02);
                        if($buy_currency_id == $sell_currency_id){
                            continue; 
                        }
                        if($date_validate['date'] == $date){
                            update_daily($mysqli, $buy_rate, $sell_rate, $date, $buy_currency_id, $sell_currency_id);
                        } else if(!select_lastdate_record($mysqli)) {
                            add_new_rate($mysqli, $buy_rate, $sell_rate, $date, $buy_currency_id, $sell_currency_id);
                        } else {
                            add_new_rate($mysqli, $buy_rate, $sell_rate, $date, $buy_currency_id, $sell_currency_id);
                        }
                    }
                    echo "</p>";
                }
            }
            catch(Exception $e) {
                echo "Api error";
            }
        }
    }
}





