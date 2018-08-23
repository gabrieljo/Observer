<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 5:02
 */

class Mcategory extends CI_Model {
    // 생성자
    function __construct()
    {
        parent::__construct();

        $this->adb = $this->load->database('adb', TRUE);

        if(isset($_SESSION['U_DB'])){
            $udb = $_SESSION['U_DB'];
        }else{
            $udb = "udb";
        }

        $this->udb = $this->load->database($udb, TRUE);

        $this->table = array();
        $this->table['category'] = "udb_".$_SESSION['U_ID'].".category";
        $this->table['naver_shop_product'] = "udb_".$_SESSION['U_ID'].".naver_shop_product";
        $this->table['naver_keyword_product'] = "udb_".$_SESSION['U_ID'].".naver_keyword_product";

    }

    //-----------------------------------------------------------------------------
    //  카테고리 리스트 불러오기
    //-----------------------------------------------------------------------------
    function get_catogory_list($mode, $query_data) {
        //limit $start, $end 설정
        $start = ($query_data['page'] - 1) * 10;
        $end = $query_data['pages'];
        $limit = " limit ".$start.",".$end;

        //sort 설정
        $orderby = " order by ".$query_data['field']." ".$query_data['sort'];

        //검색어 설정
        $where = "";
        if($query_data['keyword']){
            $where .= " AND category_name like '%".$query_data['keyword']."%'";
        }

        if($mode === 'total'){
            $field = "count(*) as total";
            $limit = " limit 1";
        }else if($mode === 'list'){
            $field = "*";
        }

        $sql = "select ".$field." from ".$this->table['category']." where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  카테고리 저장
    //-----------------------------------------------------------------------------
    function category_add($category_name) {

        $insert = array(
            'category_name'	=> $category_name
        );

        $this->udb->set($insert);
        $rt = $this->udb->insert($this->table['category']);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  카테고리 디테일정보 가져오기
    //-----------------------------------------------------------------------------
    function get_category_detail($no) {

        $sql = "select category_name from ".$this->table['category']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  카테고리 수정
    //-----------------------------------------------------------------------------
    function edit_category($no, $category_name) {

        $update = array(
            'category_name'	 => $category_name
        );

        $this->udb->where('no', $no);
        $rt = $this->udb->update($this->table['category'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  카테고리 삭제
    //-----------------------------------------------------------------------------
    function delete_category($no) {
        $sql = "select count(*) as total from ".$this->table['naver_shop_product']." where category_no = ".$no;
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();
        $flag = false;

        if($result[0]['total'] > 0){
            $flag = true;
        }

        $sql = "select count(*) as total from ".$this->table['naver_keyword_product']." where category_no = ".$no;
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();
        $flag = false;

        if($result[0]['total'] > 0){
            $flag = true;
        }

        if($flag){
            return 'error';
        }else{
            $sql = "delete from ".$this->table['category']." where no in (".$no.")";
            $rt = $this->udb->query( $sql );
            return $rt;
        }
    }
}