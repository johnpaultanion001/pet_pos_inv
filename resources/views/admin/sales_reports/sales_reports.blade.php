@extends('../layouts.admin')
@section('sub-title','Sales Reports')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('styles')
<style>

</style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-4">
                                <h4 class="mb-0 text-uppercase" id="titletable">Sales Reports</h4>
                                <b class="mb-0 text-uppercase">{{$title_filter}}</b>
                            </div>
                            <div class="col-md-4">
                                @if(request()->is('admin/sales_reports/fbd/*'))
                                <div class="form-group">
                                   <label for="from">FROM:</label>
                                   <input type="date" name="from" id="from" class="form-control">
                                   <label for="to">TO:</label>
                                   <input type="date" name="to" id="to" class="form-control">
                                   <button class="btn-primary btn btn-sm mt-2 btn_filter_date">SUBMIT</button>
                                </div>
                                @endif

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="filter_dd" id="filter_dd" class="select2" style="width: 100%;">
                                        <option value="fbd" {{ request()->is('admin/sales_reports/fbd/*') ? 'selected' : '' }}>FILTER BY FROM AND TO DATE</option>
                                        <option value="daily" {{ request()->is('admin/sales_reports/daily/*') ? 'selected' : '' }}>DAILY</option>
                                        <option value="weekly" {{ request()->is('admin/sales_reports/weekly/*') ? 'selected' : '' }}>WEEKLY</option>
                                        <option value="monthly" {{ request()->is('admin/sales_reports/monthly/*') ? 'selected' : '' }}>MONTHLY</option>
                                        <option value="yearly" {{ request()->is('admin/sales_reports/yearly/*') ? 'selected' : '' }}>YEARLY</option>
                                        <option value="all" {{ request()->is('admin/sales_reports/all/*') ? 'selected' : '' }}>ALL</option>
                                    </select>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>CUSTOMER</th>
                                    <th>PRODUCT</th>
                                    <th>PRICE</th>
                                    <th>SOLD</th>
                                    <th>DISCOUNTED</th>
                                    <th>AMOUNT</th>
                                    <th>GROSS INCOME</th>
                                    <th>ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold" >
                                @foreach($sales as $order)
                                        <tr>
                                            <td>
                                                {{$order->order->id ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->user->name ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->product->name ?? ''}}
                                                <span class="badge bg-warning">{{$order->promo ?? ''}}</span>
                                            </td>
                                            <td>
                                                {{$order->price ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->qty ?? ''}}
                                            </td>
                                            <td>
                                                {{ number_format($order->discounted ?? '' , 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ number_format($order->amount ?? '' , 2, '.', ',') }}
                                            </td>
                                            @php
                                                $retailed_price = $order->product->retailed_price;
                                                $unit_price = $order->product->unit_price;

                                                $profit = $retailed_price - $unit_price;
                                                $income = $profit * $order->qty;
                                                $income_discount = $income - $order->discounted;
                                            @endphp
                                            <td>
                                                {{ number_format($income_discount ?? '' , 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('M j , Y h:i A') }}
                                            </td>
                                        </tr>       
                                @endforeach
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th>USER:</th>
                                    <th>{{auth()->user()->name}}</th>
                                    <th></th>
                                    <th>TOTAL:</th>
                                    <th>TOTAL SOLD</th>
                                    <th>TOTAL DISCOUNTED</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>TOTAL INCOME</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-2">
                    <div class = "card p-3">
                        <canvas id="salesChart"></canvas>
                    </div>
            </div>
        </div>
    </div>

    

    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script> 


$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);
        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');
        return x1 + x2;
    }

    $('.datatable-table').DataTable({ 
            buttons: dtButtons,
                footerCallback: function (row, data, start, end, display) {
                var api = this.api();
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[^\d.-]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };
                
                sold = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                }, 0);
                discounted = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                }, 0);


                amount = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                }, 0);

                income = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                }, 0);
            
           
                $(api.column(4).footer()).html(number_format(sold, 2,'.', ','));
                $(api.column(5).footer()).html(number_format(discounted, 2,'.', ','));
                $(api.column(6).footer()).html(number_format(amount, 2,'.', ','));
                $(api.column(7).footer()).html(number_format(income, 2,'.', ','));
                
            },
     });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Sales Chart',
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

});

$('#filter_dd').on("change", function(event){
        var date = $(this).val();

        window.location.href = '/admin/sales_reports/'+date+'/'+date+'/'+date;
    
});

$('.btn_filter_date').on("click", function(event){
        var from = $('#from').val();
        var to = $('#to').val();
        if(from == ""){
            alert('From date field is required')
        }else if(to == ""){
            alert('To date field is required')
        }
        else{
            window.location.href = '/admin/sales_reports/fbd/'+from+'/'+to;
        }
});









</script>
@endsection




