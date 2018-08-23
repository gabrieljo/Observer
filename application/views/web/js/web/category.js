//태그 삭제
var deleteCategory = function(no) {
    if (confirm("삭제 하시겠습니까?")) {
        location.href="/web_act/delete_category/" + no;
    }
};

$(document).ready(function(){
    $('#form_submit').click(function(){
        if ($('#category_name').val() == "") {
            alert("태그명 입력 해주세요.");
            $('#category_name').focus();
            return false;
        }

        category_form.submit();
    });
});


