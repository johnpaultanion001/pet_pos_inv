@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-5" style="
background: #FFD29A;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #BB377D, #FFD29A);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #FFD29A, #FFD29A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">{{ trans('panel.site_title') }}</h1>
            <p class="lead fw-normal text-white-50 mb-0">LOG IN</p>
        </div>
    </div>
</header>

<section class="py-5" style="margin-top: -100px; height: 60vh;">
        <div class="col-xl-6 mx-auto">
           <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                      <div class="text-center">
                        <img src="assets/img/logo.jfif" alt="logo" width="120" height="120">
                      </div>
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        <label class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      <div class="text-center">
                        <button type="submit" class="btn bg-primary w-100 my-4 mb-2">LOGIN</button>
                        <a href="javascript:;" id="googleLogin" class="btn bg-success text-white w-100 my-1 mb-2">
                          LOGIN WITH GMAIL
                        </a>
                      </div>
                      <p class="mt-4 text-sm text-center">
                        Not register?
                        <a href="/register" class="text-danger font-weight-bold">CREATE ACCOUNT</a> <br> <br>
                        <!-- <a href="/password/reset/">FORGOT PASSWORD?</a> -->
                      </p>
                      
                </form>
              </div>
          </div>  
        </div>
</section>
@endsection

@section('script')
<!-- Firebase files -->
<!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js"></script>

<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-firestore.js"></script>
<!-- firebase Conf -->
<script type="text/javascript" src="{{ url('/assets/js/firebase/firebase-conf.js') }}"></script>
<!-- facebook provider -->
<script type="text/javascript" src="{{ url('/assets/js/firebase/facebook.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/firebase/google.js') }}"></script>

<script>

</script>
@endsection






