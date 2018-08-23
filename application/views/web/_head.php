<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Observer | <?=$title?>
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

    <!-- begin::Quick Nav -->
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

    <script src="/application/views/web/js/jquery.min.js" type="text/javascript"></script>
    <!--begin::Base Scripts -->
    <script src="/application/views/web/js/vendors.bundle.js" type="text/javascript"></script>
    <script src="/application/views/web/js/scripts.bundle.js" type="text/javascript"></script>
    <!--end::Base Scripts -->

    <!--begin::Base Styles -->
    <link href="/application/views/web/css/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/application/views/web/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/application/views/web/css/custom.css" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="/application/views/web/img/favicon.ico" />
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="/web/main" class="m-brand__logo-wrapper">
                                <img alt="" src="/application/views/web/assets/app/media/img//logos/observer_dark.png"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            
                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>
                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <!-- BEGIN: Horizontal Menu -->
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>
                    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >

                    </div>
                    <!-- END: Horizontal Menu -->
                    <!-- BEGIN: Topbar -->
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">
                                <a target="_blank" href="/guide" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        가이드
                                    </span>
                                </a>
                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-topbar__userpic">
                                            내정보
                                        </span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center" style="background: url(); background-size: cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500" style="color: black;">
                                                            <?=$_SESSION['U_NAME']?>
                                                        </span>
                                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                            <?=$_SESSION['U_ID']?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">

                                                        <li class="m-nav__item">
                                                            <a href="/web/mypage" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                <span class="m-nav__link-title">
                                                                    <span class="m-nav__link-wrap">
                                                                        <span class="m-nav__link-text">
                                                                            My Profile
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                                        <li class="m-nav__item">
                                                            <a href="/web_act/logout" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                Logout
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END: Topbar -->
                </div>
            </div>
        </div>
    </header>
    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            <!-- BEGIN: Aside Menu -->
            <div
                    id="m_ver_menu"
                    class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
                    data-menu-vertical="true"
                    data-menu-scrollable="false" data-menu-dropdown-timeout="500">
                <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                    <li class="m-menu__item <?echo ($title == "메인") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true" >
                        <a  href="/web/main" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-location"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">
                                        메인
                                    </span>
                                </span>
                            </span>
                        </a>
                    </li>

                    <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded <?echo ($title == "네이버 가격비교" || $title == "네이버 키워드") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true" data-menu-submenu-toggle="hover">
                        <a href="#" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon flaticon-diagram"></i>
                            <span class="m-menu__link-text">
                                네이버
                            </span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu" style="display: block;">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">

                                <li class="m-menu__item <?echo ($title == "네이버 가격비교") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true">
                                    <a href="/web/naver_shop" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">
                                            네이버 가격비교
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item <?echo ($title == "네이버 키워드") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true">
                                    <a href="/web/naver_keyword" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">
                                            네이버 키워드
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

<!--                    <li class="m-menu__item --><?//echo ($title == "네이버 지식쇼핑") ? "m-menu__item--active" : "m-menu__item"?><!--" aria-haspopup="true" >-->
<!--                        <a  href="/web/naver_shop" class="m-menu__link">-->
<!--                            <i class="m-menu__link-icon flaticon-line-graph"></i>-->
<!--                            <span class="m-menu__link-title">-->
<!--                                <span class="m-menu__link-wrap">-->
<!--                                    <span class="m-menu__link-text">-->
<!--                                        네이버 가격비교-->
<!--                                    </span>-->
<!--                                    --><?//if($naver_total_warning > 0){?>
<!--                                        <span class="m-menu__link-badge">-->
<!--                                            <span class="m-badge m-badge--danger">-->
<!--                                                --><?//=$naver_total_warning?>
<!--                                            </span>-->
<!--                                        </span>-->
<!--                                    --><?//}?>
<!--                                </span>-->
<!--                            </span>-->
<!--                        </a>-->
<!--                    </li>-->
<!---->
<!--                    <li class="m-menu__item --><?//echo ($title == "네이버 키워드") ? "m-menu__item--active" : "m-menu__item"?><!--" aria-haspopup="true" >-->
<!--                        <a  href="/web/naver_keyword" class="m-menu__link">-->
<!--                            <i class="m-menu__link-icon flaticon-line-graph"></i>-->
<!--                            <span class="m-menu__link-title">-->
<!--                                <span class="m-menu__link-wrap">-->
<!--                                    <span class="m-menu__link-text">-->
<!--                                        네이버 키워드-->
<!--                                    </span>-->
<!--                                </span>-->
<!--                            </span>-->
<!--                        </a>-->
<!--                    </li>-->
                    <li class="m-menu__item <?echo ($title == "경쟁사 감시") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true" >
                        <a  href="/web/detail_shop" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-diagram"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">
                                        경쟁사 상품 감시
                                    </span>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="m-menu__item <?echo ($title == "태그 관리") ? "m-menu__item--active" : "m-menu__item"?>" aria-haspopup="true" >
                        <a  href="/web/category" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-interface-7"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">
                                        태그 관리
                                    </span>
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>

            </div>
            <!-- END: Aside Menu -->
        </div>