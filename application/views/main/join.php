<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Observer | 회원가입</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="/application/views/web/img/favicon.ico" />

    <!-- Bootstrap -->
    <link href="/application/views/main/css/bootstrap.min.css" rel="stylesheet">
    <!-- Themify Icons -->
    <link href="/application/views/main/assets/themify-icons/themify-icons.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="/application/views/main/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="/application/views/main/css/style.css" rel="stylesheet">
    <!-- Color CSS -->
    <link id="main" href="/application/views/main/css/color_01.css" rel="stylesheet">
    <link id="theme" href="/application/views/main/css/color_01.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/php5shiv/3.7.3/php5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-login">
<!-- ==============================================
             **PRE LOADER**
=============================================== -->
<div id="page-loader">
    <div class="loader-container">
        <div class="loader-logo">
            <span>LOADING</span>
        </div>
        <div class="loader"></div>
    </div>
</div>
<!-- ==============================================
             **SIGNUP**
=============================================== -->
<div class="container">
    <div class="section_login">
        <div class="row section_row-sm-offset-3">
            <div class="ptb-50 text-center">
                <a href="/"><img src="/application/views/web/assets/app/media/img/logos/observer.png" alt=""></a>
            </div>
            <h3 class="section_authTitle">회원가입</h3>
        </div>


        <div class="row section_row-sm-offset-3">
            <div class="col-xs-12 col-sm-6">
                <form name="join_form" class="section_loginForm" action="/main_act/join" method="POST">
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-star"></i></span>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="업체명">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-user"></i></span>
                        <input type="email" class="form-control" id="id" name="id" placeholder="아이디" onkeydown="fn_press_han(this);" style="ime-mode:disabled;">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-lock"></i></span>
                        <input  type="password" class="form-control" id="pw" name="pw" placeholder="패스워드">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-lock"></i></span>
                        <input  type="password" class="form-control" id="pw_check" name="pw_check" placeholder="패스워드 체크">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-printer"></i></span>
                        <input type="email" class="form-control" id="company_number" name="company_number" placeholder="사업자등록번호" onkeypress="return fn_press(event, 'numbers');" onkeydown="fn_press_han(this);" style="ime-mode:disabled;">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-mobile"></i></span>
                        <input type="email" class="form-control" id="tel" name="tel" placeholder="연락처" onkeypress="return fn_press(event, 'numbers');" onkeydown="fn_press_han(this);" style="ime-mode:disabled;">
                    </div>
                    <div class="input-group ptb-10">
                        <span class="input-group-addon"><i class="ti-email"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="이메일" onkeydown="fn_press_han(this);" style="ime-mode:disabled;">
                    </div>
                    <div class="ptb-20">
                        <button class="btn btn-lg btn-theme-primary btn-block" type="button" id="form_submit">가입하기</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row section_row-sm-offset-3">
            <div class="ptb-10 text-center">
                I Already Have an Account <a href="/web/login">Login</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="/application/views/main/js/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="/application/views/main/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="/application/views/main/js/custom.js"></script>

<script src="/application/views/main/js/join.js" type="text/javascript"></script>
</body>
</html>