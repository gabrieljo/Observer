$(document).ready(function(){
    $('#form_submit').click(function(){

        if ($('#now_password').val() != "" && $('#new_password').val() == "") {
            alert("새로운 패스워드를 입력 해주세요.");
            $('#new_password').focus();
            return false;
        }

        if ($('#now_password').val() == "" && $('#new_password').val() != "") {
            alert("기존 패스워드를 입력 해주세요.");
            $('#now_password').focus();
            return false;
        }

        if ($('#now_password').val() != "" && $('#new_password').val() != "" && $('#new_password_again').val() == "") {
            alert("새로운 패스워드 확인을 입력 해주세요.");
            $('#new_password_again').focus();
            return false;
        }

        if ( $('#new_password').val() !=  $('#new_password_again').val()) {
            alert("패스워드가 일치하지 않습니다.");
            $('#new_password').focus();
            return false;
        }

        if ($('#tel').val() == "") {
            alert("연락처를 입력해 주세요.");
            $('#tel').focus();
            return false;
        }

        if ($('#email').val() == "") {
            alert("연락처를 입력해 주세요.");
            $('#email').focus();
            return false;
        }

        mypage_form.submit();
    });
});
