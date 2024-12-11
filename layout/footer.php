<div id="deleteModal" class="modal fade modal-sm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"><h5>Are you Sure?</h5></div>
                <button class="btn-close" data-bs-dismiss="modal" id="close"></button>
            </div>
            <div class="modal-body">
                Do you wanna delete?
            </div>
            <div class="modal-footer">
                <button id="confirmDelete" class="btn btn-danger">Delete</button>
                <button  class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  

  
</body>

<script>
  let deleteBtn =$(".counterDelete");
  let close = $("#close");
  deleteBtn.on("click" , (c) =>{
    deleteKey = c.currentTarget.getAttribute("data-value");
    console.log(deleteKey);
  })
 
 $("#confirmDelete").on("click" , ()=> {
  location.replace("?deleteId="+ deleteKey);

 })
</script>

</html>