//태그 삭제
var deleteCategory = function(no) {
    if (confirm("삭제 하시겠습니까?")) {
        location.href="/web_act/delete_category/" + no;
    }
};

var DatatableRemoteAjaxDemo = function() {
    var t = function() {
        var t = $(".m_datatable").mDatatable({
                data: {
                    type: "remote",
                    source: {
                        read: {
                            url: "/web_act/get_catogory_list"
                        }
                    },
                    pageSize: 10,
                    saveState: {
                        cookie: !0,
                        webstorage: !0
                    },
                    serverPaging: !0,
                    serverFiltering: !0,
                    serverSorting: !0
                },
                layout: {
                    theme: "default",
                    class: "",
                    scroll: !1,
                    footer: !1
                },
                sortable: !0,
                pagination: !0,
                columns: [{
                    field: "no",
                    title: "No",
                    sortable: !0,
                    width: 40,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "wdate",
                    title: "작성일자",
                    sortable: !0,
                    width: 100,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "category_name",
                    title: "태그명",
                    sortable: !0,
                    width: 200,
                    selector: !1,
                    textAlign: "center"
                },{
                    field: "Actions",
                    width: 110,
                    title: "Actions",
                    sortable: !1,
                    overflow: "visible",
                    template: function(t) {
                        return '<a href="/web/edit_category/'+t.no+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a onclick="deleteCategory('+t.no+');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
                    }
                }
                ]
            }),
            e = t.getDataSourceQuery();

            $("#m_form_search").val(e.generalSearch);

        $("#m_form_search").on("keyup", function(e) {
            var a = t.getDataSourceQuery();

            a.generalSearch = $(this).val().toLowerCase(), t.setDataSourceQuery(a), t.load()
        })
    };
    return {
        init: function() {
            t()
        }
    }
}();
jQuery(document).ready(function() {
    DatatableRemoteAjaxDemo.init()
});