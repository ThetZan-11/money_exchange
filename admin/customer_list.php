<?php require_once ("../layout/header.php") ?>
<?php require_once ("../layout/sidebar.php") ?>
<?php require_once ("../layout/nav.php") ?>
<?php require_once ("../db/customer_crud.php") ?>
<?php 

if(isset($_GET['deleteId'])){
    delete_customer($mysqli,($_GET['deleteId']));
    echo "<script>location.replace('./customer_list.php')</script>";
}

?>
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
                $customer= get_customer($mysqli);
                // $customers = $customer->fetch_assoc();
                //  var_dump($customer);


                while($customers = $customer->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $customers['name'] ?></td>
                        <td><?= $customers['email'] ?></td>
                        <td><?= $customers['address'] ?></td>
                        <td><?= $customers['ph_no'] ?></td>

                        <td>
                            <a class="btn btn-primary btn-sm" href="./edit_customer.php?id=<?= $customers['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                            <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $customers['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php $i++;} ?>

            </tbody>
        </table>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>