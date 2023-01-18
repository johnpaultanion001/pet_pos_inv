@extends('../layouts.admin')
@section('sub-title','Orders')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Orders</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="/" class="text-uppercase create_record btn btn-sm btn-primary">New Order</a>
                               
                            </div> 
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ORDER ID</th>
                                    <th scope="col">SHIPPING OPTION</th>
                                    <th scope="col">CUSTOMER NAME</th>
                                    <th scope="col">PRODUCT BUY</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($orders as $order)
                                    <tr>
                                       
                                        <td>
                                            <button type="button" name="status" status="{{  $order->id ?? '' }}" 
                                                class="btn btn-sm 
                                                @if($order->status == 'PENDING')
                                                    btn-warning status
                                                @elseif($order->status == 'APPROVED')
                                                    btn-success status
                                                @else 
                                                    btn-danger
                                                @endif">
                                                {{$order->status}}
                                            </button>
                                        </td>
                                        <td>
                                            {{  $order->id ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{  $order->shipping_option ?? '' }}</span>
                                        </td>
                                        <td>
                                            {{  $order->user->name ?? '' }}
                                        </td>
                                        <td>
                                         
                                            @foreach($order->orderproducts as $product_order)
                                                <span class="badge bg-success">{{$product_order->qty}} {{$product_order->product->name}} * {{$product_order->price}} = {{ number_format($product_order->amount ?? '' , 2, '.', ',') }} </span>
                                                @if($product_order->isPromo == '1')
                                                    <span class="badge bg-warning">BUY 1 TAKE 1</span>
                                                @endif    
                                                <br>
                                            @endforeach
                                            
                                            
                                        </td>
                                        <td>
                                            <span class="text-success">₱ </span> {{ number_format($order->orderproducts->sum('amount') ?? '' , 2, '.', ',') }} 
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('M j , Y h:i A') }}
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

    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title-receipt">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>
        
                    </div>
                    <div class="modal-body">
                        <div id="receipt_data">

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        <button type="button" class="btn btn-primary" id="btn_print">Print</button>
                        
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
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
        pageLength: 100,
        });

        $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
            });
    });

$(document).on('click', '.status', function(){
    
    var id = $(this).attr('status');
    $.ajax({
        url :"/admin/orders/status/"+id,
        dataType:"json",
        method: 'put',
        data: { _token: '{!! csrf_token() !!}'},
        beforeSend:function(){
          
        },
        success:function(data){
            if(data.success){
                $.confirm({
                title: 'Confirmation',
                content: data.success,
                type: 'green',
                buttons: {
                        confirm: {
                            text: 'confirm',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function(){
                                location.reload();
                            }
                        },
                        
                    }
                });
            }
        }
    })
});


</script>
@endsection




