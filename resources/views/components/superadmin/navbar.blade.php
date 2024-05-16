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
    <li class="nav-item {{ Request::is('superadmin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.dashboard')}}">
        <i class="fas fa-fw fa-desktop"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('superadmin/useraccount/index') ||  Request::is('superadmin/useraccount/create')? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.useraccount.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span>User Account</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/channel/index') ||  Request::is('superadmin/channel/create')? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.channel.index')}}">
            <i class="fas fa-shopping-cart"></i>
            <span>Channel</span></a>
    </li>
    <li class="nav-item {{ Request::is('superadmin/kategori/index') ||  Request::is('superadmin/kategori/create')? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.kategori.index')}}">
            <i class="fas fa-table"></i>
            <span>Kategori</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/sumber/index') ||  Request::is('superadmin/sumber/create')? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.sumber.index')}}">
            <i class="fa fa-newspaper-o"></i>
            <span>Sumber</span></a>
    </li>


    <li class="nav-item {{ Request::is('superadmin/customer/index') ||  Request::is('superadmin/customer/create')? 'active' : '' }}">
        <a class="nav-link" href="{{route('superadmin.customer.index')}}">
            <i class="fas fa-building"></i>
            <span>Customer</span></a>
    </li>


    <li class="nav-item {{ Request::is('superadmin/supplier/index') ||  Request::is('superadmin/supplier/create')? 'active' : '' }}">
        <a class="nav-link"  href="{{route('superadmin.supplier.index')}}">
            <i  class="fa fa-building-o"></i>
            <span>Supplier</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/produk/index') ||  Request::is('superadmin/produk/create')? 'active' : '' }}">
        <a class="nav-link"  href="{{route('superadmin.produk.index')}}">
            <i class="fa fa-cutlery"></i>
            <span>Product</span></a>
    </li>
    
    <li class="nav-item {{ Request::is('superadmin/rfo/index') ||  Request::is('superadmin/rfo/create')? 'active' : '' }}">
        <a class="nav-link"   href="{{route('superadmin.rfo.index')}}">
      
        <i class="fas fa-list" aria-hidden="true"></i>
            <span>RFO</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/catatan/index') ||  Request::is('superadmin/catatan/create')? 'active' : '' }}">
        <a class="nav-link"   href="{{route('superadmin.catatan.index')}}">
      
        <i class="fa fa-clipboard" aria-hidden="true"></i>
            <span>Catatan Quotation</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/quotation/index') ||  Request::is('superadmin/quotation/create')? 'active' : '' }}">
        <a class="nav-link"   href="{{route('superadmin.quotation.index')}}">
      
        <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>Quotation</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/so/index') ||  Request::is('superadmin/so/showrfo')? 'active' : '' }}">
        <a class="nav-link"   href="{{route('superadmin.so.index')}}">
        <i class="fas fa-shopping-basket" aria-hidden="true"></i>
            <span>Sales Order</span></a>
    </li>

    <li class="nav-item {{ Request::is('superadmin/po/index') ||  Request::is('superadmin/po/showso')? 'active' : '' }}">
        <a class="nav-link"  href="{{route('superadmin.po.index')}}">
        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
            <span>Purchase Order</span></a>
    </li>


    <li class="nav-item {{ Request::is('superadmin/invoice/index') ||  Request::is('superadmin/invoice/showso')? 'active' : '' }}">
        <a class="nav-link"  href="{{route('superadmin.invoice.index')}}">
        <i class="fas fa-file-text" aria-hidden="true"></i>
            <span>Invoice</span></a>
    </li>
<!-- 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Sales Sistem</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            
                <a class="collapse-item" href="utilities-color.html">Form Order</a>
                <a class="collapse-item" href="utilities-border.html">Sales Order</a>
                <a class="collapse-item" href="{{route('superadmin.po.index')}}">Purchase Order</a>
                <a class="collapse-item" href="{{route('superadmin.invoice.index')}}">Invoice</a>
            </div>
        </div>
    </li> -->






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
                <i class="fa fa-bars"></i>
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
                        <a class="dropdown-item" href="{{route('superadminpassword')}}">
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