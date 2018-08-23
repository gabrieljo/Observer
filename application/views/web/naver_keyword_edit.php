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
                            네이버 키워드 수정
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form id="naver_shop_edit_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/edit_naver_keyword">
                <input type="hidden" name="no" value="<?=$detail['no']?>">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            키워드명
                        </label>
                        <div class="col-10">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword_name" id="keyword_name" value="<?=$detail['keyword_name']?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            정렬방법
                        </label>
                        <div class="col-10">
                            <div class="m-radio-list">
                                <label class="m-radio">
                                    <input type="radio" name="sort" value="rel" <?echo ($detail['sort'] == "rel" ? "checked" : "")?>>
                                    네이버쇼핑 랭킹순
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="sort" value="price_asc" <?echo ($detail['sort'] == "price_asc" ? "checked" : "")?>>
                                    낮은 가격순
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            광고포함여부
                        </label>
                        <div class="col-10">
                            <div class="m-radio-list">
                                <label class="m-radio">
                                    <input type="radio" name="ads_rank_yn" value="Y" <?echo ($detail['ads_rank_yn'] == "Y" ? "checked" : "")?>>
                                    포함
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="ads_rank_yn" value="N" <?echo ($detail['ads_rank_yn'] == "N" ? "checked" : "")?>>
                                    미포함
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            묶음상품 포함여부
                        </label>
                        <div class="col-10">
                            <div class="m-radio-list">
                                <label class="m-radio">
                                    <input type="radio" name="bundle_yn" value="Y" <?echo ($detail['bundle_yn'] == "Y" ? "checked" : "")?>>
                                    포함
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="bundle_yn" value="N" <?echo ($detail['bundle_yn'] == "N" ? "checked" : "")?>>
                                    미포함
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            최저가
                        </label>
                        <div class="col-10">
                            <div class="input-group m-input-group">
                                <input type="text" name="min_price" id="min_price" class="form-control m-input" aria-describedby="basic-addon1" value="<?=$detail['min_price']?>">
                                <span class="input-group-addon" id="basic-addon1">
                                    원
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            최고가
                        </label>
                        <div class="col-10">
                            <div class="input-group m-input-group">
                                <input type="text" name="max_price" id="max_price" class="form-control m-input" aria-describedby="basic-addon1" value="<?=$detail['max_price']?>">
                                <span class="input-group-addon" id="basic-addon1">
                                    원
                                </span>
                            </div>
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
                                        <option value="<?=$value['no']?>" <?echo ($value['no'] == $detail['category_no'] ? "selected" : "")?>>
                                            <?=$value['category_name']?>
                                        </option>
                                    <?}
                                    if(count($categorys) == 0){
                                        ?>
                                        <option value="">
                                            카테고리를 추가 해주세요. "메뉴 > 태그 관리"
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
                                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/naver_keyword'">
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

<script src="/application/views/web/js/web/naver_keyword.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>