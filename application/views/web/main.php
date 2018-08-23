<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    <?=$title?>
                </h3>
            </div>
        </div>
    </div>
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-6">
                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Observer 정보
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            네이버가격비교 페이지 제한
                                        </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            +<?=$_SESSION['LIMIT_DB']?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            키워드수 제한
                                        </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            +<?=$_SESSION['DETAIL_LIMIT_DB']?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            경쟁사감시 페이지 제한
                                        </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            +<?=$_SESSION['KEYWORD_LIMIT_DB']?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            네이버 가격비교 알림
                                        </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            <a href="/web/naver_shop">+<?=$naver_total_warning?></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            사용 마감일
                                        </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">
                                            <?=$_SESSION['END_DATE']?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-xl-6">
                        <!--begin:: Widgets/Tasks -->
                        <div class="m-portlet m-portlet--full-height ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            업데이트 내역
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="m_widget2_tab1_content">
                                        <div class="m-widget2">
                                            <div class="m-widget2__item m-widget2__item--warning">
                                                <div class="m-widget2__checkbox">
                                                </div>
                                                <div class="m-widget2__desc">
                                                        <span class="m-widget2__text">
                                                            경쟁사 상품 감시 메뉴 오픈
                                                        </span>
                                                    <br>
                                                    <span class="m-widget2__user-name">
                                                        <a href="#" class="m-widget2__link">
                                                            2017-11-09
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget2__item m-widget2__item--danger">
                                                <div class="m-widget2__checkbox">
                                                </div>
                                                <div class="m-widget2__desc">
                                                    <span class="m-widget2__text">
                                                        네이버키워드 메뉴 오픈
                                                    </span>
                                                    <br>
                                                    <span class="m-widget2__user-name">
                                                        <a href="#" class="m-widget2__link">
                                                            2017-11-01
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget2__item m-widget2__item--warning">
                                                <div class="m-widget2__checkbox">
                                                </div>
                                                <div class="m-widget2__desc">
                                                        <span class="m-widget2__text">
                                                            네이버가격비교 > 메모기능 추가
                                                        </span>
                                                    <br>
                                                    <span class="m-widget2__user-name">
                                                        <a href="#" class="m-widget2__link">
                                                            2017-10-30
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget2__item m-widget2__item--danger">
                                                <div class="m-widget2__checkbox">
                                                </div>
                                                <div class="m-widget2__desc">
                                                    <span class="m-widget2__text">
                                                        네이버가격비교 > 나의순위 추가
                                                    </span>
                                                    <br>
                                                    <span class="m-widget2__user-name">
                                                        <a href="#" class="m-widget2__link">
                                                            2017-10-30
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="m_widget2_tab2_content"></div>
                                    <div class="tab-pane" id="m_widget2_tab3_content"></div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/Tasks -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/application/views/web/js/web/main.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>