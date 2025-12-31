 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
         <div class="sidebar-brand-text mx-3">
             <img src="{{asset('assets/img/logo.svg')}}" alt="Tamayaz">
         </div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link Dashboard" href="{{ route('admin.dashboard') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">


     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.category') }}">
             <i class="fas fa-calendar text-gray-400"></i>
             <span> Category</span>
         </a>

     </li>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.service') }}">
             <i class="fas fa-calendar text-gray-400"></i>
             <span> Services</span>
         </a>

     </li>


     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.whychoose') }}">
             <i class="fas fa-calendar text-gray-400"></i>
             <span>why choose</span>
         </a>

     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Addons
     </div>

     <!-- Nav Item - Charts -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.change-password') }}">
             <i class="fas fa-fw fa-table text-gray-400"></i>
             <span>Change Password</span></a>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
             <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
             <span>Logout Admin</span></a>



     </li>


     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

     <!-- Sidebar Message -->


 </ul>
 <!-- End of Sidebar -->