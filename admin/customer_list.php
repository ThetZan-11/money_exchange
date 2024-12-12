<?php require_once ("../db/db.php") ?>
<?php require_once ("../layout/header.php") ?>
<?php require_once ("../layout/sidebar.php") ?>
<?php require_once ("../layout/nav.php") ?>
<?php require_once ("../db/customer_crud.php") ?>


<main id="main" class="main">
    <div class="container">
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $customers = get_customer($mysqli);
                 var_dump($customer);


                while ($customers) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $customers['name'] ?></td>
                        <td><?= $customers['email'] ?></td>
                        <td><?= $customers['address'] ?></td>
                        <td><?= $customers['ph_no'] ?></td>

                        <td>
                            <a class="btn btn-primary btn-sm" href="./add_counter.php"><i class="fa-solid fa-pen"></i></a>
                            <button class="btn btn-sm btn-danger counterDelete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php $i++;
                } ?>

            </tbody>
        </table>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>