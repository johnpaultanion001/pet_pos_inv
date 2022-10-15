@extends('../layouts.admin')
@section('sub-title','Dashboard')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('content')
<div class="container-fluid py-4">
      <div class="row">
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="fas fa-list" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">PRODUCTS FOR TODAY</p>
                <h4 class="mb-0">{{$products_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Product <span class="text-success text-sm font-weight-bolder">{{$products->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">CUSTOMER FOR TODAY</p>
                <h4 class="mb-0">{{$customers_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Customer <span class="text-success text-sm font-weight-bolder">{{$customers->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="fas fa-shopping-cart" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">ORDERS FOR TODAY</p>
                <h4 class="mb-0">{{$orders_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Order <span class="text-success text-sm font-weight-bolder">{{$orders->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-danger shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="fas fa-shopping-cart" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">SALES FOR TODAY</p>
                <h4 class="mb-0">{{ number_format($sales_today ?? '0' , 2, '.', ',') }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Sales <span class="text-success text-sm font-weight-bolder">{{ number_format($sales ?? '0' , 2, '.', ',') }}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mt-3">
          <div class="card">
            <div class="card-body">
            <h4 class="text-sm mb-0 text-capitalize text-primary">3 months before expiration ( {{$exp_label}} )</h4>
                <div class="table-responsive">
                    <table class="table datatable-table display text-center" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Expiration</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase font-weight-bold">
                            @foreach($product_exp as $exp)
                                    <tr>
                                        <td>
                                            {{$exp->id ?? ''}}
                                        </td>
                                        <td>
                                            {{$exp->name ?? ''}}
                                        </td>
                                        <td>
                                            {{ number_format($exp->price ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{$exp->stock ?? ''}}
                                        </td>
                                        <td>
                                          {{ $exp->expiration->format('M j , Y') }}
                                        </td>
                                        <td>
                                            {{ $exp->created_at->format('M j , Y h:i A') }}
                                        </td>
                                    </tr>       
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
   
   
      
    </div>
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script> 
</script>
@endsection




