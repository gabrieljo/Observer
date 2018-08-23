<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_act extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // 헬퍼
        $this->load->helper('common');

        // 라이브러리
        $this->load->library('pjs');
        $this->load->library('scrap');
    }

    /**
     * 회원가입
     */
    function join(){
        $this->load->model('Mmember');

        //아이디 중복체크 확인
        $rt = $this->Mmember->check_id($_POST['id']);

        if($rt['total'] > 0){
            $this->pjs->alert("이미 존재하는 계정 입니다.");
            $this->pjs->href("/main/join");
            return false;
        }

        $insert = array();
        $insert['wip'] = $_SERVER["REMOTE_ADDR"];
        $insert['end_date'] = date("Y-m-d",strtotime ("+30 days"));
        $insert['name'] = $_POST['company_name'];
        $insert['company_name'] = $_POST['company_name'];
        $insert['keyword_company_name'] = $_POST['company_name'];
        $insert['id'] = $_POST['id'];
        $insert['company_number'] = $_POST['company_number'];
        $insert['tel'] = $_POST['tel'];
        $insert['email'] = $_POST['email'];
        $insert['db'] = 'udb';

        $rt = $this->Mmember->add_member($insert,$_POST['pw']);

        if($rt){
            //디비 및 테이블추가
            $db_name = "udb_".$_POST['id'];

            $this->Mmember->create_database($db_name);

            //테이블 추가
            $this->Mmember->create_table($db_name, $insert['db']);

            $this->pjs->alert("등록 완료");
            $this->pjs->href("/web/login");
        }else{
            $this->pjs->alert("등록 실패");
            $this->pjs->href("/main/join");
        }
    }

    /**
     * 이메일전송
     */
    function send_mail(){

    }
}
