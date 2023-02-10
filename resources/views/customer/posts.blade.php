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
            <h4 class="">Make a post</h4>
        </div>
    </div>
</header>

<section class="py-5" style="min-height: 70vh;">
    <div class="row">
        <div class="col-md-8 mt-4 mx-auto">
            <div class="card h-100 mb-4">
                    <div class="card-body pt-4 p-3">
                        <ul class="list-group">
                            <li class="list-group-item" >
                                <div class="d-flex align-items-center" >
                                    <form method="post" class="myPostForm" style="width:100%;"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="post" placeholder="What's on your mind?" required>
                                            
                                            <div class="input-group-append">
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="input-group-text"><button  type="button" id="attach_file" class="btn text-primary" style="background-color:transparent;" ><i class="bi bi-paperclip text-success" ></i></button></span>
                                                    </div>
                                                    <div class="col">
                                                        <span class="input-group-text"><button  type="submit" class="btn text-primary" style="background-color:transparent;" >Make a post</button></span>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                        <div class="picture-container">
                                            <div class="form-group">
                                                <div class="picture">
                                                    <img src="" class="picture-src" id="wizardPicturePreview" title="" />
                                                    <input type="file" id="wizard-picture" name="image_post" accept="image/*" >
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            @forelse($posts as $post)
                                <li class="list-group-item" style="width: 100%;">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="bi bi-chat-fill me-1"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="text-xs text-uppercase">{{$post->user->name ?? ''}}</h6>
                                            
                                                <h6 class="text-s mt-2">{{$post->post ?? ''}}</h6>

                                                <small class="mb-0">{{$post->created_at->diffForHumans()}}</small>
                                                @if($post->image != null)
                                                <div class="picture">
                                                    <img src="/customer/post/{{$post->image ?? ''}}" class="picture-src"/>
                                                </div>
                                                @endif
                                                <hr>
                                                @if($post->user_id == auth()->user()->id)
                                                    <button class="btn btn-danger mb-0 btn-sm delete_post" post_id="{{$post->id}}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                                <br>
                                                <a id="comment_count{{$post->id}}" class="link-primary" data-toggle="collapse" href="#collapseExample{{$post->id}}" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-chat-fill me-1"></i> {{$post->comments()->count()}}</a>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="collapse mt-3" id="collapseExample{{$post->id}}" style="width: 100%;">
                                                    <div class="card card-body text-left">
                                                        <form method="post" class="myCommentForm" >
                                                            @csrf
                                                            <div class="input-group">

                                                            
                                                                <input type="text" class="form-control comments" name="comment" placeholder="Enter your comment" required>
                                                                <input type="hidden" class="form-control" readonly name="post_id" value="{{$post->id ?? ''}}">
                                                                
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><button  type="submit" class="btn text-primary" style="background-color:transparent;" >SUBMIT</button></span>
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                    
                                                        <div id="comments_section{{$post->id}}">
                                                                @if($post->comments()->count() < 1)
                                                                <hr>
                                                                    <b> NO COMMENT FOUND</b>  <br>
                                                                @else
                                                                @foreach($post->comments()->get() as $comment)
                                                                <hr>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <b> {{$comment->user->name ?? ''}}</b> 
                                                                                @if($comment->user_id == auth()->user()->id)
                                                                                    <button class="btn btn-link mb-0 btn-sm text-danger delete_comment" comment_id="{{$comment->id}}">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button> 
                                                                                @endif
                                                                            <br>
                                                                            <h6>{{$comment->comment ?? ''}}</h6> <br>
                                                                            <small class="mb-0">{{$comment->created_at->diffForHumans()}}</small>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                        </div>
                                
                                </li>

                                <hr>
                            @empty
                            <div class="text-center">
                                <br><br>
                                <h6 class="mb-0">NO POST FOUND</h6>
                            </div>
                            @endforelse
                        </ul>
                    </div>
            </div>
        </div>

    </div>
    
</section>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(".picture-container").hide();
    });
    $("#wizard-picture").change(function(){
        readURL(this);
    });
    $("#attach_file").click(function(){
        $("#wizard-picture").click();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
            $(".picture-container").show();
        }
    }
    
     $('.myCommentForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: "/customer/comments",
            method:"GET",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){

            },
            success:function(data){
                var comments = '';
                $.each(data.comments, function(key,value){
                    comments += '<hr>';
                    comments += '<div class="row">';
                        comments += '<div class="col-12">'
                            comments += '<b>'+value.name+'</b> <br>';
                            comments += '<h6>'+value.comment+'</h6> <br>';
                            comments += '<h6>'+value.date_time+'</h6> <br>';
                        comments += '</div>'
                    comments += '</div>';
                });
                $('#comments_section'+data.post_id).empty().append(comments);
                $('.comments').val('');
                $('#comment_count'+data.post_id).html('<i class="bi bi-chat-fill me-1"></i> '+data.comment_counts)
            }
        });
    });

    $('.myPostForm').on('submit', function(event){
            event.preventDefault();
            var action_url = "/customer/posts_store";
            var type = "POST";

            $.ajax({
                url: action_url,
                method:type,
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData: false,

                dataType:"json",
                beforeSend:function(){
                },
                success:function(data){
                if(data.success){
                        $.confirm({
                            title: data.success,
                            content: "",
                            type: 'green',
                            buttons: {
                                confirm: {
                                    text: '',
                                    btnClass: 'btn-green',
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

        $(document).on('click', '.delete_post', function(){
            var id = $(this).attr('post_id');
            $.confirm({
                title: 'Confirmation',
                content: 'You really want to delete this post?',
                type: 'red',
                buttons: {
                    confirm: {
                        text: 'confirm',
                        btnClass: 'btn-blue',
                        action: function(){
                            return $.ajax({
                                url:"/customer/posts/"+id,
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
        

        $(document).on('click', '.delete_comment', function(){
            var id = $(this).attr('comment_id');
            $.confirm({
                title: 'Confirmation',
                content: 'You really want to delete this comment?',
                type: 'red',
                buttons: {
                    confirm: {
                        text: 'confirm',
                        btnClass: 'btn-blue',
                        action: function(){
                            return $.ajax({
                                url:"/customer/comments/"+id,
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
        

</script>
@endsection






