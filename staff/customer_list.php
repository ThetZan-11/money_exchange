<?php require_once ("../layout/header.php") ?>
<?php require_once ("../layout/sidebar.php") ?>
<?php require_once ("../layout/nav.php") ?>

<?php 

if(isset($_GET['deleteId'])){
    delete_customer($mysqli,($_GET['deleteId']));
    echo "<script>location.replace('./customer_list.php')</script>";
}

?>
<main id="main" class="main">
    <div class="container">
        <h3 class ="title">Customer List</h3>
    <div style="width:100%; height:55px;" class="mt-3" id="success-message">
        <?php if (isset($_GET['edit_success'])) { ?>
            <p class="alert alert-success"><?= $_GET['edit_success'] ?></p>    
        <?php } else if(isset($_GET['add_success'])){ ?>
            <p class="alert alert-success"><?= $_GET['add_success'] ?></p>
        <?php } else if(!isset($_GET['edit_success']) && !isset($_GET['add_success'])){ ?>
            <p></p>
        <?php } ?> 
     </div>
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
                if(isset($_POST['key']) && $_POST['key'] != ''){
                    $key = $_POST['key'];
                    $customer =  search_query_for_customer($mysqli, $key);
                } else {
                    $customer= get_customer($mysqli);
                }

                while($customers = $customer->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $customers['name'] ?></td>
                        <td><?= $customers['email'] ?></td>
                        <td><?= $customers['address'] ?></td>
                        <td><?= $customers['ph_no'] ?></td>

                        <td>
                            <a class="btn btn-primary btn-sm" href="./add_customer.php?id=<?= $customers['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                            <button class="btn btn-sm btn-danger counterDelete" data-value="<?= $customers['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php $i++;} ?>

            </tbody>
        </table>
    </div>

</main>
<?php require_once '../layout/footer.php' ?>