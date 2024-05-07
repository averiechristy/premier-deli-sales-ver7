<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:#9B5718;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mt-3 mb-3" >
        <div class="sidebar-brand-icon ">
        <img src="{{asset('img/logopremier.png')}}" style="height: 120px;">
        </div>
        
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admininvoice/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admininvoice.dashboard')}}" >
        <i class="fas fa-fw fa-desktop"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <!-- <li class="nav-item {{ Request::is('admininvoice/customer/index') || Request::is('admininvoice/customer/create')  ? 'active' : '' }}">
        <a class="nav-link"  href="{{route('admininvoice.customer.index')}}">
        <i class="fas fa-fw fa-building"></i>
            <span>Customer</span></a>
    </li> -->

    
    <li class="nav-item {{ Request::is('admininvoice/rfo/index')  ? 'active' : '' }}">
        <a class="nav-link"  href="{{route('admininvoice.rfo.index')}}">
      
        <i class="fa fa-list" aria-hidden="true"></i>
            <span>List RFO</span></a>
    </li>

    <li class="nav-item {{ Request::is('admininvoice/so/index') || Request::is('/admininvoice/so/create/{id}')|| Request::is('admininvoice/so/showrfo')  ? 'active' : '' }}">
        <a class="nav-link"   href="{{route('admininvoice.so.index')}}">
        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
            <span>Sales Order</span></a>
    </li>

    <li class="nav-item {{ Request::is('admininvoice/po/index') || Request::is('/admininvoice/po/create/{id}')|| Request::is('admininvoice/po/showso')  ? 'active' : '' }}">
        <a class="nav-link"  href="{{route('admininvoice.po.index')}}">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>Purchase Order</span></a>
    </li>


    <li class="nav-item {{ Request::is('admininvoice/invoice/index') || Request::is('/admininvoice/invoice/create/{id}') || Request::is('admininvoice/invoice/showso') ? 'active' : '' }}">
        <a class="nav-link"  href="{{route('admininvoice.invoice.index')}}">
        <i class="fa fa-file-text" aria-hidden="true"></i>
            <span>Invoice</span></a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
   

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fas fa-bars"></i>
            </button>

           
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              


                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, {{ auth()->user()->nama }}</span>
                        <img class="img-profile rounded-circle"
                            src="{{asset('img/undraw_profile.svg')}}">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{route('password')}}">
                            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                            Change Password
                        </a>
                      
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>

        <style>
            .nav-link .fas,
.nav-link .fa {
    width: 20px; /* Sesuaikan lebar ikon */
}

.nav-link span {
    margin-left: 1px; /* Sesuaikan jarak antara ikon dan teks */
}
        </style>

        <!-- End of Topbar -->