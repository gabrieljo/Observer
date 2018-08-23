<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Observer | 로그인
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="/application/views/web/css/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/application/views/web/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="/application/views/web/img/favicon.ico" />
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--singin" id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        <div class="m-login__logo">
                            <a href="/">
                                <img src="/application/views/web/assets/app/media/img/logos/observer.png">
                            </a>
                        </div>
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Sign In To Observer Service
                                </h3>
                            </div>
                            <form class="m-login__form m-form" method="POST" action="/web_act/login">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="ID" name="id" autocomplete="off">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="m-login__form-action">
                                    <input type="submit" value="Sign In" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(/application/views/web/assets/app/media/img//bg/bg-4.jpg)">
            <div class="m-grid__item m-grid__item--middle">
                <h3 class="m-login__welcome">
                    Make Your observer
                </h3>
                <p class="m-login__msg">
                    We Are Flying Above Your Competitors
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->

</body>
<!-- end::Body -->
</html>

