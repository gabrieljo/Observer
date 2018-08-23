function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// 테이블 불러오기
var LoadDatatable = function() {
    var t = function() {
        var t = $(".m_datatable_detail").mDatatable({
                data: {
                    type: "remote",
                    source: {
                        read: {
                            url: "/web_act/get_detail_shop_list"
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
                        $("<div/>").attr("id", "child_keyword_data_ajax" + t.data.no).appendTo(t.detailCell).mDatatable({
                            data: {
                                type: "remote",
                                source: {
                                    read: {
                                        url: "/web_act/get_detail_shop_list_sub",
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

                                    return '<a href="/web/detail_shop_log/'+t.no+'">'+date+'</a>';
                                }
                            },{
                                field: "warning",
                                title: "변동발생",
                                sortable: !0,
                                width: 100,
                                selector: !1,
                                textAlign: "center"
                            },{
                                field: "change_count",
                                title: "변경빈도",
                                sortable: !0,
                                width: 100,
                                selector: !1,
                                textAlign: "center"
                            },{
                                field: "company_name",
                                width: 150,
                                title: "업체명",
                                sortable: !0,
                                overflow: "visible"
                            },{
                                field: "price",
                                width: 150,
                                title: "가격",
                                sortable: !0,
                                overflow: "visible",
                                template: function(t) {
                                    return numberWithCommas(t.price)+'원'
                                }
                            },{
                                field: "delivery_cost",
                                width: 150,
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
                                    var return_value = "";
                                    if(t.warning == "Y"){
                                        return_value += '<a href="#" id="off_warning'+t.no+'" onclick="offWarning('+t.no+')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="알림종료"><i class="la la-eye-slash"></i></a>';
                                    }

                                    return_value += '<a onClick="window.open(\''+t.shop_link+'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="바로가기"><i class="la la-external-link"></i></a><a onclick="updateDetailShop('+t.no+');" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="업데이트"><i class="la la-refresh"></i></a>';
                                    return return_value;
                                }
                            },{
                                field: "memo",
                                width: 200,
                                title: "메모",
                                sortable: !1,
                                overflow: "visible",
                                template: function(t) {
                                    return '<textarea class="form-control m-input" id="memo_sub'+t.no+'" rows="2">'+t.memo+'</textarea><a href="#" onclick="saveMemoSub('+t.no+')">저장</a>';
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
                    field: "img_src",
                    width: 70,
                    title: "대표이미지",
                    sortable: !1,
                    overflow: "visible",
                    template: function(t) {
                        return '<img style="cursor:pointer" src="'+t.img_src+'" width="50px" height="50px" onClick="window.open(\''+t.shop_link+'\')">';
                    }
                },{
                    field: "warning",
                    title: "변동발생",
                    sortable: !0,
                    width: 100,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "category_name",
                    title: "태그명",
                    sortable: !0,
                    width: 100,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "product_name",
                    title: "상품명",
                    sortable: !0,
                    width: 150,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "Actions",
                    width: 135,
                    title: "Actions",
                    sortable: !1,
                    overflow: "visible",
                    template: function(t) {
                        var return_value = "";

                        return_value += '<a href="/web/detail_shop_sub_add/'+t.no+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="하위상품추가"><i class="la \tla-plus-circle"></i></a><a href="/web/detail_shop_edit/'+t.no+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="수정"><i class="la la-edit"></i></a><a onclick="deleteDetailShop('+t.no+');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="삭제"><i class="la la-trash"></i></a>';
                        return return_value
                    }
                },{
                    field: "memo",
                    width: 200,
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
var deleteDetailShop = function(no) {
    if (confirm("삭제 하시겠습니까?")) {
        location.href="/web_act/delete_detail_shop/" + no;
    }
};

// 페이지 업데이트
var updateDetailShop = function(no) {
    location.href="/web_act/update_detail_shop/" + no;
};

// 전체 업데이트 ajax 요청
var updateAjax = function(){
    jQuery(document).ready(function() {
        alert("업데이트 요청 완료");

        var url="/web_act/all_update";

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



//메모저장
var offWarning = function(no) {
    var url = "/web_act/detail_warning_off/" + no;

    $.ajax({
        type:"POST",
        url:url,
        data:{'no' : no},
        success:function(msg){
            alert(msg);
            $('#off_warning'+no).hide();
        },
        error:function(e){
            alert("알림종료 실패")
        }
    });
};


//메모저장
var saveMemo = function(no) {
    var url = "/web_act/save_detail_memo/" + no;
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

//메모_sub 저장
var saveMemoSub = function(no) {
    var url = "/web_act/save_detail_memo_sub/" + no;
    var value = $('#memo_sub'+no).val();

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