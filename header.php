<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  

        <title>Juxtachoose</title>

        <link rel="stylesheet" href="./css/reset.css" type="text/css" />

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

        <link rel="stylesheet" href="./bootstrap/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="./bootstrap/css/bootstrap-theme.css" type="text/css" />
        <script type='text/javascript' src='./bootstrap/js/bootstrap.js'></script>
        <link rel="stylesheet" href="./css/hover.min.css" type="text/css" />

        <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

        <link rel="stylesheet" href="./css/style.css" type="text/css" />
        <link rel="stylesheet" href="./css/responsive.css" type="text/css" />
        <script src="./js/script.js" type="text/javascript" ></script>
    </head>

    <body>
        <script>
            var fb_user_id, fb_user_name, fb_user_email, fb_user_link;

            var fb_login_event = function(response) {
                if (response.status === 'connected') {
                    window.location.reload();
                }
            }

            var fb_logout_event = function(response) {
                window.location.reload();
            }

            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '723203101128595',
                    xfbml      : true,
                    version    : 'v2.2',
                    status     : true
                });
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        if(window.location.href === window.location.origin + '/login.php'){
                            window.location.assign("welcome.php");
                        }
                        
                        fb_user_id = response.authResponse.userID;
                        var accessToken = response.authResponse.accessToken;
                        FB.api('/me', function(response) {
                            fb_user_name = response.name;
                            if(response.email){
                                fb_user_email = response.email;
                            }
                            if(response.link){
                                fb_user_link = response.link;
                            }
                            // Check browser support
                            if (typeof(Storage) != "undefined") {
                                // Store
                                localStorage.setItem("fb_user_id", fb_user_id);
                                localStorage.setItem("fb_user_name", fb_user_name);
                                localStorage.setItem("fb_user_email", null);
                                localStorage.setItem("fb_user_link", fb_user_link);
                            } else {
                                console.log("Sorry, your browser does not support Web Storage...");
                            }
                        });
                        $('.fb-login .menu-item').show();
                    }
                    else {
                        if(window.location.href != window.location.origin + '/login.php'){
                            window.location.assign("login.php");
                        }
                    }
                });
                // In your onload method:
                FB.Event.subscribe('auth.login', fb_login_event);
                FB.Event.subscribe('auth.logout', fb_logout_event);
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            $(document).ready(function(){
            })
        </script>

        <div class="outer-wrapper">
            <header class="header">
                <a class="juxtachoose-home" href="/">
                    <div class="juxtachoose-img-wrapper"><img class="juxtachoose-img hover-icon-spin" src="./images/juxtachoose.png"></div>
                    <h1 class="juxtachoose-title">Juxtachoose</h1>
                </a>
                <div class="fb-login">
                    <a href="create_poll.php" class="menu-item add-poll hvr-pulse" href=""><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></a>
                    <a href="poll_list.php" class="menu-item view-poll-list hvr-pulse"><i class="glyphicon glyphicon-list-alt"></i></a>
                    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true"></div>
                </div>
            </header>
            <div class="content">
