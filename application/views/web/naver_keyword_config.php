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
                            네이버 키워드 환경설정
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet__body">
                <form id="company_name_form" method="POST" action="/web_act/edit_naver_keyword_config">
                    <input type="hidden" name="mode" value="keyword_company_name">

                    <div class="form-group m-form__group">
                        <label for="exampleSelect1">
                            나의 업체명
                        </label>

                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword_company_name" id="keyword_company_name" value="<?=$keyword_company_name?>">
                            <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button" id="keyword_company_name_submit">
                                저장
                            </button>
                        </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="m-portlet__foot">
                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/naver_keyword'">
                    목록으로
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/application/views/web/js/web/naver_keyword_config.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>