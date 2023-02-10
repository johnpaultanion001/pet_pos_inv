<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-4 px-lg-5">
        <img class="bi me-2" src="/assets/img/logo.jfif" alt="logo" width="40" height="32">
        <a class="navbar-brand text-primary text-white"  href="/">{{ trans('panel.site_title') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="/">Products</a></li>
                @if(Auth::user())
                    <li class="nav-item"><a class="nav-link {{ request()->is('customer/orders_history') ? 'active' : '' }}" href="/customer/orders_history">Orders History</a></li>
                    
                
                @endif

                @if(Auth::user())
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary text-light" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{Auth()->user()->name}}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form> 
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="/customer/account">Edit Account</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Accounts</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/login">Login</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="/register">Register</a></li>
                        </ul>
                    </li>
                @endif
                
            </ul>
            @php
                $orders =  App\Models\OrderProduct::where('user_id', auth()->user()->id ?? '')
                            ->where('isCheckout', 0)->count();
            @endphp
            @if(Auth::user())
                <a class="btn btn-outline-light m-2" href="/customer/posts">
                    <i class="bi bi-chat-fill me-1"></i>
                    POSTS
                </a>
            @endif
            <a class="btn btn-outline-primary" href="/customer/orders">
                <i class="bi-cart-fill me-1"></i>
                ORDERS
                <span class="badge btn-primary text-white ms-1 rounded-pill">{{$orders ?? '0'}}</span>
            </a>
            @if(Auth::user())
                @if(Auth::user()->role == 'admin')
                <a class="btn btn-outline-success m-2" href="/admin/dashboard">
                        <i class="bi bi-person-square me-1"></i>
                        ADMIN PAGE
                </a>
                @endif
            @endif
        </div>
    </div>
</nav>