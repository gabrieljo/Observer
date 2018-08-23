<div class="cc">
    <div class="header_wrap">
        <b>Observer Service</b>
    </div>
    <div class="guide_cont">
        <div class="helper_detail_tit">
            네이버 가격비교
        </div>
        <br>
        <img src="/application/views/guide/img/naver-price.PNG" alt="" class="default_img large">
        위 사진과 같은 네이버 가격비교 페이지의 가격과 배송비의 변동여부를 감시 합니다<br>

        <h4>환경설정</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/naver-price1.PNG" alt="" class="default_img large">
            위치 : "메뉴 > 네이버 가격비교 > Quick Menu > 환경설정" <br><br>
            1. 나의업체명 : 나의업체명을 작성하면 리스트에 나의업체 순위가 노출 됩니다.<br>
            2. 감시등수 : 1위 선택시 1위까지의 가격정보변동을 감지하며 2위 선택시 1~2위의 가격정보변동을 감지 합니다.<br>
            3. 감시 예외 마켓 : 감시예외마켓 등록시 등록된마켓을 제외하고 가격모니터링과 순위를 가지고 옵니다.
        </div>

        <h4>네이버 가격비교 페이지 등록</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/naver-price2.PNG" alt="" class="default_img large">
            위치 : "메뉴 > 네이버 가격비교 > 페이지등록" <br><br>
            1. 상품명 : 상품명 자동등록 선택 시 상품명이 자동 등록되며 체크를 해제하면 임의로 상품명을 입력 가능 합니다.<br>
            2. 페이지 URL : 감시를 원하는 <a href="http://shopping.naver.com/detail/detail.nhn?nv_mid=5644602899&cat_id=50002032&frm=NVSCPRO&query=%EC%83%9D%EC%88%98">네이버 가격비교 사이트 페이지</a>의 URL을 입력 합니다.<br>
            3. 태그 : 태그관리에서 미리 지정한 태그를 선택 합니다.
            4. 메모 : 상품에 대한 메모를 작성 할 수 있으며 리스트에 노출 됩니다.
        </div>


        <h4>상품감시 시작</h4>

        <div class="helper_detail">
            <img src="/application/views/guide/img/naver-price3.PNG" alt="" class="default_img large">
            위치 : "메뉴 > 네이버 가격비교" <br><br>
            1. 상품감시는 <span style="color:red">한시간에 한번 자동</span>으로 실행 됩니다.<br>
            2. 상품의 변동이 감지 되면 리스트에서 변동발생여부가 "Y"로 변경 됩니다.<br>
            3. 변경 로그는 "최근업데이트일"을 클릭하면 확인이 가능합니다<br>
            4. 상품가격변동 발생 시 가격대응 후 "Action" 필드의 "알림끄기" 버튼을 누르면 알림이 종료 됩니다.<br>
        </div>
    </div>
</div>

<?
require_once "_footer.php";
?>
