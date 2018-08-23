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
                            네이버 가격비교 수정
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form id="naver_shop_edit_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/edit_naver_shop">
                <input type="hidden" name="no" value="<?=$detail['no']?>">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            상품명
                        </label>
                        <div class="col-10">
                            <div class="input-group m-form__group">
                                <input type="text" class="form-control" name="product_name" id="product_name" value="<?=$detail['product_name']?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            태그
                        </label>
                        <div class="col-10">
                            <div class="input-group m-form__group">
                                <select class="form-control m-input" name="category" id="category">
                                    <?foreach ($categorys as $key => $value){?>
                                        <option value="<?=$value['no']?>" <?echo ($detail['category_no'] == $value['no'] ? "selected" : "")?>>
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
                            <div class="input-group m-form__group">
                                <textarea class="form-control m-input" name="memo" rows="3"><?=$detail['memo']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <button type="reset" class="btn btn-brand" id="edit_form_submit">
                                    수정
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