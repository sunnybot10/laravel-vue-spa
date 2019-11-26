<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
            <router-link tag="a" to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link tag="a" to="/users" class="nav-link">
                <i class="nav-icon fas fa-glass-cheers"></i>
                <p>Something New</p>
            </router-link>
        </li>

        <!-- New Sidebar Item -->
        <li class="nav-item">
            <router-link tag="a" to="/something-new" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Users</p>
            </router-link>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->