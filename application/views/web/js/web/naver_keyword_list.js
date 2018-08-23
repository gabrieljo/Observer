function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// 테이블 불러오기
var LoadDatatable = function() {
    var t = function() {
        var t = $(".m_datatable_keyword").mDatatable({
                data: {
                    type: "remote",
                    source: {
                        read: {
                            url: "/web_act/get_naver_keyword_list"
                        }
                    },
                    pageSize: 10,
                    saveState: {
                        cookie: !0,
                        webstorage: !0
                    },
                    serverPaging: !0,
                    serverFiltering: !1,
                    serverSorting: !0
                },
                layout: {
                    theme: "default",
                    scroll: !1,
                    height: null,
                    footer: !1
                },
                sortable: !0,
                pagination: !0,
                detail: {
                    content: function(t) {
                        $("<div/>").attr("id", "child_keyword_data_ajax_" + t.data.no).appendTo(t.detailCell).mDatatable({
                            data: {
                                type: "remote",
                                source: {
                                    read: {
                                        url: "/web_act/get_naver_keyword_list_sub",
                                        params: {
                                            query: {
                                                no: t.data.no
                                            }
                                        }
                                    }
                                },
                                pageSize: 10,
                                saveState: {
                                    cookie: !0,
                                    webstorage: !0
                                },
                                serverPaging: !0,
                                serverFiltering: !1,
                                serverSorting: !0
                            },
                            layout: {
                                theme: "default",
                                scroll: !0,
                                height: 300,
                                footer: !1,
                                spinner: {
                                    type: 1,
                                    theme: "default"
                                }
                            },
                            sortable: !0,
                            columns: [{
                                field: "no",
                                width: 50,
                                title: "No",
                                sortable: !0,
                                overflow: "visible"
                            },{
                                field: "img_src",
                                width: 70,
                                title: "이미지",
                                sortable: !1,
                                overflow: "visible",
                                template: function(t) {
                                    return '<img src="'+t.img_src+'" width="50px" height="50px">';
                                }
                            },{
                                field: "company_name",
                                width: 100,
                                title: "회사명",
                                sortable: !0,
                                overflow: "visible"
                            },{
                                field: "product_name",
                                width: 200,
                                title: "상품명",
                                sortable: !0,
                                overflow: "visible"
                            },{
                                field: "product_price",
                                width: 100,
                                title: "가격",
                                sortable: !0,
                                overflow: "visible",
                                template: function(t) {
                                    return numberWithCommas(t.product_price)+'원'
                                }
                            },{
                                field: "delivery_cost",
                                width: 100,
                                title: "배송비",
                                sortable: !0,
                                overflow: "visible",
                                template: function(t) {
                                    return numberWithCommas(t.delivery_cost)+'원'
                                }
                            },{
                                field: "Actions",
                                width: 110,
                                title: "Actions",
                                sortable: !1,
                                overflow: "visible",
                                template: function(t) {
                                    return '<a onClick="window.open(\''+t.site_href+'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="바로가기"><i class="la la-external-link"></i></a>'
                                }
                            }]
                        })
                    }
                },
                columns: [{
                    field: "no",
                    title: "",
                    sortable: !1,
                    width: 50,
                    textAlign: "center"
                },{
                    field: "",
                    width: 50,
                    title: "No",
                    sortable: !0,
                    overflow: "visible",
                    template: function(t) {
                        return t.no;
                    }
                },{
                    field: "update_date",
                    title: "최근 업데이트일",
                    sortable: !0,
                    width: 100,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        var date = t.update_date;
                        if(date == null){
                            date = "-";
                        }

                        return date;
                    }
                },{
                    field: "first_company",
                    title: "1위 업체명",
                    sortable: !0,
                    width: 75,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "first_price",
                    title: "1위 가격",
                    sortable: !0,
                    width: 75,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        return numberWithCommas(t.first_price)+'원'
                    }
                },{
                    field: "first_delivery_cost",
                    title: "1위 배송비",
                    sortable: !0,
                    width: 75,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        return numberWithCommas(t.first_delivery_cost)+'원'
                    }
                },{
                    field: "category_name",
                    title: "태그명",
                    sortable: !0,
                    width: 80,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "keyword_name",
                    title: "키워드명",
                    sortable: !0,
                    width: 150,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        return '<a href="'+t.shop_link+'" target="_blank">'+t.keyword_name+'</a>'
                    }
                },{
                    field: "sort",
                    title: "정렬방법",
                    sortable: !0,
                    width: 80,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        if(t.sort == "rel"){
                            return "랭킹순";
                        }else{
                            return "낮은가격순";
                        }
                    }
                },{
                    field: "ads_rank_yn",
                    title: "광고포함",
                    sortable: !0,
                    width: 70,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        if(t.ads_rank_yn == "Y"){
                            return "포함";
                        }else{
                            return "미포함";
                        }
                    }
                },{
                    field: "my_rank",
                    title: "나의순위",
                    sortable: !0,
                    width: 90,
                    selector: !1,
                    textAlign: "center",
                    template: function(t) {
                        if(t.my_rank != 0){
                            return t.my_rank+'위'
                        }else{
                            return "존재안함";
                        }
                    }
                },{
                    field: "Actions",
                    width: 120,
                    title: "Actions",
                    sortable: !1,
                    overflow: "visible",
                    template: function(t) {
                        var return_value = "";
                        if(t.warning == "Y"){
                            return_value += '<a href="/web_act/naver_warning_off/'+t.no+'" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="알림종료"><i class="la la-eye-slash"></i></a>';
                        }

                        return_value += '<a href="/web/naver_keyword_edit/'+t.no+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="수정"><i class="la la-edit"></i></a><a onclick="deleteNaverKeyword('+t.no+');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="삭제"><i class="la la-trash"></i></a><a onclick="updateNaverKeyword('+t.no+');" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="업데이트"><i class="la la-refresh"></i></a>';
                        return return_value
                    }
                },{
                    field: "memo",
                    width: 270,
                    title: "메모",
                    sortable: !1,
                    overflow: "visible",
                    template: function(t) {
                        return '<textarea class="form-control m-input" id="memo'+t.no+'" rows="2">'+t.memo+'</textarea><a href="#" onclick="saveMemo('+t.no+')">저장</a>';
                    }
                }]
            }),
            e = t.getDataSourceQuery();

        $("#m_form_search").val(e.generalSearch);
        $("#m_form_status").selectpicker('val', e.Status);
        $("#m_form_category").selectpicker('val', e.Category);

        $("#m_form_search").on("keyup", function(e) {
            var a = t.getDataSourceQuery();
            a.generalSearch = $(this).val().toLowerCase(), t.setDataSourceQuery(a), t.load()
        }).val(e.generalSearch), $("#m_form_status").on("change", function() {
            t.search($(this).val(), "Status")
        }).val(e.generalSearch), $("#m_form_category").on("change", function() {
            t.search($(this).val(), "Category")
        }).val(e.generalSearch), $("#m_form_category, #m_form_status, #m_form_type").selectpicker()
    };
    return {
        init: function() {
            t()
        }
    }
}();

jQuery(document).ready(function() {
    //테이블 불러오기
    LoadDatatable.init();
});

//네이버 상품 삭제
var deleteNaverKeyword = function(no) {
    if (confirm("삭제 하시겠습니까?")) {
        location.href="/web_act/delete_naver_keyword/" + no;
    }
};

//메모저장
var saveMemo = function(no) {
    var url = "/web_act/save_keyword_memo/" + no;
    var value = $('#memo'+no).val();

    $.ajax({
        type:"POST",
        url:url,
        data:{'memo' : value, 'no' : no},
        success:function(msg){
            alert(msg);
        },
        error:function(e){
            alert("수정 실패")
        }
    });

};

//네이버 페이지 업데이트
var updateNaverKeyword = function(no) {
    location.href="/web_act/update_naver_keyword/" + no;
};

//네이버 전체 업데이트 ajax 요청
var updateAjax = function(){
    jQuery(document).ready(function() {
        alert("업데이트 요청 완료");

        var url="/web_act/all_keyword_update";

        $.ajax({
            type:"POST",
            url:url,
            success:function(msg){
                alert(msg);
            },
            error:function(e){
                console.log(e);
            }
        });
    });
};