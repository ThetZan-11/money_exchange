<?php
    require_once '../layout/header.php';
    require_once '../layout/nav.php';
    require_once '../layout/sidebar.php';

    $receipt = show_trades_with_id($mysqli, $_GET['id']);
?>
    <main class="main" id="main">
    <div>
        <button class="btn btn-success my-3 mx-3" onclick="printReceipt()"> 
            Print
        </button>
    </div>

        <div class="card mx-auto" style="width:500px; background-color:#ccd5ae;" id="receipt">
            <div class="card-body mx-auto" style="width:450px">
                
                 <hr>
                <h3 class="text-center">Reciept</h3>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="mt-3">1. Name</div>
                        <div class="mt-3">2. Email</div>
                        <div class="mt-3">5. Buy currency</div>
                        <div class="mt-3">6. Sell currency</div>
                        <div class="mt-3">3. Exchnage amount</div>
                        <div class="mt-3">4. Converted amount</div>
                        <div class="mt-3">7. Date</div>
                    </div>
                    <div>
                        <div class="mt-3"><?= $receipt['name'] ?></div>
                        <div class="mt-3"><?= $receipt['email'] ?></div>
                        <div class="mt-3"><?= $receipt['buy_currency_name'] ?></div>
                        <div class="mt-3"><?= $receipt['sell_currency_name'] ?></div>
                        <div class="mt-3"><?= number_format($receipt['exchange_amount'])." ".$receipt['buy_currency_code'] ?></div>
                        <div class="mt-3"><?= number_format($receipt['converted_amount'])." ".$receipt['sell_currency_code']  ?></div>
                        <div class="mt-3"><?= $receipt['date'] ?></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <div class="mt-3">Total amount</div>
                    </div>
                    <div>
                        <div class="mt-3"><?= number_format($receipt['converted_amount'])." ".$receipt['sell_currency_code'] ?></div>
                    </div>
                </div>
                <hr>
                <h3 class ="text-center">Thank you </h3>
                <hr>
            </div>

        </div>
    </main>
<?php  require_once '../layout/footer.php'; ?>