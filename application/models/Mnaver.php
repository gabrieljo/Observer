<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 5:02
 */

class Mnaver extends CI_Model {
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
        $this->load->library('naver');

        $this->table = array();
        if(isset($_SESSION['U_ID'])){
            $this->table['naver_keyword_product'] = "udb_".$_SESSION['U_ID'].".naver_keyword_product";
            $this->table['naver_keyword_product_sub'] = "udb_".$_SESSION['U_ID'].".naver_keyword_product_sub";

            $this->table['naver_shop_product'] = "udb_".$_SESSION['U_ID'].".naver_shop_product";
            $this->table['naver_shop_product_sub'] = "udb_".$_SESSION['U_ID'].".naver_shop_product_sub";
            $this->table['naver_shop_update_log'] = "udb_".$_SESSION['U_ID'].".naver_shop_update_log";
            $this->table['category'] = "udb_".$_SESSION['U_ID'].".category";
        }

    }

    //-----------------------------------------------------------------------------
    //  환경설정 정보 불러오기
    //-----------------------------------------------------------------------------
    function get_config() {
        $sql = "select naver_keyword_recent_update_date, naver_recent_update_date, deatil_shop_update_date, except_market, m_level, keyword_company_name, company_name from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  환경설정 수정
    //-----------------------------------------------------------------------------
    function edit_config($update) {

        $this->adb->where('id', $_SESSION['U_ID']);
        $rt = $this->adb->update('member', $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  카테고리 정보 가져오기
    //-----------------------------------------------------------------------------
    function get_categorys() {

        $sql = "select no, category_name from ".$this->table['category'];

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  페이지 상품 등록
    //-----------------------------------------------------------------------------
    function add_product($prodInfo){
        //DB수 체크
        $sql = "select count(*) as total from ".$this->table['naver_shop_product'];
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        if($result[0]['total'] >= $_SESSION['LIMIT_DB']){
            return 'error';
        }

        $url_parse = parse_url($prodInfo['url']);
        parse_str($url_parse['query'],$get_array);
        $nv_mid = $get_array['nv_mid'];

        //중복체크
        $sql = "select count(*) as total from ".$this->table['naver_shop_product']." where nv_mid = '".$nv_mid."'";
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        if($result[0]['total'] > 0){
            return 'error2';
        }

        $shop_info = $this->scrap->search_naver($prodInfo['url']);

        if($shop_info['product_name'] == ""){
            return "error";
        }

        // 예외마켓 배열에서 삭제
        $sql = "select except_market from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();
        $except_market_list = json_decode($result[0]['except_market']);

        $new_shop_info = $this->naver->array_check($shop_info, $except_market_list);
        
        //업체순위 체크
        $sql = "select company_name from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        $company_name = $result[0]['company_name'];
        $array_key = array_search($company_name,$new_shop_info['names']);

        if($array_key !== false) {
            $array_key = $array_key + 1;
        }else{
            $array_key = 0;
        }

        $insert = array(
            'category_no'	=> $prodInfo['category'],
            'shop_link'	=> $prodInfo['url'],
            'nv_mid'	=> $nv_mid,
            'memo'	=> $prodInfo['memo'],
            'img_src'	=> $new_shop_info['img_src'],
            'first_company'	=> $new_shop_info['names'][0],
            'first_price'	=> $new_shop_info['prices'][0],
            'first_delivery_cost'	=> $new_shop_info['deli_costs'][0],
            'second_company'	=> $new_shop_info['names'][1],
            'second_price'	=> $new_shop_info['prices'][1],
            'second_delivery_cost'	=> $new_shop_info['deli_costs'][1],
            'my_rank' => $array_key
        );

        if($prodInfo['name_check'] == "on"){
            $insert['product_name'] = $new_shop_info['product_name'];
        }else{
            $insert['product_name'] = $prodInfo['product_name'];
        }

        $this->udb->set($insert);
        $rt = $this->udb->insert($this->table['naver_shop_product']);

        if($rt){ // sub 등록
            $no = $this->udb->insert_id();

            for($i=0; $i<sizeof($new_shop_info['names']); $i++){
                $insert = array(
                    'product_no'	=> $no,
                    'company_name'	=> $new_shop_info['names'][$i],
                    'product_price'	=> $new_shop_info['prices'][$i],
                    'delivery_cost'	=> $new_shop_info['deli_costs'][$i],
                    'site_href'	=> $new_shop_info['links'][$i],
                );

                $this->udb->set($insert);
                $this->udb->insert($this->table['naver_shop_product_sub']);
            };

            return true;
        }else{
            return 0;
        }
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 리스트 불러오기
    //-----------------------------------------------------------------------------
    function get_naver_shop_list($mode, $query_data) {
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

        //카테고리
        if($query_data['category'] != "ALL"){
            $where .= " AND category_no = ".$query_data['category'];
        }

        if($mode === 'total'){
            $field = "count(*) as total";
            $limit = " limit 1";
        }else if($mode === 'list'){
            $field = "a.*, b.category_name";
        }

        $sql = "select ".$field." from ".$this->table['naver_shop_product']." as a left join ".$this->table['category']." as b on (category_no = b.no) where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 리스트 서브 불러오기
    //-----------------------------------------------------------------------------
    function get_naver_shop_list_sub($mode, $query_data) {
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

        $sql = "select ".$field." from ".$this->table['naver_shop_product_sub']." where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 삭제
    //-----------------------------------------------------------------------------
    function delete_naver_shop($no) {
        $sql = "delete from ".$this->table['naver_shop_product']." where no in (".$no.")";
        $rt = $this->udb->query( $sql );

        if($rt){
            $sql = "delete from ".$this->table['naver_shop_product_sub']." where product_no in (".$no.")";
            $rt = $this->udb->query( $sql );
        }

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 디테일정보 불러오기
    //-----------------------------------------------------------------------------
    function get_detail($no) {
        $sql = "select no, product_name, category_no, memo from ".$this->table['naver_shop_product']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버 지식쇼핑 수정
    //-----------------------------------------------------------------------------
    function edit_naver_shop($post) {

        $update = array(
            'product_name' => $post['product_name'],
            'category_no' => $post['category'],
            'memo' => $post['memo']
        );

        $this->udb->where('no', $post['no']);
        $rt = $this->udb->update($this->table['naver_shop_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  페이지 상품 업데이트
    //-----------------------------------------------------------------------------
    function update_product($no){
        // 정보 가져오기
        $sql = "select * from ".$this->table['naver_shop_product']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $shop_db_info = $qr->result_array();

        $url = $shop_db_info[0]['shop_link'];

        $shop_info = $this->scrap->search_naver($url);
        
        if($shop_info['product_name'] == ""){
            return "error";
        }

        // 예외마켓 배열에서 삭제
        $sql = "select m_level, except_market from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();
        $except_market_list = json_decode($result[0]['except_market']);

        $new_shop_info = $this->naver->array_check($shop_info, $except_market_list);
        $m_level = $result[0]['m_level'];

        $warning = "N";
        $msg = "";

        //업체순위 체크
        $sql = "select company_name from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        $company_name = $result[0]['company_name'];
        $array_key = array_search($company_name,$new_shop_info['names']);

        if($array_key !== false) {
            $array_key = $array_key + 1;
        }else{
            $array_key = 0;
        }

        if($shop_db_info[0]['first_company'] != $new_shop_info['names'][0]){
            $warning = "Y";
            $msg .= "[1위업체변동 ".$shop_db_info[0]['first_company']." > ".$new_shop_info['names'][0]."]<br>";
        }

        if($shop_db_info[0]['first_price'] != $new_shop_info['prices'][0]){
            $warning = "Y";
            $msg .= "[1위가격변동 ".$shop_db_info[0]['first_price']."원 > ".$new_shop_info['prices'][0]."원]<br>";
        }

        if($shop_db_info[0]['first_delivery_cost'] != $new_shop_info['deli_costs'][0]){
            $warning = "Y";
            $msg .= "[1위배송비변동 ".$shop_db_info[0]['first_delivery_cost']."원 > ".$new_shop_info['deli_costs'][0]."원]<br>";
        }

        if($m_level == 2){
            if($shop_db_info[0]['second_company'] != $new_shop_info['names'][1]){
                $warning = "Y";
                $msg .= "[2위업체변동 ".$shop_db_info[0]['second_company']." > ".$new_shop_info['names'][1]."]<br>";
            }

            if($shop_db_info[0]['second_price'] != $new_shop_info['prices'][1]){
                $warning = "Y";
                $msg .= "[2위가격변동 ".$shop_db_info[0]['second_price']."원 > ".$new_shop_info['prices'][1]."원]<br>";
            }

            if($shop_db_info[0]['second_delivery_cost'] != $new_shop_info['deli_costs'][1]){
                $warning = "Y";
                $msg .= "[2위배송비변동 ".$shop_db_info[0]['second_delivery_cost']."원 > ".$new_shop_info['deli_costs'][1]."원]<br>";
            }
        }

        // 값 변동 시 업데이트 실행
        if($warning == "Y"){
            $update = array(
                'first_company'	=> $new_shop_info['names'][0],
                'first_price'	=> $new_shop_info['prices'][0],
                'first_delivery_cost'	=> $new_shop_info['deli_costs'][0],
                'second_company'	=> $new_shop_info['names'][1],
                'second_price'	=> $new_shop_info['prices'][1],
                'second_delivery_cost'	=> $new_shop_info['deli_costs'][1],
                'warning'	=> $warning,
                'change_count'	=> $shop_db_info[0]['change_count'] + 1,
                'update_date'	=> date("Y-m-d H:i:s"),
                'my_rank'	=> $array_key
            );

            $this->udb->where('no', $no);
            $rt = $this->udb->update($this->table['naver_shop_product'], $update);
            
            if($rt){
                //업데이트 로그 추가
                $insert = array(
                    'product_no'	=> $no,
                    'contents'	=> $msg,
                );

                $this->udb->set($insert);
                $this->udb->insert($this->table['naver_shop_update_log']);
            }
        }else{
            $update = array(
                'update_date'	=> date("Y-m-d H:i:s"),
                'my_rank'	=> $array_key
            );

            $this->udb->where('no', $no);
            $this->udb->update($this->table['naver_shop_product'], $update);
        }

        // Sub 메뉴 삭제 후 재추가
        $sql = "delete from ".$this->table['naver_shop_product_sub']." where product_no in (".$no.")";
        $rt = $this->udb->query( $sql );

        for($i=0; $i<sizeof($new_shop_info['names']); $i++){
            $insert = array(
                'product_no'	=> $no,
                'company_name'	=> $new_shop_info['names'][$i],
                'product_price'	=> $new_shop_info['prices'][$i],
                'delivery_cost'	=> $new_shop_info['deli_costs'][$i],
                'site_href'	=> $new_shop_info['links'][$i],
            );

            $this->udb->set($insert);
            $this->udb->insert($this->table['naver_shop_product_sub']);
        };

        return $rt;

    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 알림 끄기
    //-----------------------------------------------------------------------------
    function naver_warning_off($no) {
        $update = array(
            'warning'	=> "N",
        );

        $this->udb->where('no', $no);
        $rt = $this->udb->update($this->table['naver_shop_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 토탈 알림 수 가져오기
    //-----------------------------------------------------------------------------
    function total_warning() {
        $sql = "select count(*) as total from ".$this->table['naver_shop_product']." where warning = 'Y'";

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 로그 가져오기
    //-----------------------------------------------------------------------------
    function get_log($no) {
        $sql = "select * from ".$this->table['naver_shop_update_log']." where product_no = ".$no." order by wdate desc";

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 no 가져오기
    //-----------------------------------------------------------------------------
    function get_naver_product_nos() {
        $sql = "select no from ".$this->table['naver_shop_product'];

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 업데이트 시간 업데이트
    //-----------------------------------------------------------------------------
    function update_udate() {
        $update = array(
            'naver_recent_update_date'	=> date("Y-m-d H:i:s")
        );

        $this->adb->where('id', $_SESSION['U_ID']);
        $rt = $this->adb->update('member', $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    // 메모 업데이트
    //-----------------------------------------------------------------------------
    function memo_update($info) {
        $update = array(
            'memo'	=> $info['memo']
        );

        $this->udb->where('no', $info['no']);
        $rt = $this->udb->update($this->table['naver_shop_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  페이지 상품 등록
    //-----------------------------------------------------------------------------
    function add_keyword($prodInfo){
        //DB수 체크
        $sql = "select count(*) as total from ".$this->table['naver_keyword_product'];
        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        if($result[0]['total'] >= $_SESSION['KEYWORD_LIMIT_DB']){
            return 'error';
        }

        $url = "http://shopping.naver.com/search/all.nhn?origQuery=".urlencode($prodInfo['keyword_name'])."&pagingIndex=1&pagingSize=20&viewType=list&sort=".$prodInfo['sort']."&minPrice=".$prodInfo['min_price']."&maxPrice=".$prodInfo['max_price']."&frm=NVSHPRC&query=".urlencode($prodInfo['keyword_name']);

        $shop_info = $this->scrap->search_naver_keyword($url, $prodInfo['ads_rank_yn'], $prodInfo['bundle_yn']);

        //업체순위 체크
        $sql = "select keyword_company_name from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        $company_name = $result[0]['keyword_company_name'];
        $array_key = array_search($company_name,$shop_info['company_names']);

        if($array_key !== false) {
            $array_key = $array_key + 1;
        }else{
            $array_key = 0;
        }

        $insert = array(
            'category_no'	=> $prodInfo['category'],
            'min_price'	=> $prodInfo['min_price'],
            'max_price'	=> $prodInfo['max_price'],
            'shop_link'	=> $prodInfo['url'],
            'ads_rank_yn'	=> $prodInfo['ads_rank_yn'],
            'bundle_yn'	=> $prodInfo['bundle_yn'],
            'sort'	=> $prodInfo['sort'],
            'memo'	=> $prodInfo['memo'],
            'shop_link'	=> $url,
            'keyword_name'	=> $prodInfo['keyword_name'],
            'first_company'	=> $shop_info['company_names'][0],
            'first_price'	=> $shop_info['prices'][0],
            'first_delivery_cost'	=> $shop_info['deli_costs'][0],
            'my_rank' => $array_key
        );

        $this->udb->set($insert);
        $rt = $this->udb->insert($this->table['naver_keyword_product']);

        if($rt){ // sub 등록

            $no = $this->udb->insert_id();

            for($i=0; $i<sizeof($shop_info['company_names']); $i++){
                $insert = array(
                    'product_no'	=> $no,
                    'company_name'	=> $shop_info['company_names'][$i],
                    'product_name'	=> $shop_info['product_name'][$i],
                    'product_price'	=> $shop_info['prices'][$i],
                    'delivery_cost'	=> $shop_info['deli_costs'][$i],
                    'site_href'	=> $shop_info['links'][$i],
                    'img_src'	=> $shop_info['img_src'][$i]
                );

                $this->udb->set($insert);
                $this->udb->insert($this->table['naver_keyword_product_sub']);
            };

            return true;
        }else{
            return 0;
        }

    }

    //-----------------------------------------------------------------------------
    //  네이버 키워드 리스트 불러오기
    //-----------------------------------------------------------------------------
    function get_naver_keyword_list($mode, $query_data) {
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
            $where .= " AND (a.keyword_name like '%".$query_data['keyword']."%' OR b.category_name like '%".$query_data['keyword']."%' OR a.memo like '%".$query_data['keyword']."%')";
        }

        //알림상태
        if($query_data['status'] != "ALL"){
            $where .= " AND warning = '".$query_data['status']."'";
        }

        //카테고리
        if($query_data['category'] != "ALL"){
            $where .= " AND category_no = ".$query_data['category'];
        }

        if($mode === 'total'){
            $field = "count(*) as total";
            $limit = " limit 1";
        }else if($mode === 'list'){
            $field = "a.*, b.category_name";
        }

        $sql = "select ".$field." from ".$this->table['naver_keyword_product']." as a left join ".$this->table['category']." as b on (category_no = b.no) where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버 키워드 리스트 서브 불러오기
    //-----------------------------------------------------------------------------
    function get_naver_keyword_list_sub($mode, $query_data) {
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

        $sql = "select ".$field." from ".$this->table['naver_keyword_product_sub']." where 1".$where.$orderby.$limit;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버 키워드 삭제
    //-----------------------------------------------------------------------------
    function delete_naver_keyword($no) {
        $sql = "delete from ".$this->table['naver_keyword_product']." where no in (".$no.")";
        $rt = $this->udb->query( $sql );

        if($rt){
            $sql = "delete from ".$this->table['naver_keyword_product_sub']." where product_no in (".$no.")";
            $rt = $this->udb->query( $sql );
        }

        return $rt;
    }

    //-----------------------------------------------------------------------------
    // 네이버 키워드 메모 업데이트
    //-----------------------------------------------------------------------------
    function keyword_memo_update($info) {
        $update = array(
            'memo'	=> $info['memo']
        );

        $this->udb->where('no', $info['no']);
        $rt = $this->udb->update($this->table['naver_keyword_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  네이버지식쇼핑 키워드 디테일정보 불러오기
    //-----------------------------------------------------------------------------
    function get_keyword_detail($no) {
        $sql = "select no, keyword_name, max_price, min_price, category_no, memo, sort, ads_rank_yn, bundle_yn from ".$this->table['naver_keyword_product']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버 키워드 수정
    //-----------------------------------------------------------------------------
    function edit_naver_keyword($post) {

        $update = array(
            'category_no' => $post['category'],
            'min_price' => $post['min_price'],
            'max_price' => $post['max_price'],
            'sort' => $post['sort'],
            'ads_rank_yn' => $post['ads_rank_yn'],
            'bundle_yn' => $post['bundle_yn'],
            'memo' => $post['memo']
        );

        $this->udb->where('no', $post['no']);
        $rt = $this->udb->update($this->table['naver_keyword_product'], $update);

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  키워드 업데이트
    //-----------------------------------------------------------------------------
    function update_keyword($no){
        // 정보 가져오기
        $sql = "select * from ".$this->table['naver_keyword_product']." where no = ".$no;

        $qr = $this->udb->query($sql, array());
        $db_info = $qr->result_array();

        $url = "http://shopping.naver.com/search/all.nhn?origQuery=".urlencode($db_info[0]['keyword_name'])."&pagingIndex=1&pagingSize=20&viewType=list&sort=".$db_info[0]['sort']."&minPrice=".$db_info[0]['min_price']."&maxPrice=".$db_info[0]['max_price']."&frm=NVSHPRC&query=".urlencode($db_info[0]['keyword_name']);

        $shop_info = $this->scrap->search_naver_keyword($url,$db_info[0]['ads_rank_yn'],$db_info[0]['bundle_yn']);

        //업체순위 체크
        $sql = "select keyword_company_name from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        $company_name = $result[0]['keyword_company_name'];
        $array_key = array_search($company_name,$shop_info['company_names']);

        if($array_key !== false) {
            $array_key = $array_key + 1;
        }else{
            $array_key = 0;
        }

        $update = array(
            'shop_link'	=> $url,
            'update_date'	=> date("Y-m-d H:i:s"),
            'first_company'	=> $shop_info['company_names'][0],
            'first_price'	=> $shop_info['prices'][0],
            'first_delivery_cost'	=> $shop_info['deli_costs'][0],
            'my_rank' => $array_key
        );

        $this->udb->where('no', $no);
        $rt = $this->udb->update($this->table['naver_keyword_product'], $update);

        if($rt){
            // Sub 메뉴 삭제 후 재추가
            $sql = "delete from ".$this->table['naver_keyword_product_sub']." where product_no in (".$no.")";
            $rt = $this->udb->query( $sql );

            if($rt){
                for($i=0; $i<sizeof($shop_info['company_names']); $i++){
                    $insert = array(
                        'product_no'	=> $no,
                        'company_name'	=> $shop_info['company_names'][$i],
                        'product_name'	=> $shop_info['product_name'][$i],
                        'product_price'	=> $shop_info['prices'][$i],
                        'delivery_cost'	=> $shop_info['deli_costs'][$i],
                        'site_href'	=> $shop_info['links'][$i],
                        'img_src'	=> $shop_info['img_src'][$i]
                    );

                    $this->udb->set($insert);
                    $this->udb->insert($this->table['naver_keyword_product_sub']);
                };

                return true;
            }
        }else{
            return false;
        }
    }

    //-----------------------------------------------------------------------------
    //  네이버 키워드 no 가져오기
    //-----------------------------------------------------------------------------
    function get_keyword_product_nos() {
        $sql = "select no from ".$this->table['naver_keyword_product'];

        $qr = $this->udb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  네이버키워드 업데이트 시간 업데이트
    //-----------------------------------------------------------------------------
    function update_keyword_udate() {
        $update = array(
            'naver_keyword_recent_update_date'	=> date("Y-m-d H:i:s")
        );

        $this->adb->where('id', $_SESSION['U_ID']);
        $rt = $this->adb->update('member', $update);

        return $rt;
    }
}