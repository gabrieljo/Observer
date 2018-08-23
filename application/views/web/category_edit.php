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
                            태그 수정
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form name="category_form" class="m-form m-form--fit m-form--label-align-right" method="POST" action="/web_act/edit_category">
                <input type="hidden" name="no" value="<?=$no?>">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">
                            태그명
                        </label>
                        <div class="col-10">
                            <input class="form-control m-input" type="text" name="category_name" id="category_name" value="<?=$data[0]['category_name']?>">
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <button type="reset" class="btn btn-brand" id="form_submit">
                                    수정
                                </button>
                                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/category'">
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

<script src="/application/views/web/js/web/category.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>