<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_act extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // 헬퍼
        $this->load->helper('common');

        // 라이브러리
        $this->load->library('pjs');
        $this->load->library('scrap');

        //세션확인을 위한 경로 확인
        $path_explode = explode("/",$_SERVER["REQUEST_URI"]);
        $mode = $path_explode[count($path_explode) - 1];

        if(!isset( $_SESSION['U_ID'] )) {
            if($mode != "login" && $mode != "demo" && $mode != "all_naver_db_update" && $mode != "all_naver_keyword_db_update" && $mode != "all_detail_db_update") {
                $this->pjs->alert("로그인 후 이용가능합니다.");
                $this->pjs->href("/web/login");
            }
        }
    }

    /**
     * 네이버지식쇼핑 전체계정 업데이트
     */
    function all_detail_db_update(){
        $this->load->model('Mupdate');

        $rt = $this->Mupdate->all_detail_db_update();

        echo $rt;
    }

    /**
     * 네이버지식쇼핑 전체계정 업데이트
     */
    function all_naver_db_update(){
        $this->load->model('Mupdate');

        $rt = $this->Mupdate->all_naver_db_update();

        echo $rt;
    }

    /**
     * 네이버지식쇼핑 전체계정 업데이트
     */
    function all_naver_keyword_db_update(){
        $this->load->model('Mupdate');

        $rt = $this->Mupdate->all_naver_keyword_db_update();

        echo $rt;
    }

    /**
     * 로그인
     */
    function login($mode = "")
    {
        $this->load->model('Mmember');

        if($mode == "demo"){
            $_POST['id'] = "demo";
            $_POST['password'] = "1234";
        }

        $rt = $this->Mmember->login($_POST['id'], $_POST['password']);

        if ($rt == "y") {
            $this->pjs->href("/web/main");
        } else if ($rt == "e") {
            $this->pjs->alert("기간이 만료 되었습니다. 연장 해주세요.");
            $this->pjs->href("/web/login");
        } else {
            $this->pjs->alert("아이디 또는 패스워드를 확인 해주세요.");
            $this->pjs->href("/web/login");
        }
    }

    /**
     * 로그아웃
     */
    function logout()
    {
        $this->session->sess_destroy();

        $this->pjs->href("/web/login");
    }

    /**
     * 카테고리 리스트 불러오기
     */
    function get_catogory_list(){
        $this->load->model('Mcategory');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'no';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $keyword = ! empty( $datatable[ 'query' ][ 'generalSearch' ] ) ? $datatable[ 'query' ][ 'generalSearch' ] : false;

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'keyword' => $keyword
        );

        $total = $this->Mcategory->get_catogory_list('total', $query_data);
        $data = $this->Mcategory->get_catogory_list('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );
    }

    /**
     * 카테고리 저장
     */
    function category_add(){
        $this->load->model('Mcategory');

        $rt = $this->Mcategory->category_add($_POST['category_name']);

        if($rt == true) {
            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/category");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/web/category");
        }
    }

    /**
     * 카테고리 수정
     */
    function edit_category(){
        $this->load->model('Mcategory');

        $rt = $this->Mcategory->edit_category($_POST['no'], $_POST['category_name']);

        if($rt == true) {
            $this->pjs->alert("수정 완료");
            $this->pjs->href("/web/category");
        }else{
            $this->pjs->alert("수정 실패");
            $this->pjs->href("/web/category");
        }
    }

    /**
     * 카테고리 삭제
     */
    function delete_category($no){
        $this->load->model('Mcategory');

        $rt = $this->Mcategory->delete_category($no);

        if($rt === "error"){
            $this->pjs->alert("태그가 연결 된 상품이 존재 합니다.");
            $this->pjs->href("/web/category");
        }

        if($rt == true) {
            $this->pjs->alert("삭제 완료");
            $this->pjs->href("/web/category");
        }else{
            $this->pjs->alert("삭제 실패");
            $this->pjs->href("/web/category");
        }
    }

    /**
     * 마이페이지 수정
     */
    function edit_mypage(){
        $this->load->model('Mmypage');

        if($_SESSION['U_ID'] == "demo"){
            $this->pjs->alert("데모계정은 마이페이지 수정이 불가능 합니다.");
            $this->pjs->href("/web/mypage");
        }

        $rt = $this->Mmypage->edit_myinfo($_POST);

        if($rt === "error"){
            $this->pjs->alert("패스워드를 확인 해주세요.");
            $this->pjs->href("/web/mypage");
        }

        if($rt == true) {
            $this->pjs->alert("수정 완료");
            $this->pjs->href("/web/mypage");
        }else{
            $this->pjs->alert("수정 실패");
            $this->pjs->href("/web/mypage");
        }
    }

    /**
     * 네이버 지식쇼핑 환경설정 수정
     */
    function edit_naverconfig($mode){
        $this->load->model('Mnaver');

        if($_POST['mode'] === "company_name"){
            $update = array(
                'company_name' => $_POST['company_name']
            );

            $msg = "저장 완료";

        }else if($_POST['mode'] === "m_level"){
            $update = array(
                'm_level' => $_POST['m_level']
            );
            
            $msg = "저장 완료";
            
        }else if($_POST['mode'] === "except_market"){
            $before_except_markets_replace = preg_replace("/(\')/i","\"",$_POST['before_except_markets']);
            $before_except_markets = json_decode($before_except_markets_replace);
            $before_except_markets = (array)$before_except_markets;

            if($_POST['except_market_mode'] === "add"){
                array_push($before_except_markets, $_POST['add_market_name']);

                $msg = "추가 완료";
            }else if($_POST['except_market_mode'] === "delete"){
                if (($key = array_search($_POST['except_markets'], $before_except_markets)) !== false) {
                    unset($before_except_markets[$key]);
                }

                $before_except_markets = array_values($before_except_markets);

                $msg = "삭제 완료";
            }

            $update = array(
                'except_market' => json_encode($before_except_markets)
            );
        }

        $rt = $this->Mnaver->edit_config($update);

        if($rt == true) {
            $this->pjs->alert($msg);
            $this->pjs->href("/web/naver_shop_config");
        }else{
            $this->pjs->alert($msg);
            $this->pjs->href("/web/naver_shop_config");
        }
    }

    /**
     * 네이버 지식쇼핑 링크 추가
     */
    function add_naver_shop(){
        $this->load->model('Mnaver');

        $url = $_POST['url'];
        $url_array = parse_url($url);

        if($url_array['host'] != 'shopping.naver.com' && $url_array['host'] != 'm.shopping.naver.com'){
            $this->pjs->alert("주소가 잘못 되었습니다.");
            $this->pjs->href("/web/naver_shop_add");
        }

        $rt = $this->Mnaver->add_product($_POST);

        if($rt === "error"){
            $this->pjs->alert("데이터베이스가 초과 되었습니다.");
            $this->pjs->href("/web/naver_shop");
        }

        if($rt === "error2"){
            $this->pjs->alert("동일한 데이터가 존재합니다.");
            $this->pjs->href("/web/naver_shop");
        }

        if($rt == true) {
            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/naver_shop");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/web/naver_shop");
        }
    }

    /**
     * 네이버 지식쇼핑 리스트 불러오기
     */
    function get_naver_shop_list(){
        $this->load->model('Mnaver');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'no';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $keyword = ! empty( $datatable[ 'query' ][ 'generalSearch' ] ) ? $datatable[ 'query' ][ 'generalSearch' ] : false;
        $status = ! empty( $datatable[ 'query' ][ 'Status' ] ) ? $datatable[ 'query' ][ 'Status' ] : 'ALL';
        $category = ! empty( $datatable[ 'query' ][ 'Category' ] ) ? $datatable[ 'query' ][ 'Category' ] : 'ALL';

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'keyword' => $keyword,
            'status' => $status,
            'category' => $category
        );

        $total = $this->Mnaver->get_naver_shop_list('total', $query_data);
        $data = $this->Mnaver->get_naver_shop_list('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        //int형으로 변환
        foreach ($data as $key => $value){
            $data[$key]['no'] = (int)$data[$key]['no'];
        }

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 네이버 지식쇼핑 리스트 불러오기
     */
    function get_naver_shop_list_sub(){
        $this->load->model('Mnaver');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'product_price';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $no = ! empty( $datatable[ 'query' ][ 'no' ] ) ? $datatable[ 'query' ][ 'no' ] : false;

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'no' => $no
        );

        $total = $this->Mnaver->get_naver_shop_list_sub('total', $query_data);
        $data = $this->Mnaver->get_naver_shop_list_sub('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 네이버 지식쇼핑 삭제
     */
    function delete_naver_shop($no){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->delete_naver_shop($no);

        if($rt == true) {
            $this->pjs->alert("삭제 완료");
            $this->pjs->href("/web/naver_shop");
        }else{
            $this->pjs->alert("삭제 실패");
            $this->pjs->href("/web/naver_shop");
        }
    }

    /**
     * 네이버지식쇼핑 디테일 수정
     */
    function edit_naver_shop(){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->edit_naver_shop($_POST);

        if($rt == true) {
            $this->pjs->alert("수정 완료");
            $this->pjs->href("/web/naver_shop");
        }else{
            $this->pjs->alert("수정 실패");
            $this->pjs->href("/web/naver_shop");
        }
    }

    /**
     * 네이버지식쇼핑 업데이트
     */
    function update_naver_shop($no){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->update_product($no);

        if($rt === "error"){
            $this->pjs->alert("가격비교 페이지가 삭제 되었습니다.\\n확인 후 해당 상품건을 삭제 해주세요.");
            $this->pjs->href("/web/naver_shop");
        }

        if($rt == true) {
            $this->pjs->alert("업데이트 완료");
            $this->pjs->href("/web/naver_shop");
        }else{
            $this->pjs->alert("업데이트 실패");
            $this->pjs->href("/web/naver_shop");
        }
    }

    /**
     * 네이버지식쇼핑 알림 종료
     */
    function naver_warning_off($no){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->naver_warning_off($no);

        if($rt == true) {
            $this->pjs->alert("알림종료 완료");
            $this->pjs->href("/web/naver_shop");
        }else{
            $this->pjs->alert("알림종료 실패");
            $this->pjs->href("/web/naver_shop");
        }
    }

    /**
     * 네이버지식쇼핑 전체 업데이트
     */
    function all_update(){
        $this->load->model('Mnaver');

        //업데이트 시간 체크
        $mem_info = $this->Mnaver->get_config();
        $update_date = $mem_info[0]['naver_recent_update_date'];

        $result = (strtotime(date('Y-m-d H:i:s')) - strtotime($update_date)) / 3600;
        $result = (int) $result;

        if($result < 1){
            $msg = "전체 업데이트는 한시간에 한번 가능 합니다.\n최종업데이트날짜 :".$update_date;

            echo $msg;
            return false;
        }

        $data = $this->Mnaver->get_naver_product_nos();

        foreach ($data as $key => $value){
            $rt = $this->Mnaver->update_product($value['no']);
        }

        $rt = $this->Mnaver->update_udate();

        if($rt == true) {
            $msg = "업데이트 완료";
            echo $msg;
            return false;
        }else{
            $msg = "업데이트 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 네이버가격비교 메모 저장
     */
    function save_memo(){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->memo_update($_POST);

        if($rt == true) {
            $msg = "수정 완료";
            echo $msg;
            return false;
        }else{
            $msg = "수정 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 네이버 키워드 추가
     */
    function add_naver_keyword(){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->add_keyword($_POST);

        if($rt === "error"){
            $this->pjs->alert("데이터베이스가 초과 되었습니다.");
            $this->pjs->href("/web/naver_shop");
        }

        if($rt === "error2"){
            $this->pjs->alert("동일한 데이터가 존재합니다.");
            $this->pjs->href("/web/naver_keyword");
        }

        if($rt == true) {
            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/naver_keyword");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/web/naver_keyword");
        }
    }

    /**
     * 네이버 키워드 리스트 불러오기
     */
    function get_naver_keyword_list(){
        $this->load->model('Mnaver');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'no';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $keyword = ! empty( $datatable[ 'query' ][ 'generalSearch' ] ) ? $datatable[ 'query' ][ 'generalSearch' ] : false;
        $status = ! empty( $datatable[ 'query' ][ 'Status' ] ) ? $datatable[ 'query' ][ 'Status' ] : 'ALL';
        $category = ! empty( $datatable[ 'query' ][ 'Category' ] ) ? $datatable[ 'query' ][ 'Category' ] : 'ALL';

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'keyword' => $keyword,
            'status' => $status,
            'category' => $category
        );

        $total = $this->Mnaver->get_naver_keyword_list('total', $query_data);
        $data = $this->Mnaver->get_naver_keyword_list('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        //int형으로 변환
        foreach ($data as $key => $value){
            $data[$key]['no'] = (int)$data[$key]['no'];
        }

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 네이버 키워드 리스트 불러오기
     */
    function get_naver_keyword_list_sub(){
        $this->load->model('Mnaver');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'no';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $no = ! empty( $datatable[ 'query' ][ 'no' ] ) ? $datatable[ 'query' ][ 'no' ] : false;

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'no' => $no
        );

        $total = $this->Mnaver->get_naver_keyword_list_sub('total', $query_data);
        $data = $this->Mnaver->get_naver_keyword_list_sub('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 네이버 키워드 삭제
     */
    function delete_naver_keyword($no){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->delete_naver_keyword($no);

        if($rt == true) {
            $this->pjs->alert("삭제 완료");
            $this->pjs->href("/web/naver_keyword");
        }else{
            $this->pjs->alert("삭제 실패");
            $this->pjs->href("/web/naver_keyword");
        }
    }

    /**
     * 네이버 키워드 메모 저장
     */
    function save_keyword_memo(){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->keyword_memo_update($_POST);

        if($rt == true) {
            $msg = "수정 완료";
            echo $msg;
            return false;
        }else{
            $msg = "수정 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 네이버 키워드 디테일 수정
     */
    function edit_naver_keyword(){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->edit_naver_keyword($_POST);

        $rt = $this->Mnaver->update_keyword($_POST['no']);

        if($rt == true) {
            $this->pjs->alert("수정 완료");
            $this->pjs->href("/web/naver_keyword");
        }else{
            $this->pjs->alert("수정 실패");
            $this->pjs->href("/web/naver_keyword");
        }
    }

    /**
     * 네이버 키워드 업데이트
     */
    function update_naver_keyword($no){
        $this->load->model('Mnaver');

        $rt = $this->Mnaver->update_keyword($no);

        if($rt == true) {
            $this->pjs->alert("업데이트 완료");
            $this->pjs->href("/web/naver_keyword");
        }else{
            $this->pjs->alert("업데이트 실패");
            $this->pjs->href("/web/naver_keyword");
        }
    }

    /**
     * 네이버 키워드 전체 업데이트
     */
    function all_keyword_update(){
        $this->load->model('Mnaver');

        //업데이트 시간 체크
        $mem_info = $this->Mnaver->get_config();
        $update_date = $mem_info[0]['naver_keyword_recent_update_date'];

        $result = (strtotime(date('Y-m-d H:i:s')) - strtotime($update_date)) / 3600;
        $result = (int) $result;

        if($result < 1){
            $msg = "전체 업데이트는 한시간에 한번 가능 합니다.\n최종업데이트날짜 :".$update_date;

            echo $msg;
            return false;
        }

        $data = $this->Mnaver->get_keyword_product_nos();

        foreach ($data as $key => $value){
            $rt = $this->Mnaver->update_keyword($value['no']);
        }

        $rt = $this->Mnaver->update_keyword_udate();

        if($rt == true) {
            $msg = "업데이트 완료";
            echo $msg;
            return false;
        }else{
            $msg = "업데이트 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 네이버 키워드 환경설정 수정
     */
    function edit_naver_keyword_config($mode){
        $this->load->model('Mnaver');

        if($_POST['mode'] === "keyword_company_name"){
            $update = array(
                'keyword_company_name' => $_POST['keyword_company_name']
            );

            $msg = "저장 완료";

        }

        $rt = $this->Mnaver->edit_config($update);

        if($rt == true) {
            $this->pjs->alert($msg);
            $this->pjs->href("/web/naver_keyword_config");
        }else{
            $this->pjs->alert($msg);
            $this->pjs->href("/web/naver_keyword_config");
        }
    }

    /**
     * 디테일 중심상품 등록
     */
    function add_detail_shop(){
        $this->load->model('Mdetail');

        $url = $_POST['url'];
        $url_array = parse_url($url);

        if($url_array['host'] != 'storefarm.naver.com' && $url_array['host'] != 'm.storefarm.naver.com'){
            $this->pjs->alert("주소가 잘못 되었습니다.");
            $this->pjs->href("/web/detail_shop_add");
        }

        $rt = $this->Mdetail->add_product($_POST);
        if($rt){
            $_POST['no'] = $rt;
            $rt = $this->Mdetail->add_sub_product($_POST);
        }

        if($rt == true) {
            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/detail_shop");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/web/detail_shop_add");
        }
    }

    /**
     * 디테일 하위상품 등록
     */
    function add_detail_shop_sub(){
        $this->load->model('Mdetail');

        $url = $_POST['url'];
        $url_array = parse_url($url);

        if($url_array['host'] != 'storefarm.naver.com' && $url_array['host'] != 'm.storefarm.naver.com'){
            $this->pjs->alert("주소가 잘못 되었습니다.");
            $this->pjs->href("/web/detail_shop_add");
        }

        $rt = $this->Mdetail->add_sub_product($_POST);

        if($rt === "error"){
            $this->pjs->alert("데이터베이스가 초과 되었습니다.");
            $this->pjs->href("/web/detail_shop");
        }

        if($rt == true) {
            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/detail_shop");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/web/detail_shop_sub_add/".$_POST['no']);
        }
    }

    /**
     * 디테일경쟁사 리스트 불러오기
     */
    function get_detail_shop_list(){
        $this->load->model('Mdetail');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'no';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $keyword = ! empty( $datatable[ 'query' ][ 'generalSearch' ] ) ? $datatable[ 'query' ][ 'generalSearch' ] : false;
        $status = ! empty( $datatable[ 'query' ][ 'Status' ] ) ? $datatable[ 'query' ][ 'Status' ] : 'ALL';
        $category = ! empty( $datatable[ 'query' ][ 'Category' ] ) ? $datatable[ 'query' ][ 'Category' ] : 'ALL';

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'keyword' => $keyword,
            'status' => $status,
            'category' => $category
        );

        $total = $this->Mdetail->get_detail_shop_list('total', $query_data);
        $data = $this->Mdetail->get_detail_shop_list('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        //int형으로 변환
        foreach ($data as $key => $value){
            $data[$key]['no'] = (int)$data[$key]['no'];
        }

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 네이버 지식쇼핑 리스트 불러오기
     */
    function get_detail_shop_list_sub(){
        $this->load->model('Mdetail');

        $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();

        $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'asc';
        $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'price';
        $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
        $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : 10;
        $no = ! empty( $datatable[ 'query' ][ 'no' ] ) ? $datatable[ 'query' ][ 'no' ] : false;

        $query_data = array(
            'page'    => $page,  // 선택 페이지
            'pages' => $perpage, // 노출수
            'sort'  => $sort,
            'field' => $field,
            'no' => $no
        );

        $total = $this->Mdetail->get_detail_shop_list_sub('total', $query_data);
        $data = $this->Mdetail->get_detail_shop_list_sub('list',$query_data);

        $meta = array(
            'page'    => $page,  // 선택 페이지
            'pages'   => $perpage, // 노출 수
            'perpage' => $perpage, // 페이징 나누기
            'total'   => $total[0]['total'], // 전체 데이터 수
        );

        $result = array(
            'meta' => $meta + array(
                    'sort'  => $sort,
                    'field' => $field,
                ),
            'data' => $data,
        );

        header( 'Content-Type: application/json' );
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
        header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );

        echo json_encode( $result, JSON_PRETTY_PRINT );

    }

    /**
     * 디테일페이지 대표상품 수정
     */
    function edit_detail_shop(){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->edit_detail_shop($_POST);

        if($rt == true) {
            $this->pjs->alert("수정 완료");
            $this->pjs->href("/web/detail_shop");
        }else{
            $this->pjs->alert("수정 실패");
            $this->pjs->href("/web/detail_shop");
        }
    }

    /**
     * 디테일 삭제
     */
    function delete_detail_shop($no){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->delete_detail_shop($no);

        if($rt == true) {
            $this->pjs->alert("삭제 완료");
            $this->pjs->href("/web/detail_shop");
        }else{
            $this->pjs->alert("삭제 실패");
            $this->pjs->href("/web/detail_shop");
        }
    }

    /**
     * 디테일 메모 저장
     */
    function save_detail_memo(){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->detail_memo_update($_POST);

        if($rt == true) {
            $msg = "수정 완료";
            echo $msg;
            return false;
        }else{
            $msg = "수정 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 디테일 메모 저장
     */
    function save_detail_memo_sub(){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->detail_memo_sub_update($_POST);

        if($rt == true) {
            $msg = "수정 완료";
            echo $msg;
            return false;
        }else{
            $msg = "수정 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 디테일 업데이트
     */
    function update_detail_shop($no){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->update_detail($no);

        if($rt === "error"){
            $this->pjs->alert("페이지가 삭제 되었습니다.\\n확인 후 해당 상품건을 삭제 해주세요.");
            $this->pjs->href("/web/naver_shop");
        }

        if($rt == true) {
            $this->pjs->alert("업데이트 완료");
            $this->pjs->href("/web/detail_shop");
        }else{
            $this->pjs->alert("업데이트 실패");
            $this->pjs->href("/web/detail_shop");
        }
    }

    /**
     * 디테일 알림 종료
     */
    function detail_warning_off(){
        $this->load->model('Mdetail');

        $rt = $this->Mdetail->detail_warning_off($_POST['no']);

        if($rt == true) {
            $msg = "알림종료 완료";
            echo $msg;
            return false;
        }else{
            $msg = "알림종료 실패";
            echo $msg;
            return false;
        }
    }

    /**
     * 네이버지식쇼핑 전체 업데이트
     */
    function all_update_detail_shop(){
        $this->load->model('Mnaver');
        $this->load->model('Mdetail');

        //업데이트 시간 체크
        $mem_info = $this->Mnaver->get_config();
        $update_date = $mem_info[0]['deatil_shop_update_date'];

        $result = (strtotime(date('Y-m-d H:i:s')) - strtotime($update_date)) / 3600;
        $result = (int) $result;

        if($result < 1){
            $msg = "전체 업데이트는 한시간에 한번 가능 합니다.\n최종업데이트날짜 :".$update_date;

            echo $msg;
            return false;
        }

        $data = $this->Mdetail->get_detail_shop_sub_nos();

        foreach ($data as $key => $value){
            $rt = $this->Mdetail->update_detail($value['no']);
        }

        $rt = $this->Mdetail->update_udate();

        if($rt == true) {
            $msg = "업데이트 완료";
            echo $msg;
            return false;
        }else{
            $msg = "업데이트 실패";
            echo $msg;
            return false;
        }
    }
}
