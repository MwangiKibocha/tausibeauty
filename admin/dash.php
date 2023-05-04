<!-- <div class="admin-sidebar">
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-home"></i>
      <span class="admin-sidebar__text">Home</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-briefcase"></i>
      <span class="admin-sidebar__text">Services</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-calendar-alt"></i>
      <span class="admin-sidebar__text">Appointment</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-user"></i>
      <span class="admin-sidebar__text">Stylists</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-money-bill"></i>
      <span class="admin-sidebar__text">Payment</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-file-alt"></i>
      <span class="admin-sidebar__text">Generate Reports</span>
    </a>
  </div>
  
  <div class="admin-sidebar__box">
    <a href="#" class="admin-sidebar__link">
      <i class="fas fa-user-cog"></i>
      <span class="admin-sidebar__text">Manage Admin</span>
    </a>
  </div>
</div>
<style>
    .admin-sidebar {
  display: flex;
  flex-direction: column;
  width: 200px;
}

.admin-sidebar__box {
  background-color: #ffffff;
  border-radius: 5px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 10px;
  padding: 10px;
  width: 250px;
  background-color: #f5f5f5;
}

.admin-sidebar__link {
  color: #222222;
  display: flex;
  align-items: center;
  text-decoration: none;
}

.admin-sidebar__text {
  margin-left: 10px;
}

</style> -->
<style>
    /* Style for the dashboard menu */
.dashboard-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 100%;
  background-color: #f5f5f5;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

.dashboard-menu ul {
  list-style: none;
  padding: 0;
  margin: 20px 0;
}

.dashboard-menu li {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.dashboard-menu li:last-child {
  border-bottom: none;
}

.dashboard-menu a {
  color: #333;
  text-decoration: none;
}

.dashboard-menu a:hover {
  color: #000;
}

/* Style for the small boxes on the dashboard */
.dashboard-box {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
  padding: 20px;
  margin-bottom: 20px;
  height: 200px;
}

.dashboard-box h3 {
  margin-top: 0;
}

.manage {
  text-align: center;
  margin-top: 10px;
}

</style>
<div class="dashboard-menu">
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">Services</a></li>
    <li><a href="#">Appointments</a></li>
    <li><a href="#">Stylists</a></li>
    <li><a href="#">Payment</a></li>
    <li><a href="#">Generate Reports</a></li>
    <li><a href="#">Manage Admins</a></li>
  </ul>
</div>

<div class="dashboard-content">
  <div class="dashboard-box">
    <h3>Services</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tempor eros euismod ante tristique hendrerit.</p>
    <div class="manage">
      <a href="#">Manage Services</a>
    </div>
  </div>
  
  <div class="dashboard-box">
    <h3>Appointments</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tempor eros euismod ante tristique hendrerit.</p>
    <div class="manage">
      <a href="#">Manage Appointments</a>
    </div>
  </div>
  
  <!-- More dashboard boxes here -->
</div>
