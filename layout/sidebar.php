<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="./index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->
      <?php 
        if($user['role'] == 1){  ?>
          <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse">
          <i class="bi bi-people"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="./add_user.php">
                <i class="bi bi-circle"></i><span>Add User</span>
              </a>
            </li>
            <li>
              <a href="./user_list.php">
                <i class="bi bi-circle"></i><span>User List</span>
              </a>
            </li>
          </ul>
        </li>
  
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-counter" data-bs-toggle="collapse">
          <i class="bi bi-shop"></i><span>Counter</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-counter" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./add_counter.php">
                <i class="bi bi-circle"></i><span>Add Counter</span>
              </a>
            </li>
            <li>
              <a href="./counter_list.php">
                <i class="bi bi-circle"></i><span>Counter List</span>
              </a>
            </li>
          </ul>
        </li>
      
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-customer" data-bs-toggle="collapse">
          <i class="bi bi-person-vcard-fill"></i><span>Customer</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-customer" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./edit_customer.php">
                <i class="bi bi-circle"></i><span>Edit Customer</span>
              </a>
            </li>
            <li>
              <a href="./customer_list.php">
                <i class="bi bi-circle"></i><span>Customer List</span>
              </a>
            </li>
          </ul>
        </li>
  
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-currency" data-bs-toggle="collapse">
          <i class="bi bi-cash-coin"></i><span>Currency</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-currency" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./add_currency.php">
                <i class="bi bi-circle"></i><span>Add Currency</span>
              </a>
            </li>
            <li>
              <a href="./currency_list.php">
                <i class="bi bi-circle"></i><span>Currency List</span>
              </a>
            </li>
          </ul>
        </li>
  
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-duty" data-bs-toggle="collapse">
          <i class="bi bi-calendar-check"></i><span>Duty</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-duty" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./add_duty.php">
                <i class="bi bi-circle"></i><span>Add Duty</span>
              </a>
            </li>
            <li>
              <a href="./duty_list.php">
                <i class="bi bi-circle"></i><span>Duty Schedule</span>
              </a>
            </li>
          </ul>
        </li>
  
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-counterManagement" data-bs-toggle="collapse">
          <i class="bi bi-briefcase-fill"></i><span>Counter Manage</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-counterManagement" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./manage_counter.php">
                <i class="bi bi-circle"></i><span>Manage Counter</span>
              </a>
            </li>
            <li>
              <a href="./counter_detail_list.php">
                <i class="bi bi-circle"></i><span>Counter Detail List</span>
              </a>
            </li>
          </ul>
        </li>
  
        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-dailyExchange" data-bs-toggle="collapse">
          <i class="bi bi-currency-exchange"></i><span>Daily Money Exchange</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-dailyExchange" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./daily_exchange.php">
                <i class="bi bi-circle"></i><span>Daily Money Exchange</span>
              </a>
            </li>
            <li>
              <a href="./calculate_exchange.php">
                <i class="bi bi-circle"></i><span>Calculate Exchange</span>
              </a>
            </li>
          </ul>
        </li>

        <?php } else if($user['role'] == 2) { ?>
          <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#components-dailyExchange" data-bs-toggle="collapse">
          <i class="bi bi-currency-exchange"></i><span>Daily Money Exchange</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-dailyExchange" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="./daily_exchange.php">
                <i class="bi bi-circle"></i><span>Daily Money Exchange</span>
              </a>
            </li>
            <li>
              <a href="./calculate_exchange.php">
                <i class="bi bi-circle"></i><span>Calculate Exchange</span>
              </a>
            </li>
          </ul>
        </li>

             <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#components-customer" data-bs-toggle="collapse">
             <i class="bi bi-currency-exchange"></i><span>Customer</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="components-customer" class="nav-content collapse" data-bs-parent="#sidebar-nav">
               <li>
                 <a href="./add_customer.php">
                   <i class="bi bi-circle"></i><span>Add Customer</span>
                 </a>
               </li>
               <li>
                 <a href="./customer_list.php">
                   <i class="bi bi-circle"></i><span>Customer List</span>
                 </a>
               </li>
             </ul>
           </li>


           <?php }
         ?>
   

    </ul>

  </aside>