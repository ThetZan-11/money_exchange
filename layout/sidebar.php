<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="./index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse">
          <i class="bi bi-menu-button-wide"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
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
          <i class="bi bi-menu-button-wide"></i><span>Counter</span><i class="bi bi-chevron-down ms-auto"></i>
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


    </ul>

  </aside>