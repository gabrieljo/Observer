<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="col-xl-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                로그 내역
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-striped m-table">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        업데이트 일시
                                    </th>
                                    <th>
                                        변경 내역
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?if(count($data) > 0){?>
                                    <?foreach($data as $key => $value){?>
                                        <tr>
                                            <th scope="row">
                                                <?=$key + 1?>
                                            </th>
                                            <td>
                                                <?=$value['wdate']?>
                                            </td>
                                            <td>
                                                <?=$value['contents']?>
                                            </td>
                                        </tr>
                                    <?}?>
                                <?}else{?>
                                    <tr>
                                        <td colspan="3" align="center">
                                            로그 내역이 없습니다.
                                        </td>
                                    </tr>
                                <?}?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Section-->
                </div>
                <div class="m-portlet__foot">
                    <button type="reset" class="btn btn-secondary" onclick="location.href='/web/detail_shop'">
                        목록으로
                    </button>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>

<?
require_once "_footer.php";
?>