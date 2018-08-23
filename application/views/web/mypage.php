<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                <i class="flaticon-share m--hide"></i>
                                프로필
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="m_user_profile_tab_1">
                    <form id="mypage_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/edit_mypage">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-10 ml-auto">
                                    <h3 class="m-form__section">
                                        기본 정보
                                    </h3>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    ID
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="text" value="<?=$_SESSION['U_ID']?>" disabled>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    기존 패스워드
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="password" id="now_password" name="now_password" value="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    새로운 패스워드
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="password" id="new_password" name="new_password" value="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    새로운 패스워드 확인
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="password" id="new_password_again" name="new_password_again" value="">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    연락처
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="text" id="tel" name="tel" value="<?=$data['tel']?>">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    이메일
                                </label>
                                <div class="col-7">
                                    <input class="form-control m-input" type="text" id="email" name="email" value="<?=$data['email']?>">
                                    <label class="m-checkbox">
                                        <input type="checkbox" id="email_check" name="email_check" <?echo ($data['email_check'] === "Y" ? "checked" : "") ?> value="<?=$data['email_check']?>">
                                        이메일수신
                                        <span></span>
                                    </label>
<!--                                    <span class="m-form__help">-->
<!--                                        이메일 수신 시 가격 변동 이메일이 전송 됩니다.-->
<!--                                    </span>-->
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-7">
                                        <button type="button" class="btn btn-secondary m-btn m-btn--air m-btn--custom" id="form_submit">
                                            저장
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane active" id="m_user_profile_tab_2"></div>
            </div>
        </div>
    </div>
</div>

<script src="/application/views/web/js/web/mypage.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>