<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guide extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // 헬퍼
        $this->load->helper('common');

        // 라이브러리
        $this->load->library('pjs');

        $this->load->view('guide/_head');
    }

    function index()
    {
        $this->load->view('guide/main');
    }

    function main()
    {
        $this->load->view('guide/main');
    }

    function tag()
    {
        $this->load->view('guide/tag');
    }

    function naver_price()
    {
        $this->load->view('guide/naver_price');
    }

    function naver_keyword()
    {
        $this->load->view('guide/naver_keyword');
    }

    function detail()
    {
        $this->load->view('guide/detail');
    }
}
