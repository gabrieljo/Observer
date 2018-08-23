$(document).ready(function(){
    $('#name_check').click(function(){
        if($('#name_check').is(":checked")){
            $('#product_name').attr('disabled',true);
        }else{
            $('#product_name').attr('disabled',false);
        }
    });

    $('#add_form_submit').click(function() {

        if (!$('#name_check').is(":checked") && $('#product_name').val() == "") {
            alert("상품명을 입력 해주세요.");
            $('#product_name').focus();
            return false;
        }

        if ($('#url').val() == "") {
            alert("페이지 URL을 입력 해주세요.");
            $('#url').focus();
            return false;
        }

        if ($('#category option:selected').val() == "") {
            alert("태그를 선택 해주세요.");
            $('#category').focus();
            return false;
        }

        detail_shop_add_form.submit();
    });

    $('#add_sub_form_submit').click(function() {

        if (!$('#name_check').is(":checked") && $('#product_name').val() == "") {
            alert("상품명을 입력 해주세요.");
            $('#product_name').focus();
            return false;
        }

        if ($('#url').val() == "") {
            alert("페이지 URL을 입력 해주세요.");
            $('#url').focus();
            return false;
        }

        detail_shop_sub_add_form.submit();
    });

    $('#edit_form_submit').click(function() {

        if ($('#product_name').val() == "") {
            alert("상품명을 입력 해주세요.");
            $('#product_name').focus();
            return false;
        }

        if ($('#category option:selected').val() == "") {
            alert("태그를 선택 해주세요.");
            $('#category').focus();
            return false;
        }

        detail_shop_edit_form.submit();
    });
});
