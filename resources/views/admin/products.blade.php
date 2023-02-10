@extends('../layouts.admin')
@section('sub-title','Inventories')
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
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Products</h4>
                            </div>
                            <div class="col-md-2">
                                <button type="button" name="create_record" id="create_record" class="text-uppercase create_record btn btn-sm btn-primary">New Product</button>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="category_dd" id="category_dd" class="select2" style="width: 100%;">
                                        <option value="">FILTER CATEGORY</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>    
                        
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ACTIONS</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">IMAGE</th>
                                    <th  scope="col">CATEGORY</th>
                                    
                                    <th scope="col">NAME</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">EXPIRATION</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col">UNIT PRICE</th>
                                    <th scope="col">RETAILED PRICE</th>
                                    <th scope="col">CREATED AT</th>
                                </tr>
                            </thead>
                            
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <button type="button" name="edit" edit="{{  $product->id ?? '' }}"  class="edit btn btn-sm btn-success btn-wd">Edit</button>
                                            
                                        </td>
                                        <td>
                                            {{  $product->id ?? '' }}
                                        </td>
                                        <td>
                                            <img style="vertical-align: bottom;"  height="100" width="100" src="{{URL::asset('/assets/img/products/'.$product->image)}}" />
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{  $product->category->name ?? '' }}</span>
                                        </td>
                                       
                                        <td>
                                            {{  $product->name ?? '' }}
                                        </td>
                                        <td>
                                            {{\Illuminate\Support\Str::limit($product->description,50)}}
                                        </td>
                                        <td>
                                            {{ $product->expiration->format('M j , Y') }}
                                        </td>
                                        <td>
                                            {{ $product->stock ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->unit_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->retailed_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->created_at->format('M j , Y h:i A') }}
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

    <form method="post" id="myForm" class="contact-form">
        @csrf
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>
        
                    </div>
                    <div class="modal-body row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                
                                <label class="form-label">Name: <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-name"></strong>
                                </span>
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Category: <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="select2 form-control" style="width: 100%; ">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Expiration: </label>
                                <input type="date" name="expiration" id="expiration" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-expiration"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Stock: </label>
                                <input type="number" name="stock" id="stock" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-stock"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Unit Price: </label>
                                <input type="number" name="unit_price" id="unit_price" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit_price"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Retailed Price: </label>
                                <input type="number" name="retailed_price" id="retailed_price" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-retailed_price"></strong>
                                </span>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Description: </label>
                                <input type="text" name="description" id="description" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-description"></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group" id="image-section">
                                <label class="form-label">Image: <span class="text-danger">*</span></label>
                                <div class="input-group input-group-outline my-3">
                                <input type="file" name="image" class="form-control image" accept="image/*" >
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-image"></strong>
                                    </span>
                                </div>
                            </div>
                                
                            <div class="current_img pt-4">
                                <div class="row">
                                    <div class="col-6">
                                    <br>
                                    <br>
                                    <br>
                                            <small>Current Image:</small>
                                    </div>
                                    <div class="col-6">
                                            <img style="vertical-align: bottom;" id="current_image"  height="100" width="100" src="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="Save" />
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    'columnDefs': [{ 'orderable': false, 'targets': 0 }],
    });

    var table = $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

    $('.select2').select2();

    $('#category_dd').on('change', function () {
      table.columns(3).search( this.value ).draw();
    });

    });

$(document).on('click', '#create_record', function(){
    $('#formModal').modal('show');
    $('#myForm')[0].reset();
    $('.form-control').removeClass('is-invalid')
    $('.modal-title').text('Add Product');
    $('#action_button').val('Submit');
    $('#action').val('Add');
    $('.current_img').hide();  
    $('.input-group').removeClass('is-filled');
    $('#added_section').hide();
    $('#image-section').show();
    $('.disabled').attr('readonly', false);
    $('#category').attr('disabled', false);
});

$('#myForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var action_url = "{{ route('admin.products.store') }}";
    var type = "POST";

    if($('#action').val() == 'Edit'){
        var id = $('#hidden_id').val();
        action_url = "products/update/" + id;
        type = "POST";
    }

    $.ajax({
        url: action_url,
        method:type,
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
            $("#action_button").attr("value", "Loading..");
        },
        success:function(data){
            if($('#action').val() == 'Edit'){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "Update");
            }else{
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "Submit");
            }
            if(data.errors){
                $.each(data.errors, function(key,value){
                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                    if(key == 'image'){
                        $('.image').addClass('is-invalid')
                        $('#error-image').text(value)
                    }
                })
            }
            if(data.success){
                $('.form-control').removeClass('is-invalid')
                $('#myForm')[0].reset();
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
                $('#formModal').modal('hide');
            }
            
        }
    });
});

$(document).on('click', '.edit', function(){
    $('#formModal').modal('show');
    $('.modal-title').text('Edit Prorduct');
    $('#myForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
    $('.input-group').addClass('is-filled');
    $('.current_img').show();
    $('.disabled').attr('readonly', false);
    $('#category').attr('disabled', false);
    $('#added_section').hide();
    $('#image-section').show();
    var id = $(this).attr('edit');

    $.ajax({
        url :"/admin/products/"+id+"/edit",
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
            $("#action_button").attr("value", "Loading..");  
        },
        success:function(data){
            if($('#action').val() == 'Edit'){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "Update");
            }else{
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "Submit");
            }
            $.each(data.result, function(key,value){
                if(key == $('#'+key).attr('id')){
                    $('#'+key).val(value)
                }
                if(key == 'category_id'){
                    $("#category").select2("trigger", "select", {
                        data: { id: value }
                    });
                }
                if(key == 'image'){
                    $('#current_image').attr("src", '/assets/img/products/'  + value);
                }
                if(key == 'expiration'){
                    var exp = moment(value).format('YYYY-MM-DD');
                    $("#expiration").val(exp);
                }
            })
            $('#hidden_id').val(id);
            $('#action_button').val('Update');
            $('#action').val('Edit');
        }
    })
});

$(document).on('click', '.remove', function(){
  var id = $(this).attr('remove');
  $.confirm({
      title: 'Confirmation',
      content: 'You really want to remove this record?',
      type: 'red',
      buttons: {
          confirm: {
              text: 'confirm',
              btnClass: 'btn-blue',
              keys: ['enter', 'shift'],
              action: function(){
                  return $.ajax({
                      url:"products/"+id,
                      method:'DELETE',
                      data: {
                          _token: '{!! csrf_token() !!}',
                      },
                      dataType:"json",
                      beforeSend:function(){
                        $('#titletable').text('Loading...');
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



$('#formModal').on('shown.bs.modal', function () {
    $('#added_stock').focus();
})  





</script>
@endsection




