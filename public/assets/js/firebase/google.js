$('#googleLogin').click(function(){

  firebase.auth()
  .signInWithPopup(googleProvider)
  .then((result) => {
    /** @type {firebase.auth.OAuthCredential} */
    var credential = result.credential;

    // This gives you a Google Access Token. You can use it to access the Google API.
    var token = credential.accessToken;
    // The signed-in user info.
    var user = result.user;
    console.log(user)

    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
      url : URL + "/google/login",
      type : "get",
      dataType : "json",
      data : user.providerData[0],
      success : function(data){

        if(data.status == "success"){
          window.location.replace(URL + "/admin/profile");
        }else{
          $('#text_warning').text('Something went wrong');
        }
      },
      error : function (error){
        $('#text_warning').text('Error occured, try again later.');
      }
    })
  }).catch((error) => {
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;
    // The email of the user's account used.
    var email = error.email;
    // The firebase.auth.AuthCredential type that was used.
    var credential = error.credential;
    console.log(error)
    // ...
  });

})