<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    var $default_listing = 10;

    public function __construct()
    {
        parent::__construct();

        // 헬퍼
        $this->load->helper('common');

        // 라이브러리
        $this->load->library('pjs');

    }

    function index()
    {
        $this->load->view('main/index');
    }

    function join()
    {
        $this->load->view('main/join');
    }

}
