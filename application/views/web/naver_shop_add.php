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
                            네이버 가격비교 등록
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form id="naver_shop_add_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/add_naver_shop">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            상품명
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    자동등록
                                </span>
                                <span class="input-group-addon">
                                    <label class="m-radio m-radio--single m-radio--state m-radio--state-brand">
                                        <input type="checkbox" name="name_check" id="name_check" checked>
                                        <span></span>
                                    </label>
                                </span>

                                <input type="text" class="form-control" name="product_name" id="product_name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            페이지 URL
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <input class="form-control m-input" type="text" name="url" id="url">
                            </div>
                            <span class="m-form__help">
                            네이버 가격비교 URL을 넣어주세요. 샘플 URL <a target="_blank" href="http://shopping.naver.com/detail/detail.nhn?nv_mid=5644602899&cat_id=50002032&frm=NVSCPRO&query=%EC%83%9D%EC%88%98">바로가기</a>
                            </span>
                        </div>

                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            태그
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <select class="form-control m-input" name="category" id="category">
                                    <?foreach ($categorys as $key => $value){?>
                                        <option value="<?=$value['no']?>">
                                            <?=$value['category_name']?>
                                        </option>
                                    <?} 
                                    if(count($categorys) == 0){
                                    ?>
                                    <option value="">
                                        태그를 추가 해주세요. "메뉴 > 태그 관리"
                                    </option>
                                    <?}?>
                                </select>
                            </div>
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
                                <button type="reset" class="btn btn-brand" id="add_form_submit">
                                    저장
                                </button>
                                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/naver_shop'">
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

<script src="/application/views/web/js/web/naver_shop.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>