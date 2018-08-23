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
                            네이버 가격비교 환경설정
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet__body">
                <form id="company_name_form" method="POST" action="/web_act/edit_naverconfig">
                    <input type="hidden" name="mode" value="company_name">
                    <div class="form-group m-form__group">
                        <label for="exampleSelect1">
                            나의 업체명
                        </label>

                        <div class="input-group">
                            <input type="text" class="form-control" name="company_name" id="company_name" value="<?=$company_name?>">
                            <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button" id="company_name_submit">
                                저장
                            </button>
                        </span>
                        </div>
                    </div>
                </form>

                <form id="m_level_form" method="POST" action="/web_act/edit_naverconfig">
                    <input type="hidden" name="mode" value="m_level">
                    <div class="form-group m-form__group">
                        <label for="exampleSelect1">
                            감시 등수
                        </label>

                        <div class="input-group">
                            <select class="form-control m-input" id="m_level" name="m_level">
                                <option value="1" <?echo ($m_level == 1 ? "selected":"")?>>
                                    1위
                                </option>
                                <option value="2" <?echo ($m_level == 2 ? "selected":"")?>>
                                    2위
                                </option>
                            </select>
                            <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button" id="m_level_submit">
                                저장
                            </button>
                        </span>
                        </div>
                    </div>
                </form>
                <form id="except_market_form" method="POST" action="/web_act/edit_naverconfig">
                    <input type="hidden" name="mode" value="except_market">
                    <input type="hidden" name="except_market_mode" id="except_market_mode" value="">
                    <input type="hidden" name="before_except_markets" id="before_except_markets" value="<?=preg_replace("/(\")/i","'",$before_except_markets)?>">
                    <div class="form-group m-form__group">
                        <label for="exampleSelect2">
                            감시 예외 마켓
                        </label>
                        <select multiple="" class="form-control m-input" name="except_markets" id="except_markets">
                            <?foreach ($except_markets as $key => $value){?>
                                <option value="<?=$value?>">
                                    <?=$value?>
                                </option>
                            <?}?>
                        </select>
                        <div class="input-group">
                            <input type="text" class="form-control" name="add_market_name" id="add_market_name" placeholder="ex: 옥션">
                            <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button" id="add_except_market">
                                추가
                            </button>
                            <button class="btn btn-secondary" type="button" id="delete_except_market">
                                삭제
                            </button>
                        </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="m-portlet__foot">
                <button type="reset" class="btn btn-secondary" onclick="location.href='/web/naver_shop'">
                    목록으로
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/application/views/web/js/web/naver_shop_config.js" type="text/javascript"></script>

<?
require_once "_footer.php";
?>