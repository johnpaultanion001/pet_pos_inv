@extends('../layouts.admin')
@section('sub-title','Dashboard')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

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
          <div class = "row">
                  <div class="col-md-6 p-3 pt-3" >
                    <div class = "card p-3">
                      <canvas id="salesChart"></canvas>
                    </div>
                  </div>
                  <div class="col-md-6 p-3 pt-3">
                        <div class="card p-3">
                            <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
                        </div>
                  </div>
            </div>
            <div class = "row">
                  <div class="col-md-6 p-3 pt-3" >
                    <div class = "card p-3">
                      <canvas id="soldChart"></canvas>
                    </div>
                  </div>
                  <div class="col-md-6  p-3 pt-3">
                  <div class="card" style="height: 300px;">
                    <div class="card-body">
                    <h4 class="text-sm mb-0 text-capitalize text-primary">Lower stock less than 5 (Updated as of {{date('M j , Y h:i A')}}) </h4>
                        <div class="table-responsive">
                            <table class="table datatable-table display text-center" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Retailed Price</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase font-weight-bold">
                                    @foreach($lower_stock as $exp)
                                            <tr>
                                                <td>
                                                    {{$exp->id ?? ''}}
                                                </td>
                                                <td>
                                                    {{$exp->name ?? ''}}
                                                </td>
                                                <td>
                                                    {{ number_format($exp->retailed_price ?? '' , 2, '.', ',') }}
                                                </td>
                                                <td>
                                                    {{$exp->stock ?? ''}}
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
                                <th>Retailed Price</th>
                                <th>Stock</th>
                                <th>Promo</th>
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
                                            {{ number_format($exp->retailed_price ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{$exp->stock ?? ''}}
                                        </td>
                                        <td>
                                          @if($exp->expiration < Carbon\Carbon::now()->addMonths(3))
                                              <div class="badge bg-warning text-white position-absolute text-uppercase">25 % OFF</div>
                                          @endif

                                          @if($exp->expiration < Carbon\Carbon::now()->addMonths(2))
                                              <div class="badge bg-warning text-white position-absolute text-uppercase">35 % OFF</div>
                                          @endif

                                          @if($exp->expiration < Carbon\Carbon::now()->addMonths(1))
                                              <div class="badge bg-warning text-white position-absolute text-uppercase">45 % OFF</div>
                                          @endif
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
<script src="{{ asset('js/chart.js') }}"></script>
<script> 
  var xValues = ["APPROVED", "PENDING"];
  var yValues = [{{$status_approved}},{{$status_pending}}];
  var barColors = [
    "#b91d47",
    "#00aba9"
  ];

new Chart("myChart1", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Status of Delivery"
    }
  }
});

var ctx = document.getElementById('salesChart').getContext('2d');
var salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Monthly Sales',
            data: @json($data),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

var ctx = document.getElementById('soldChart').getContext('2d');
var salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($labels_sold),
        datasets: [{
            label: 'Sold',
            data: @json($data_sold),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

console.log($recordSolds);
  
</script>
@endsection




