$(document).ready(function(){
    $('#keyword_company_name_submit').click(function(){
        if ($('#keyword_company_name').val() == "") {
            alert("나의 업체명을 입력 해주세요.");
            $('#keyword_company_name').focus();
            return false;
        }

        company_name_form.submit();
    });
});
