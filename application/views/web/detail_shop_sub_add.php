<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            하위상품 등록
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form id="detail_shop_sub_add_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/add_detail_shop_sub">
                <input type="hidden" name="no" value="<?=$no?>">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            페이지 URL
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <input class="form-control m-input" type="text" name="url" id="url">
                            </div>
                            <span class="m-form__help">
                            지원쇼핑몰 : 스토어팜
                            </span>
                        </div>

                    </div>

                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            메모
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <textarea class="form-control m-input" name="memo" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <button type="reset" class="btn btn-brand" id="add_sub_form_submit">
                                    저장
                                </button>
                                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/detail_shop'">
                                    취소
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/application/views/web/js/web/detail_shop.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>