
@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-5" style="
background: #FBD3E9;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #BB377D, #FBD3E9);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #BB377D, #FBD3E9); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">{{ trans('panel.site_title') }}</h1>
            <p class="lead fw-normal text-white-50 mb-0">REGISTER</p>
        </div>
    </div>
</header>

<section class="py-5" style="margin-top: -100px; height: 60vh;">
        <div class="justify-content-center col-lg-7 mx-auto">
           <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                  @csrf
                      <div class="text-center">
                        <img src="assets/img/logo.jfif" alt="logo" width="120" height="120">
                        <br>
                        <br>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-label">Name <span class="text-danger">*</span></label>
                              <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" required autocomplete="name" autofocus>
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                        </div>
                         <div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                         </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                              <input type="number" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}"   required autocomplete="contact_number">
                              @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label">Address <span class="text-danger">*</span></label>
                              <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"   required autocomplete="address">
                              @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"  id="password"  name="password" required autocomplete="new-password" >
                            
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation"  required autocomplete="new-password">
                            </div>
                          </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn bg-primary w-100 my-4 mb-2">REGISTER</button>
                      </div>
                      
                      <p class="mt-4 text-sm text-center">
                        Already a member?
                        <a href="/login" class="text-danger font-weight-bold">LOGIN</a>
                      </p>
                </form>
              </div>
          </div>
        </div>
</section>
@endsection

@section('script')
<script>

</script>
@endsection






