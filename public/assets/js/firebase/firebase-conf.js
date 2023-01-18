 // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyBoeXhwvnY15QrO6NR1l2OHkcu0sKQVuM0",
    authDomain: "laravel-auth-dbbde.firebaseapp.com",
    databaseURL: "https://laravel-auth-dbbde-default-rtdb.firebaseio.com",
    projectId: "laravel-auth-dbbde",
    storageBucket: "laravel-auth-dbbde.appspot.com",
    messagingSenderId: "707417006271",
    appId: "1:707417006271:web:04a89ac0d4f805f40da60a",
    measurementId: "G-R58PTYDVPV"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  var URL = $('meta[name="baseURL"]').attr('content');

  console.log("Firebase started.");

  // Facebook
  var facebookProvider = new firebase.auth.FacebookAuthProvider();

  var googleProvider = new firebase.auth.GoogleAuthProvider();
