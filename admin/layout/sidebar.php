 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="./admins.php">
          <i class="bi bi-circle"></i><span>Admins</span>
        </a>
      </li>
      <li>
        <a href="./add_admin.php">
          <i class="bi bi-circle"></i><span>Add Admin</span>
        </a>
      </li>
      <li>
        <a href="./customers.php">
          <i class="bi bi-circle"></i><span>Customers</span>
        </a>
      </li>
    </ul>
  </li><!-- End Components Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Space Types</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="./space_type_list.php">
          <i class="bi bi-circle"></i><span>Space Type List</span>
        </a>
      </li>
      <li>
        <a href="space_type_register.php">
          <i class="bi bi-circle"></i><span>Space Type Registeration</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Locations</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="./location_list.php">
          <i class="bi bi-circle"></i><span>Location List</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-bar-chart"></i><span>Parking Spaces</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="./parking_space_list.php">
          <i class="bi bi-circle"></i><span>Parking Space List</span>
        </a>
      </li>
      <li>
        <a href="./parking_space_register.php">
          <i class="bi bi-circle"></i><span>Parking Space Register</span>
        </a>
      </li>
    </ul>
  </li><!-- End Charts Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="./booking.php">
      <i class="fa-solid fa-table-list"></i>
      <span>Booking</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="placement.php">
      <i class="bi bi-question-circle"></i>
      <span>Make A Placement</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

</ul>

</aside><!-- End Sidebar-->