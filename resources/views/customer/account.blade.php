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
            <h4 class="">ACCOUNT</h4>
        </div>
    </div>
</header>

<section class="py-5" style="min-height: 70vh;">
    <div class="row">
        <div class="col-md-8 mt-4 mx-auto">
            <div class="card h-100 mb-4">
                <div class="card-body">
                    <form method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{Auth()->user()->name ?? ''}}">
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-name"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{Auth()->user()->email ?? ''}}">
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-email"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{Auth()->user()->contact_number ?? ''}}">
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-contact_number"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Address (No./Street/City/Province) <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{Auth()->user()->address ?? ''}}">
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-address"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                            <div class="text-center">
                                        <br>
                                        <br>
                                    <button type="submit" name="action_button" id="action_button"  class="btn btn-primary">Update Information</button>
                                        <br>
                                        <br>
                                    <button type="button" class="btn btn-warning" id="btn_change_password">Change Password</button>
                            </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>
    
</section>
<form method="post" id="cpForm">
    @csrf
    <div class="modal fade" id="cpModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
               
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                </button>
    
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <label class="control-label text-uppercase" >Current Password<span class="text-danger">*</span></label>
                    <input type="password" name="current_password" id="current_password" class="form-control"/>
                    <span class="invalid-feedback" role="alert">
                        <strong id="error-current_password"></strong>
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label text-uppercase" >New Password<span class="text-danger">*</span></label>
                    <input type="password" name="new_password" id="new_password" class="form-control" />
                    <span class="invalid-feedback" role="alert">
                        <strong id="error-new_password"></strong>
                    </span>
                </div>
                <div class="form-group">
                    <label class="control-label text-uppercase" >Confirm Password<span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
                    <span class="invalid-feedback" role="alert">
                        <strong id="error-confirm_password"></strong>
                    </span>
                </div>       

                <input type="hidden" name="hidden_id" id="hidden_id" value="{{Auth::user()->id}}" />
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <input type="submit" name="cp_action_button" id="cp_action_button" class="btn  btn-primary" value="UPDATE"/>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
   $(document).on('click', '#btn_change_password', function(){
    $('#cpModal').modal('show');
    $('#cpForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
});

$('#cpForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var id = $('#hidden_id').val();
    var action_url = "/customer/account/change_password/" + id;
    var type = "PUT";

    $.ajax({
        url: action_url,
        method:type,
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
            $("#cp_action_button").attr("disabled", true);
            $("#cp_action_button").attr("value", "LOADING..");
        },
        success:function(data){
          $("#cp_action_button").attr("disabled", false);
          $("#cp_action_button").attr("value", "UPDATE");
            if(data.errors){
                $.each(data.errors, function(key,value){
                if(key == $('#'+key).attr('id')){
                      $('#'+key).addClass('is-invalid')
                      $('#error-'+key).text(value)
                  }
                })
            }
            if(data.success){
                $('.form-control').removeClass('is-invalid');
                $.confirm({
                    title: 'Confirmation',
                    content: data.success,
                    type: 'green',
                    buttons: {
                            confirm: {
                                text: 'STAY LOGGED IN',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.reload();
                                }
                            },
                            cancel:  {
                                text: 'LOGOUT',
                                btnClass: 'btn-red',
                                action: function(){
                                    document.getElementById('logoutform').submit();
                                }
                            }
                        }
                    });
            }
        
        }
    });
});

$('#myForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')

    var action_url = "/customer/account";
    var type = "PUT";

    $.ajax({
        url: action_url,
        method:type,
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
        },
        success:function(data){
            $("#action_button").attr("disabled", false);
          
            if(data.errors){
                $.each(data.errors, function(key,value){
                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                })
            }
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
    });
});
</script>
@endsection






