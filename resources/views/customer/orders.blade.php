@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-2" style="
background: #FFD29A;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #BB377D, #FFD29A);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #FFD29A, #FFD29A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h4 class="">ORDERS</h4>
        </div>
    </div>
</header>

<section class="py-5" style="min-height: 70vh;">
<div class="row">
        
        <div class="col-10 mt-3 mx-auto">
            <div class="card card-plain h-100">
                <div class="card-body p-3">
                    <ul class="list-group">
                    @forelse($orders as $order)
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                <div class="avatar me-3">
                                    <img src="/assets/img/products/{{$order->product->image}}" alt="{{$order->product->image}}" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0">{{$order->product->name}}</h6>
                                    <h6 class="mb-0 text-primary">₱ {{ number_format($order->amount ?? '' , 2, '.', ',') }}</h6>
                                    <p class="mb-0 text-xs text-dark font-weight-bold">QTY: {{$order->qty ?? ''}}</p>
                                    <p class="mb-0 text-xs text-dark font-weight-bold">PRICE: {{$order->price ?? ''}}</p>
                                    <p class="mb-0 text-xs text-dark font-weight-bold">DISCOUNTED: {{$order->discounted ?? ''}}</p>
                                    <p class="mb-0 text-xs text-dark font-weight-bold">{{ $order->created_at->format('M j, h:i A') }}</p>
                                 
                                    @if($order->expiration < Carbon\Carbon::now()->addMonths(3))
                                        <div class="badge bg-warning ">{{$order->promo ?? ''}}</div>
                                    @endif
                                    
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-success mb-2 btn-sm edit_order" order_id="{{$order->id}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button> <br>
                                    <button class="btn btn-danger mb-0 btn-sm cancel_order" order_id="{{$order->id}}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </li>
                            <hr>
                    @empty
                            <div class="text-center">
                                <h6 class="mb-0">NO ORDER FOUND</h6>
                            </div>
                    @endforelse
                       
                            <hr>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0">SUBTOTAL</h6>
                                    </div>
                                    <div class="ms-auto text-primary">
                                        ₱ {{ number_format($orders->sum->amount ?? '' , 2, '.', ',') }}
                                    </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0">SHIPPING OPTIONS</h6>
                                    </div>
                                    <div class="ms-auto text-primary">
                                        <div class="form-group">
                                            <select name="shipping_option" id="shipping_option" class="form-control">
                                                <option value="pickUp">Pick Up</option>
                                                <option value="deliver">Deliver (Additional fees required)</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0">TOTAL AMOUNT</h6>
                                    </div>
                                    <div class="ms-auto text-primary">
                                        ₱ {{ number_format($orders->sum->amount ?? '' , 2, '.', ',') }}
                                    </div>
                                </li>

                                <button class="btn-outline-primary btn " id="checkout">CHECK OUT</button>
                       
                    </ul>
                </div>
            
            </div>
        </div>
    </div>
    
</section>

<form method="post" id="myForm">
    @csrf
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
               
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                </button>
    
                </div>
                <div class="modal-body">
                  <div class="col-xl-12">
                    <div class="card row">
                        <div class="col-6 mx-auto">
                            <div class="badge bg-dark text-white position-absolute text-uppercase" id="category" style="top: 0.5rem; right: 5.5rem">Category</div>
                            <div class="badge bg-warning text-white position-absolute text-uppercase" id="promo" style="top: 0.5rem; left: 5.5rem">Promo</div>
                            <!-- Product image-->
                            <img class="card-img-top" id="image" height="250" src="data:image/jpeg;base64,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" alt="IMAGE PRODUCT" />
                        </div>
                       
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder" id="product_name">Product Name</h5>
                                <small class="fw-bolder" id="description">Description</small> <br>
                                <small class="fw-bolder text-danger" id="price">Price: ₱ 150</small> <br>
                                <small class="fw-bolder text-danger" id="stock">Stock: 50</small> <br>
                                <small class="fw-bolder text-danger" id="discounted"></small>

                            </div>
                                <div class="form-group mt-2">
                                  <h6>QTY <span class="text-danger">*</span></h6>
                                  <input type="number" name="qty" id="qty" class="form-control disabled" onfocus="focused(this)" onfocusout="defocused(this)">
                                  <span class="invalid-feedback" role="alert">
                                      <strong id="error-qty"></strong>
                                  </span>
                                </div>
                           
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                    <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="UPDATE"/>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
   
    var order_id = null;
    $(document).on('click', '.edit_order', function(){
        $('#formModal').modal('show');
        $('#myForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
        order_id = $(this).attr('order_id');

        $.ajax({
            url :"/customer/orders/"+order_id+"/edit",
            dataType:"json",
            beforeSend:function(){
                $("#action_button").attr("disabled", true);
                $("#action_button").attr("value", "LOADING..");  
            },
            success:function(data){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "UPDATE");

                $.each(data.order, function(key,value){
                    if(key == 'name'){
                        $('#product_name').text(value)
                    }
                    if(key == 'description'){
                        $('#description').text(value)
                    }
                    if(key == 'price'){
                        $('#price').text(value)
                    }
                    if(key == 'stock'){
                        $('#stock').text(value)
                    }
                    if(key == 'expiration'){
                        $('#expiration').text(value)
                    }
                    if(key == 'category'){
                        $('#category').text(value)
                    }
                    if(key == 'promo'){
                        $('#promo').text(value)
                    }
                    if(key == 'discounted'){
                        $('#discounted').text(value)
                    }

                    

                    if(key == 'image'){
                        $('#image').attr("src", '/assets/img/products/' + value);
                    }
                    if(key == 'qty'){
                        $('#qty').val(value);
                    }

                })
            },
        })
    });

    $('#formModal').on('shown.bs.modal', function () {
        $('#qty').focus();
    });

    $('#myForm').on('submit', function(event){
        event.preventDefault();
        $('.form-control').removeClass('is-invalid')

        $.ajax({
            url :"/customer/orders/"+order_id,
            method:"PUT",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){
                $("#action_button").attr("disabled", true);
                $("#action_button").attr("value", "LOADING..");  
            },
            success:function(data){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "UPDATE");

                if(data.errors){
                    $.each(data.errors, function(key,value){
                        if(key == $('#'+key).attr('id')){
                            $('#'+key).addClass('is-invalid')
                            $('#error-'+key).text(value)
                        }
                    })
                }
                if(data.errorstock){
                    $('#qty').addClass('is-invalid');
                    $('#error-qty').text(data.errorstock);
                }
                if(data.success){
                    $.confirm({
                    title: 'Confirmation',
                    content: data.success,
                    type: 'green',
                    buttons: {
                            confirm: {
                                text: 'Confirm',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.reload();
                                }
                            },
                            
                        }
                    });
                }
               
            },
        });
    });

    $(document).on('click', '.cancel_order', function(){
        var id = $(this).attr('order_id');
        $.confirm({
            title: 'Confirmation',
            content: 'You really want to cancel this order?',
            type: 'red',
            buttons: {
                confirm: {
                    text: 'confirm',
                    btnClass: 'btn-blue',
                    action: function(){
                        return $.ajax({
                            url:"/customer/orders/"+id,
                            method:'DELETE',
                            data: {
                                _token: '{!! csrf_token() !!}',
                            },
                            dataType:"json",
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
                                                    text: 'Confirm',
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
                    }
                },
                cancel:  {
                    text: 'cancel',
                    btnClass: 'btn-red',
                }
            }
        });

    });

    $(document).on('click', '#checkout' , function(){
        $.confirm({
            title: 'Confirmation',
            content: 'Are you sure , you want to check out?',
            type: 'dark',
            buttons: {
                confirm: {
                    text: 'confirm',
                    btnClass: 'btn-blue',
                    action: function(){
                        return $.ajax({
                            url :"/customer/orders/checkout",
                            dataType:"json",
                            method:"get",
                            data: {
                                        _token: '{!! csrf_token() !!}', shipping:$('#shipping_option').val()
                                },
                            beforeSend:function(){
                                $("#checkout").attr("disabled",true);
                                $("#checkout").text("Loading..");  
                            },
                            success:function(data){
                                $("#checkout").attr("disabled",false);
                                $("#checkout").text("CHECKOUT");
                                if(data.no_stock){
                                    $.confirm({
                                        title: 'Confirmation',
                                        content: data.no_stock,
                                        type: 'red',
                                        buttons: {
                                                confirm: {
                                                    text: 'Confirm',
                                                    btnClass: 'btn-blue',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        location.reload();
                                                    }
                                                },
                                        }
                                    });
                                }  
                                if(data.nodata){
                                    $.confirm({
                                        title: 'Confirmation',
                                        content: data.nodata,
                                        type: 'red',
                                        buttons: {
                                                confirm: {
                                                    text: 'Confirm',
                                                    btnClass: 'btn-blue',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        location.reload();
                                                    }
                                                },
                                        }
                                    });
                                }
                                 if(data.no_address){
                                    $.confirm({
                                        title: 'Confirmation',
                                        content: data.no_address,
                                        type: 'red',
                                        buttons: {
                                                confirm: {
                                                    text: 'Confirm',
                                                    btnClass: 'btn-blue',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        window.location.href = "/customer/account";
                                                    }
                                                },
                                        }
                                    });
                                }
                                if(data.success){
                                    $.confirm({
                                        title: 'Confirmation',
                                        content: data.success,
                                        type: 'green',
                                        buttons: {
                                                confirm: {
                                                    text: 'Confirm',
                                                    btnClass: 'btn-blue',
                                                    keys: ['enter', 'shift'],
                                                    action: function(){
                                                        window.location.href = "/customer/orders_history";
                                                    }
                                                },
                                        }
                                    });
                                }
                            }
                        })
                    }
                },
                cancel:  {
                    text: 'cancel',
                    btnClass: 'btn-red',
                }
            }
        });
        
    });
</script>
@endsection






