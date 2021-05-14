// Google

var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function(){
    auth2 = gapi.auth2.init({
        client_id: '605021848293-vn97u72gh2kejpj3ognrr2h1h2o90nbv.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
    });
    attachSignin(document.getElementById('google_login'));
    });
};

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            var profile = googleUser.getBasicProfile();
            var id_token = googleUser.getAuthResponse().id_token;
            $.ajax({
                type: "POST",
                url: "https://monistic-hotel.com/login_checking.php",
                data: {id: profile.getId(), email: profile.getEmail(), surname: profile.getFamilyName(), given_name: profile.getGivenName(), img_url: profile.getImageUrl(), token: id_token},
                success: function (data) {
                    if(data == "OS") {
                        location.reload();
                    }
                },
                error: function () {
                }
            });
        }, function(error) {
        }
    );
}

startApp();

// Facebook

function statusChangeCallback(response) { 
    console.log('statusChangeCallback');
    console.log(response);                   
    if (response.status === 'connected') {   
        loginFB();  
    }
}

//function checkLoginState() {               
    //FB.getLoginStatus(function(response) {  
        //statusChangeCallback(response);
    //});
//}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '466967511177260',
        cookie     : true,                 
        xfbml      : true,                    
        version    : 'v10.0'         
    });


    //FB.getLoginStatus(function(response) {
    //    console.log(response);
        //statusChangeCallback(response);      
    //});
};
 
function loginFB() {                
    //FB.api('/me', {fields: 'email,id'}, function(response) {
    //    console.log('Successful login for: ' + response.id);
    //});
    FB.login(function(response) {

        if (response.authResponse) {
            access_token = response.authResponse.accessToken;
            user_id = response.authResponse.userID;

            FB.api('/me?fields=last_name,first_name,email,id,gender,birthday', function(response) {
                $.ajax({
                    type: "POST",
                    url: "https://monistic-hotel.com/login_checking.php",
                    data: {id: response.id, email: response.email, surname: response.last_name, given_name: response.first_name, img_url: "http://graph.facebook.com/" + response.id + "/picture?type=large", token: access_token},
                    success: function (data) {
                        if(data == "OS") {
                            location.reload();
                        }
                    },
                    error: function () {
                    }
                });
            });

        } else {
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'public_profile,email'
    });
}
