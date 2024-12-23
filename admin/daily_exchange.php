<?php require_once ('../layout/header.php') ?>
<?php require_once ('../layout/nav.php') ?>
<?php require_once('../layout/sidebar.php') ?>
<?php require_once('../db/daily_exchange_crud.php') ?>
<?php require_once('../db/rate.php') ?>

    <main id="main" class="main">
        <div class="container">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Currency Name</th>
                        <th>Sell Rate</th>
                        <th>Buy Rate</th>
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
                            <td><?= $daily_exchange_rate['currency_name']?></td>
                            <td><?= $daily_exchange_rate['sell_rate']?></td>
                            <td><?= $daily_exchange_rate['buy_rate']?></td>
                            <td>
                                <a class="btn btn-primary btn-sm"><i class="fa-solid fa-pen"></i></a>
                                <button class="btn btn-sm btn-danger counterDelete" data-value="" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php $i++; } ?>

                </tbody>
            </table>
        </div>
    </main>

    <?php require_once '../layout/footer.php';
    get_exchange_rate($mysqli); ?>
    