$(document).ready(function(){

    $('#form_submit').click(function(){

        if ($('#company_name').val() == "") {
            alert("업체명을 입력 해주세요.");
            $('#company_name').focus();
            return false;
        }

        if ($('#id').val() == "") {
            alert("ID를 입력 해주세요.");
            $('#id').focus();
            return false;
        }

        // id_check($('#id').val());

        if ($('#pw').val() == "") {
            alert("패스워드를 입력 해주세요.");
            $('#pw').focus();
            return false;
        }

        if ($('#pw_check').val() == "") {
            alert("패스워드를 한번 더 입력해주세요.");
            $('#pw_check').focus();
            return false;
        }

        if($('#pw').val() != $('#pw_check').val()){
            alert("패스워드가 일치하지 않습니다.");
            $('#pw').focus();
            return false;
        }

        if ($('#company_number').val() == "") {
            alert("사업자등록번호를 입력 해주세요.");
            $('#company_number').focus();
            return false;
        }

        if ($('#tel').val() == "") {
            alert("연락처를 입력 해주세요.");
            $('#tel').focus();
            return false;
        }

        if ($('#email').val() == "") {
            alert("이메일을 입력 해주세요.");
            $('#email').focus();
            return false;
        }

        // email_check($('#email').val());

        join_form.submit();
    });
});

/* 숫자만 입력받기 */
function fn_press(event, type) {
    if(type == "numbers") {
        if(event.keyCode < 48 || event.keyCode > 57) return false;
        //onKeyDown일 경우 좌, 우, tab, backspace, delete키 허용 정의 필요
    }
}
/* 한글입력 방지 */
function fn_press_han(obj)
{
    //좌우 방향키, 백스페이스, 딜리트, 탭키에 대한 예외
    if(event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39
        || event.keyCode == 46 ) return;
    //obj.value = obj.value.replace(/[\a-zㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
    obj.value = obj.value.replace(/[\ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
}
