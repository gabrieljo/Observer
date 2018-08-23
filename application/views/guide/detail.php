<div class="cc">
    <div class="header_wrap">
        <b>Observer Service</b>
    </div>
    <div class="guide_cont">
        <div class="helper_detail_tit">
            경쟁사 상품감시
        </div>
        <br>
        <img src="/application/views/guide/img/detail.PNG" alt="" class="default_img large">
        위 사진과 같은 경쟁사의 상품 디테일페이지를 감시 합니다.<br>
        현재 지원 쇼핑몰 : 스토어팜
        
        <h4>대표상품 등록</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/detail1.PNG" alt="" class="default_img large">
            위치 : "메뉴 > 경쟁사 상품 감시 > 대표상품등록" <br><br>
            1. 상품명 : 상품명 자동등록 선택 시 상품명이 자동 등록되며 체크를 해제하면 임의로 상품명을 입력 가능 합니다.<br>
            2. 페이지 URL : 감시를 원하는 <a href="http://storefarm.naver.com/doyunmall/products/2047011954?NaPm=ct%3Dj9s195y0%7Cci%3D0yW00027TKboM3YKXKN8%7Ctr%3Dpla%7Chk%3D26cb7d61436dc358854fe40eb0e9bc9f7711a028">경쟁사 디테일 페이지</a>의 URL을 입력 합니다.<br>
            3. 태그 : 태그관리에서 미리 지정한 태그를 선택 합니다.<br>
            4. 메모 : 상품에 대한 메모를 작성 할 수 있으며 리스트에 노출 됩니다.
        </div>

        <h4>하위상품등록</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/detail2.PNG" alt="" class="default_img large">
            <br>상품리스트 "Action"필드의 위 사진과 같은 버튼을 눌러 하위상품등록 페이지로 이동 합니다.<br>

            <img src="/application/views/guide/img/detail3.PNG" alt="" class="default_img large">
            1. 페이지 URL : 감시를 원하는 <a href="http://storefarm.naver.com/doyunmall/products/2047011954?NaPm=ct%3Dj9s195y0%7Cci%3D0yW00027TKboM3YKXKN8%7Ctr%3Dpla%7Chk%3D26cb7d61436dc358854fe40eb0e9bc9f7711a028">경쟁사 디테일 페이지</a>의 URL을 입력 합니다.<br>
            2. 메모 : 상품에 대한 메모를 작성 할 수 있으며 리스트에 노출 됩니다.
        </div>

        <h4>경쟁사감시 시작</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/detail4.PNG" alt="" class="default_img large">
            위치 : "메뉴 > 경쟁사 상품 감시" <br><br>
            1. 상품감시는 <span style="color:red">한시간에 한번 자동</span>으로 실행 됩니다.<br>
            2. 상품의 변동이 감지 되면 리스트에서 변동발생여부가 "Y"로 변경 됩니다.<br>
            3. 변경 로그는 하위상품의 "최근업데이트일"을 클릭하면 확인이 가능합니다<br>
            4. 상품가격변동 발생 시 가격대응 후 "Action" 필드의 "알림끄기" 버튼을 누르면 알림이 종료 됩니다.<br>
            5. 하위상품의 알림을 모두 종료하면 대표상품의 변동발생여부가 종료 됩니다.<br>
        </div>
    </div>
</div>

<?
require_once "_footer.php";
?>
