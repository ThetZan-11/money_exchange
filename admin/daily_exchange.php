<?php require_once ('../layout/header.php') ?>
<?php require_once ('../layout/nav.php') ?>
<?php require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>

    <main id="main" class="main">
        <div class="container">
            <h3>Daily Exchange Rate</h3>
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Currency Name</th>
                        <th>Buy Rate</th>
                        <th>Sell Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $date_now_select = date('Y-m-d');
                    $daily_currency_rates =  show_daily_update($mysqli, $date_now_select);
                    while ($daily_exchange_rate = $daily_currency_rates->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $daily_exchange_rate['pair_name']?></td>
                            <td><?= $daily_exchange_rate['buy_rate']?></td>
                            <td><?= $daily_exchange_rate['sell_rate']?></td>
                        </tr>
                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </main>

    <?php require_once '../layout/footer.php';
    get_exchange_rate($mysqli); ?>
    
    