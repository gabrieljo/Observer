$(document).ready(function(){
    $('#company_name_submit').click(function(){
        if ($('#company_name').val() == "") {
            alert("나의 업체명을 입력 해주세요.");
            $('#company_name').focus();
            return false;
        }

        company_name_form.submit();
    });

    $('#m_level_submit').click(function(){
        m_level_form.submit();
    });

    $('#add_except_market').click(function(){
        $('#except_market_mode').val('add');

        var text = $('#add_market_name').val();

        $("#except_markets > option").each(function() {
            if(this.text == text){
                alert("이미 예외처리된 마켓 입니다.");
                return false;
            }
        });

        except_market_form.submit();
    });

    $('#delete_except_market').click(function(){
        $('#except_market_mode').val('delete');

        except_market_form.submit();
    });
});
