<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="/admin/dashboard">
      <img class="bi me-2" src="/assets/img/logo.jfif" alt="logo" width="40" height="32">
      <span class="text-white h5">{{ trans('panel.site_title') }}</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'bg-gradient-primary' : '' }}" href="{{ route("admin.dashboard") }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'bg-gradient-primary' : '' }}" href="{{ route("admin.products.index") }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-list" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Inventories</span>
        </a>
      </li>
      

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('admin/orders') || request()->is('admin/orders/*') ? 'bg-gradient-primary' : '' }}" href="{{ route("admin.orders") }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-shopping-cart" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'bg-gradient-primary' : '' }}" href="{{ route("admin.categories.index") }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tag" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('admin/customer_list') || request()->is('admin/customer_list/*') ? 'bg-gradient-primary' : '' }}" href="{{ route("admin.customer") }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Customers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') ? 'bg-gradient-primary' : '' }}" href="/admin/sales_reports/daily">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-list" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Sales Reports</span>
        </a>
      </li>
  
   
    </ul>
  </div>

</aside>