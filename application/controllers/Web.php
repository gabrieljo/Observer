<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Controller {

    var $default_listing = 10;

    public function __construct()
    {
        parent::__construct();

        // 헬퍼
        $this->load->helper('common');

        // 라이브러리
        $this->load->library('pjs');

        //모델
        $this->load->model('Mnaver');

        //세션확인을 위한 경로 확인
        $path_explode = explode("/",$_SERVER["REQUEST_URI"]);
        $mode = $path_explode[2];

        if(!isset( $_SESSION['U_ID'] )) { //로그인이 안되어있고
            if($mode != "login") { // 로그인 페이지가 아닌경우
                $this->pjs->href("/web/login");
            }
        }else{ //로그인이 되어있고
            if($_SESSION['END_DATE'] < date("Y-m-d H:i:s")){
                $this->pjs->alert("사용기간이 만료 되었습니다.");
                $this->pjs->href("/web_act/logout");
            }

            if($mode == "main"){
                $title = "메인";
            }else if($mode == "naver_shop" || $mode == "naver_shop_add" || $mode == "naver_shop_edit" || $mode == "naver_shop_log" || $mode == "naver_shop_config"){
                $title = "네이버 가격비교";
            }else if($mode == "naver_keyword" || $mode == "naver_keyword_add" || $mode == "naver_keyword_config" || $mode == "naver_keyword_edit"){
                $title = "네이버 키워드";
            }else if($mode == "detail_shop" || $mode == "detail_shop_add" || $mode == "detail_shop_sub_add" || $mode == "detail_shop_edit" || $mode == "detail_shop_log"){
                $title = "경쟁사 감시";
            }else if($mode == "category" || $mode == "category_add" || $mode == "edit_category"){
                $title = "태그 관리";
            }else{
                $title = "Running";
            }

            // 알림수 가져오기
            $total_warning = $this->Mnaver->total_warning();
            $naver_total_warning = $total_warning[0]['total'];

            $this->load->view('web/_head',array('title' => $title, 'naver_total_warning' => $naver_total_warning));
        }

    }

    function index()
    {
        $this->pjs->href("web/main");
    }

    /**
     * 메인
     */
    function main()
    {
        $this->load->view('web/main');
    }

    /**
     * 로그인
     */
    function login()
    {
        if($_SESSION['U_ID'] != ""){
            $this->pjs->href("/web/main");
        }

        $this->load->view('web/login');
    }

    /**
     * 네이버 지식쇼핑 리스트
     */
    function naver_shop()
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();


        $this->load->view('web/naver_shop_list',array('categorys' => $categorys));
    }

    /**
     * 카테고리 리스트
     */
    function category()
    {
        $this->load->view('web/category_list');
    }

    /**
     * 카테고리 추가
     */
    function category_add()
    {
        $this->load->view('web/category_add');
    }

    /**
     * 카테고리 수정
     */
    function edit_category($no)
    {
        $this->load->model('Mcategory');

        $data = $this->Mcategory->get_category_detail($no);
        if(count($data) === 0){
            $this->pjs->alert("데이터가 없습니다.");
            $this->pjs->href("/web/category");
        }

        $this->load->view('web/category_edit',array('data' => $data, 'no' => $no));
    }

    /**
     * 마이페이지
     */
    function mypage()
    {
        $this->load->model('Mmypage');

        $data = $this->Mmypage->get_myinfo();
        if(count($data) === 0){
            $this->pjs->alert("담당자에 문의 바랍니다.");
            $this->pjs->href("/web/main");
        }

        $this->load->view('web/mypage',array('data' => $data[0]));
    }

    /**
     * 네이버 지식쇼핑 환경설정
     */
    function naver_shop_config()
    {
        $this->load->model('Mnaver');

        $data = $this->Mnaver->get_config();
        if(count($data) === 0){
            $this->pjs->alert("담당자에 문의 바랍니다.");
            $this->pjs->href("/web/main");
        }

        $m_level = $data[0]['m_level'];
        $except_markets = json_decode($data[0]['except_market']);

        $this->load->view('web/naver_shop_config',array('m_level' => $m_level, 'except_markets' => $except_markets, 'before_except_markets' => $data[0]['except_market'], 'company_name' => $data[0]['company_name']));
    }

    /**
     * 네이버 지식쇼핑 페이지 등록
     */
    function naver_shop_add()
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();
        $this->load->view('web/naver_shop_add', array('categorys' => $categorys));
    }

    /**
     * 네이버 지식쇼핑 페이지 수정
     */
    function naver_shop_edit($no)
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        //디테일정보 불러오기
        $detail = $this->Mnaver->get_detail($no);

        $this->load->view('web/naver_shop_edit', array('categorys' => $categorys, 'detail' => $detail[0]));
    }

    /**
     * 네이버 로그페이지
     */
    function naver_shop_log($no)
    {
        $this->load->model('Mnaver');

        $data = $this->Mnaver->get_log($no);

        $this->load->view('web/naver_shop_log', array('data' => $data));
    }

    /**
     * 네이버 지식쇼핑 키워드 등록
     */
    function naver_keyword_add()
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        $this->load->view('web/naver_keyword_add', array('categorys' => $categorys));
    }

    /**
     * 네이버 키워드 리스트
     */
    function naver_keyword()
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        $this->load->view('web/naver_keyword_list',array('categorys' => $categorys));
    }

    /**
     * 네이버 지식쇼핑 키워드 수정
     */
    function naver_keyword_edit($no)
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        //디테일정보 불러오기
        $detail = $this->Mnaver->get_keyword_detail($no);

        $this->load->view('web/naver_keyword_edit', array('categorys' => $categorys, 'detail' => $detail[0]));
    }

    /**
     * 네이버 키워드 환경설정
     */
    function naver_keyword_config()
    {
        $this->load->model('Mnaver');

        $data = $this->Mnaver->get_config();

        if(count($data) === 0){
            $this->pjs->alert("담당자에 문의 바랍니다.");
            $this->pjs->href("/web/main");
        }

        $this->load->view('web/naver_keyword_config',array('keyword_company_name' => $data[0]['keyword_company_name']));
    }

    /**
     * 디테일페이지 등록
     */
    function detail_shop_add()
    {
        $this->load->model('Mnaver');
        $this->load->model('Mdetail');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        $this->load->view('web/detail_shop_add', array('categorys' => $categorys));
    }

    /**
     * 디테일 서브 페이지 등록
     */
    function detail_shop_sub_add($no)
    {
        $this->load->view('web/detail_shop_sub_add', array('no' => $no));
    }

    /**
     * 디테일페이지 리스트
     */
    function detail_shop()
    {
        $this->load->model('Mnaver');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        $this->load->view('web/detail_shop_list',array('categorys' => $categorys));
    }

    /**
     * 디테일페이지 수정
     */
    function detail_shop_edit($no)
    {
        $this->load->model('Mnaver');
        $this->load->model('Mdetail');

        //카테고리 불러오기
        $categorys = $this->Mnaver->get_categorys();

        //디테일정보 불러오기
        $detail = $this->Mdetail->get_shop_detail($no);

        $this->load->view('web/detail_shop_edit', array('categorys' => $categorys, 'detail' => $detail[0]));
    }

    /**
     * 디테일 로그페이지
     */
    function detail_shop_log($no)
    {
        $this->load->model('Mdetail');

        $data = $this->Mdetail->get_log($no);

        $this->load->view('web/detail_shop_log', array('data' => $data));
    }
}
