@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-2" style="
background: #FBD3E9;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #BB377D, #FBD3E9);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #BB377D, #FBD3E9); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h4 class="">ORDERS HISTORY</h4>
        </div>
    </div>
</header>

<section class="py-5" style="min-height: 70vh;">
    <div class="row">
        <div class="col-md-8 mt-4 mx-auto">
            
            <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0 text-uppercase">Your Pending Orders</h6>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @forelse($orders as $order)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="bi bi-bag-dash-fill"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">
                                                    @foreach($order->orderproducts as $product_order)
                                                        <span class="badge bg-warning">{{$product_order->qty ?? ''}} {{$product_order->product->name ?? ''}} * {{$product_order->price ?? ''}} = {{$product_order->amount ?? ''}}</span>
                                                        @if($product_order->isPromo == '1')
                                                            <span class="badge bg-warning">BUY 1 TAKE 1</span>
                                                        @endif
                                                        <br>
                                                    @endforeach
                                                </h6>
                                                <h6 class="text-xs text-uppercase"> {{ $order->created_at->format('M j , Y h:i A') }}</h6>
                                                
                                                <h6 class="text-s mt-2 text-warning">{{$order->status ?? ''}}</h6>
                                                <hr>
                                                <h6  class="text-s mt-2">SUBTOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2">TOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2 text-uppercase">SHIPPING OPTIONS:   <span class="badge bg-primary"> {{$order->shipping_option}} </span></h6>
                                                <button class="btn btn-danger btn-sm cancel" cancel="{{$order->id}}">CANCEL</button>
                                            </div>
                                        </div>
                                        
                                    </li>
                                    <hr>
                                @empty
                                <div class="text-center">
                                    <h6 class="mb-0">NO PENDING ORDER FOUND</h6>
                                </div>
                                @endforelse
                            </ul>
                    </div>
            </div>
        </div>

        <div class="col-md-8 mt-4 mx-auto">
            
            <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0 text-uppercase">Your Approved Orders</h6>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @forelse($orders_approved as $order)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="bi bi-bag-dash-fill"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">
                                                    @foreach($order->orderproducts as $product_order)
                                                        <span class="badge bg-success">{{$product_order->qty ?? ''}} {{$product_order->product->name ?? ''}} * {{$product_order->price ?? ''}} = {{$product_order->amount ?? ''}}</span> 
                                                        @if($product_order->isPromo == '1')
                                                            <span class="badge bg-warning">BUY 1 TAKE 1</span>
                                                            
                                                        @endif                
                                                        <br> 
                                                        @php
                                                            $isStar = App\Models\Review::where('order_id', $product_order->order_id)->where('product_id', $product_order->product->id)
                                                                                            ->where('user_id', auth()->user()->id)->first();
                                                        @endphp
                                                        <a id="reviews_count{{$product_order->product->id}}" class="link-primary" data-toggle="collapse" href="#collapseExample{{$product_order->product->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                            {{$isStar == null ? 'Add your review':'Edit your review'}}   
                                                        </a>      
                                                         <br>
                                                        <div class="collapse mt-3" id="collapseExample{{$product_order->product->id}}">
                                                            <div class="card card-body text-left">
                                                                <form method="post" class="myReviewForm">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        
                                                                        <i class="bi bi-star-fill m-3 isStar {{$isStar->isStar ?? '' == true ? 'text-warning':''}}" product_id="{{$product_order->product->id}}" id="isStarIcon{{$product_order->product->id}}" style="cursor: pointer;"></i>
                                                                        <input type="hidden" class="form-control" id="isStar{{$product_order->product->id}}" name="isStar"  value="{{$isStar->isStar ?? '0'}}" readonly>
                                                                        <input type="text" class="form-control review" name="review" placeholder="Enter a message" required>
                                                                        <input type="hidden" class="form-control" name="product_id" value="{{$product_order->product->id}}" readonly>
                                                                        <input type="hidden" class="form-control" name="order_id" value="{{$product_order->order_id}}" readonly>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><button  type="submit" class="btn text-primary" style="background-color:transparent;" >SUBMIT</button></span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <div id="review_section{{$product_order->product->id}}" style="max-height: 300px; overflow-y : auto;">
                                                                        @if($product_order->product->reviews()->count() < 1)
                                                                        <hr>
                                                                            <b> NO REVIEW FOUND</b>  <br>
                                                                        @else
                                                                        @foreach($product_order->product->reviews()->get() as $review)
                                                                        <hr>
                                                                            <div class="row">
                                                                                <div class="col-2">
                                                                                    <i class="bi bi-star-fill m-3 {{$review->isStar == true ? 'text-warning':''}}"></i>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <b> {{$review->user->name ?? ''}}</b>  <br>
                                                                                    <h6>{{$review->review ?? ''}}</h6> <br>
                                                                                    <small class="mb-0">{{$review->created_at->diffForHumans()}}</small>
                                                                                </div>
                                                                            </div>
                                                                           
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>                      
                                                    @endforeach
                                                </h6>
                                                <h6 class="text-xs text-uppercase"> {{ $order->created_at->format('M j , Y h:i A') }}</h6>
                                                
                                                <h6 class="text-s mt-2 text-success">{{$order->status ?? ''}}</h6>
                                                <hr>
                                                <h6  class="text-s mt-2">SUBTOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2">TOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2 text-uppercase">SHIPPING OPTIONS:   <span class="badge bg-primary"> {{$order->shipping_option}} </span></h6>
                                               
                                            </div>
                                        </div>
                                        
                                    </li>
                                    <hr>
                                @empty
                                <div class="text-center">
                                    <h6 class="mb-0">NO APPROVED ORDER FOUND</h6>
                                </div>
                                @endforelse
                                
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
                            <!-- Product image-->
                            <img class="card-img-top" id="image" height="250" src="data:image/jpeg;base64,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" alt="IMAGE PRODUCT" />
                        </div>
                       
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder" id="product_name">Product Name</h5>
                               
                            </div>
                                <div class="form-group">
                                    <h6>Select Size <span class="text-danger">*</span></h6>
                                    <div class="btn-group btn-group-toggle" id="sps" data-toggle="buttons">
                                        
                                    </div>
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
    
    $(document).on('click', '.isStar', function(){
        var id = $(this).attr('product_id');
        if($('#isStar'+id).val() == 1){
            $('#isStar'+id).val('0');
            $('#isStarIcon'+id).removeClass('text-warning');
        }else{
            $('#isStar'+id).val('1');
            $('#isStarIcon'+id).addClass('text-warning');
        }
    });

   $(document).on('click', '.cancel', function(){
        var id = $(this).attr('cancel');
        $.confirm({
            title: 'Confirmation',
            content: 'You really want to cancel this order?',
            type: 'red',
            buttons: {
                confirm: {
                    text: 'confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        return $.ajax({
                            url:"/customer/orders/cancel/"+id,
                            method:'post',
                            data: {
                                _token: '{!! csrf_token() !!}',
                            },
                            dataType:"json",
                            beforeSend:function(){
                                $('.cancel').text('Cancelling..');
                                $(".cancel").attr("disabled", true);
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
                    }
                },
                cancel:  {
                    text: 'cancel',
                    btnClass: 'btn-red',
                    keys: ['enter', 'shift'],
                }
            }
        });
    });

    $('.myReviewForm').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url: "/customer/review",
            method:"GET",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){

            },
            success:function(data){
                var reviews = '';
                $.each(data.reviews, function(key,value){
                    reviews += '<hr>';
                    reviews += '<div class="row">';
                        reviews += '<div class="col-2">'
                            if(value.isStar == true){
                                reviews += '<i class="bi bi-star-fill m-3 text-warning"></i>'
                            }else{
                                reviews += '<i class="bi bi-star-fill m-3"></i>'
                            }
                        reviews += '</div>'
                        reviews += '<div class="col-10">'
                            reviews += '<b>'+value.name+'</b> <br>';
                            reviews += '<h6>'+value.review+'</h6> <br>';
                            reviews += '<h6>'+value.date_time+'</h6> <br>';
                        reviews += '</div>'
                    reviews += '</div>';

                    
                                  
                });
                $('#review_section'+data.product_id).empty().append(reviews);
                $('.review').val('');
            }
        });
    });


</script>
@endsection






