$(document).ready(function(){

    $('#edit_form_submit').click(function() {

        if (Number($('#max_price').val()) < Number($('#min_price').val())) {
            alert("최저가가 최고가보다 높을 수 없습니다.");
            $('#min_price').focus();
            return false;
        }

        if ($('#min_price').val() == "") {
            alert("최저가를 입력 해주세요.");
            $('#min_price').focus();
            return false;
        }

        if ($('#max_price').val() == "") {
            alert("최고가를 입력 해주세요.");
            $('#max_price').focus();
            return false;
        }

        if ($('#category option:selected').val() == "") {
            alert("태그를 선택 해주세요.");
            $('#category').focus();
            return false;
        }

        naver_shop_edit_form.submit();
    });

    $('#add_form_submit').click(function() {

        if ($('#keyword_name').val() == "") {
            alert("키워드명을 입력 해주세요.");
            $('#keyword_name').focus();
            return false;
        }

        if (Number($('#max_price').val()) < Number($('#min_price').val())) {
            alert("최저가가 최고가보다 높을 수 없습니다.");
            $('#min_price').focus();
            return false;
        }

        if ($('#min_price').val() == "") {
            alert("최저가를 입력 해주세요.");
            $('#min_price').focus();
            return false;
        }

        if ($('#max_price').val() == "") {
            alert("최고가를 입력 해주세요.");
            $('#max_price').focus();
            return false;
        }

        if ($('#category option:selected').val() == "") {
            alert("태그를 선택 해주세요.");
            $('#category').focus();
            return false;
        }

        naver_keyword_add_form.submit();
    });

});
