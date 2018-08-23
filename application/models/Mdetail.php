<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 5:02
 */

class Mdetail extends CI_Model {
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
        $this->load->library('scrap');

        $this->table = array();
        if(isset($_SESSION['U_ID'])){
            $this->table['detail_shop_product'] = "udb_".$_SESSION['U_ID'].".detail_shop_product";
            $this->table['detail_shop_product_sub'] = "udb_".$_SESSION['U_ID'].".detail_shop_product_sub";
            $this->table['detail_shop_product_log'] = "udb_".$_SESSION['U_ID'].".detail_shop_product_log";
            $this->table['category'] = "udb_".$_SESSION['U_ID'].".category";
        }

    }

    //-----------------------------------------------------------------------------
    //  페이지 상품 등록
    //-----------------------------------------------------------------------------
    function add_product($prodInfo){

        $shop_info = $this->scrap->search_storefarm($prodInfo['url']);

        if($shop_info['prod_name'] == ""){
            return false;
        }

        $insert = array(
            'category_no'	=> $prodInfo['category'],
            'shop_link'	=> $prodInfo['url'],
            'memo'	=> $prodInfo['memo'],
            'img_src'	=> $shop_info['img_src'],
            'price'	=> $shop_info['price'],
            'delivery_cost'	=> $shop_info['deli_cost']
        );

        if($prodInfo['name_check'] == "on"){
            $insert['product_name'] = $shop_info['prod_name'];
        }else{
            $insert['product_name'] = $prodInfo['product_name'];
        }

        $this->udb->set($insert);
        $rt = $this->udb->insert($this->table['detail_shop_product']);

        $no = $this->udb->insert_id();

        return $no;
    }

    //-----------------------------------------------------------------------------
    //  페이지 서브 상품 등록
    //-----------------------------------------------------------------------------
    function add_sub_product($prodInfo){

        //DB수 체크
        $sql = "select count(*) as total from ".$this->table['detail_shop_product_sub'];
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        if($result[0]['total'] >= $_SESSION['DETAIL_LIMIT_DB']){
            return 'error';
        }

        $shop_info = $this->scrap->search_storefarm($prodInfo['url']);

        if($shop_info['prod_name'] == ""){
            return false;
        }

        $insert = array(
            'product_no'	=> $prodInfo['no'],
            'shop_link'	=> $prodInfo['url'],
            'memo'	=> $prodInfo['memo'],
            'company_name'	=> $shop_info['company_name'],
            'price'	=> $shop_info['price'],
            'delivery_cost'	=> $shop_info['deli_cost']
        );

        $this->udb->set($insert);
        $rt = $this->udb->insert($this->table['detail_shop_product_sub']);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  디테일 리스트 불러오기
    //-----------------------------------------------------------------------------
    function get_detail_shop_list($mode, $query_data) {
        //limit $start, $end 설정
        $start = ($query_data['page'] - 1) * 10;
        $end = $query_data['pages'];
        $limit = " limit ".$start.",".$end;

        //sort 설정
        if($query_data['field'] == "category_name"){
            $orderby = " order by b.".$query_data['field']." ".$query_data['sort'];
        }else{
            $orderby = " order by a.".$query_data['field']." ".$query_data['sort'];
        }

        //검색어 설정
        $where = "";
        if($query_data['keyword']){
            $where .= " AND (a.product_name like '%".$query_data['keyword']."%' OR b.category_name like '%".$query_data['keyword']."%' OR a.memo like '%".$query_data['keyword']."%')";
        }

        //알림상태
        if($query_data['status'] != "ALL"){
            $where .= " AND warning = '".$query_data['status']."'";
        }

        //태그
        if($query_data['category'] != "ALL"){
            $where .= " AND category_no = ".$query_data['category'];
        }

        if($mode === 'total'){
            $field = "count(*) as total";
            $limit = " limit 1";
        }else if($mode === 'list'){
            $field = "a.*, b.category_name";
        }

        $sql = "select ".$field." from ".$this->table['detail_shop_product']." as a left join ".$this->table['category']." as b on (category_no = b.no) where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  디테일 리스트 서브 불러오기
    //-----------------------------------------------------------------------------
    function get_detail_shop_list_sub($mode, $query_data) {

        //limit $start, $end 설정
        $start = ($query_data['page'] - 1) * 10;
        $end = $query_data['pages'];
        $limit = " limit ".$start.",".$end;

        //sort 설정
        $orderby = " order by ".$query_data['field']." ".$query_data['sort'];

        //where 설정
        $where = " AND product_no = ".$query_data['no'];

        if($mode === 'total'){
            $field = "count(*) as total";
            $limit = " limit 1";
        }else if($mode === 'list'){
            $field = "*";
        }

        $sql = "select ".$field." from ".$this->table['detail_shop_product_sub']." where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  디테일정보 불러오기
    //-----------------------------------------------------------------------------
    function get_shop_detail($no) {
        $sql = "select no, product_name, category_no, memo from ".$this->table['detail_shop_product']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    // 디테일 대표상품 수정
    //-----------------------------------------------------------------------------
    function edit_detail_shop($post) {

        $update = array(
            'product_name' => $post['product_name'],
            'category_no' => $post['category'],
            'memo' => $post['memo']
        );

        $this->udb->where('no', $post['no']);
        $rt = $this->udb->update($this->table['detail_shop_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  디테일 대표상품 삭제
    //-----------------------------------------------------------------------------
    function delete_detail_shop($no) {
        $sql = "delete from ".$this->table['detail_shop_product']." where no in (".$no.")";
        $rt = $this->udb->query( $sql );

        if($rt){
            $sql = "delete from ".$this->table['detail_shop_product_sub']." where product_no in (".$no.")";
            $rt = $this->udb->query( $sql );
        }

        return $rt;
    }

    //-----------------------------------------------------------------------------
    // 디테일 메모 업데이트
    //-----------------------------------------------------------------------------
    function detail_memo_update($info) {
        $update = array(
            'memo'	=> $info['memo']
        );

        $this->udb->where('no', $info['no']);
        $rt = $this->udb->update($this->table['detail_shop_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    // 디테일 메모 서브 업데이트
    //-----------------------------------------------------------------------------
    function detail_memo_sub_update($info) {
        $update = array(
            'memo'	=> $info['memo']
        );

        $this->udb->where('no', $info['no']);
        $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  페이지 상품 업데이트
    //-----------------------------------------------------------------------------
    function update_detail($no){
        // 정보 가져오기
        $sql = "select product_no ,shop_link, price, delivery_cost, change_count from ".$this->table['detail_shop_product_sub']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $info = $qr->result_array();

        $shop_info = $this->scrap->search_storefarm($info[0]['shop_link']);

        if($shop_info['prod_name'] == ""){
            return "error";
        }

        //정보 다른지 체크
        $content = "";

        if($shop_info['price'] != $info[0]['price']){
            $content .= "[가격변동] ".$info[0]['price']."원 => ".$shop_info['price']."원";
        }

        if($shop_info['deli_cost'] != $info[0]['delivery_cost']){
            if($content != ""){
                $content .= "<br>";
            }

            $content .= "[택배비변동] ".$info[0]['delivery_cost']."원 => ".$shop_info['deli_cost']."원";
        }

        //정보 다른경우 업데이트
        if($content != ""){
            $update = array(
                'warning'	=> "Y",
                'price'	=> $shop_info['price'],
                'delivery_cost'	=> $shop_info['deli_cost'],
                'change_count'	=> $info[0]['change_count'] + 1,
            );

            $this->udb->where('no', $no);
            $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);

            //상위 변동상태 변경
            $update = array(
                'warning'	=> "Y",
            );

            $this->udb->where('no', $info[0]['product_no']);
            $rt = $this->udb->update($this->table['detail_shop_product'], $update);

            //로그 등록
            $insert = array(
                'product_no'	=> $no,
                'contents'	=> $content
            );

            $this->udb->set($insert);
            $this->udb->insert($this->table['detail_shop_product_log']);
        }


        //업데이트 시간 업데이트
        $update = array(
            'update_date'	=> date("Y-m-d H:i:s"),
        );

        $this->udb->where('no', $no);
        $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  디테일 로그 가져오기
    //-----------------------------------------------------------------------------
    function get_log($no) {
        $sql = "select * from ".$this->table['detail_shop_product_log']." where product_no = ".$no." order by wdate desc";

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  디테일 알림 끄기
    //-----------------------------------------------------------------------------
    function detail_warning_off($no) {
        $update = array(
            'warning'	=> "N",
        );

        $this->udb->where('no', $no);
        $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);

        $sql = "select product_no from ".$this->table['detail_shop_product_sub']." where no = ".$no;
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        $product_no = $result[0]['product_no'];

        $sql = "select count(*) as total from ".$this->table['detail_shop_product_sub']." where warning = 'Y' AND product_no = ".$product_no;
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        if($result[0]['total'] == 0){
            $update = array(
                'warning'	=> "N",
            );

            $this->udb->where('no', $product_no);
            $rt = $this->udb->update($this->table['detail_shop_product'], $update);
        }

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  디테일 sub no 가져오기
    //-----------------------------------------------------------------------------
    function get_detail_shop_sub_nos() {
        $sql = "select no from ".$this->table['detail_shop_product_sub'];

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //   업데이트 시간 업데이트
    //-----------------------------------------------------------------------------
    function update_udate() {
        $update = array(
            'deatil_shop_update_date'	=> date("Y-m-d H:i:s")
        );

        $this->adb->where('id', $_SESSION['U_ID']);
        $rt = $this->adb->update('member', $update);

        return $rt;
    }
}