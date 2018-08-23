<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 5:02
 */

class Mupdate extends CI_Model {
    // 생성자
    function __construct()
    {
        parent::__construct();

        $this->load->library('scrap');
        $this->load->library('naver');

        $this->adb = $this->load->database('adb', TRUE);
        $this->table = [];
    }

    function all_detail_db_update(){
        $sql = "select id, db from member";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        foreach ($result as $key => $value){
            $this->udb = $this->load->database($value['db'], TRUE);

            $this->table['detail_shop_product'] = "udb_".$value['id'].".detail_shop_product";
            $this->table['detail_shop_product_sub'] = "udb_".$value['id'].".detail_shop_product_sub";
            $this->table['detail_shop_product_log'] = "udb_".$value['id'].".detail_shop_product_log";

            $sql = "select no, product_no ,shop_link, price, delivery_cost, change_count from ".$this->table['detail_shop_product_sub'];
            $qr = $this->udb->query($sql, array());
            $data = $qr->result_array();

            foreach ($data as $key2 => $value2){
                $shop_info = $this->scrap->search_storefarm($value2['shop_link']);

                //정보 다른지 체크
                $content = "";

                if($shop_info['price'] != $value2['price']){
                    $content .= "[가격변동] ".$value2['price']."원 => ".$shop_info['price']."원";
                }

                if($shop_info['deli_cost'] != $value2['delivery_cost']){
                    if($content != ""){
                        $content .= "<br>";
                    }

                    $content .= "[택배비변동] ".$value2['delivery_cost']."원 => ".$shop_info['deli_cost']."원";
                }

                //정보 다른경우 업데이트
                if($content != ""){
                    $update = array(
                        'warning'	=> "Y",
                        'price'	=> $shop_info['price'],
                        'delivery_cost'	=> $shop_info['deli_cost'],
                        'change_count'	=> $value2['change_count'] + 1,
                    );

                    $this->udb->where('no', $value2['no']);
                    $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);

                    //상위 변동상태 변경
                    $update = array(
                        'warning'	=> "Y",
                    );

                    $this->udb->where('no', $value2['product_no']);
                    $rt = $this->udb->update($this->table['detail_shop_product'], $update);

                    //로그 등록
                    $insert = array(
                        'product_no'	=> $value2['no'],
                        'contents'	=> $content
                    );

                    $this->udb->set($insert);
                    $this->udb->insert($this->table['detail_shop_product_log']);
                }

                //업데이트 시간 업데이트
                $update = array(
                    'update_date'	=> date("Y-m-d H:i:s"),
                );

                $this->udb->where('no', $value2['no']);
                $rt = $this->udb->update($this->table['detail_shop_product_sub'], $update);
            }
        }

        return true;
    }

    function all_naver_db_update(){
        $sql = "select id, db from member";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        foreach ($result as $key => $value){
            $this->udb = $this->load->database($value['db'], TRUE);

            $this->table['naver_shop_product'] = "udb_".$value['id'].".naver_shop_product";
            $this->table['naver_shop_product_sub'] = "udb_".$value['id'].".naver_shop_product_sub";
            $this->table['naver_shop_update_log'] = "udb_".$value['id'].".naver_shop_update_log";

            $sql = "select no, shop_link, first_company, first_price, first_delivery_cost, second_company, second_price, second_delivery_cost, change_count from ".$this->table['naver_shop_product'];
            $qr = $this->udb->query($sql, array());
            $data = $qr->result_array();

            foreach ($data as $key2 => $value2){

                $shop_info = $this->scrap->search_naver($value2['shop_link']);

                // 예외마켓 배열에서 삭제
                $sql = "select m_level, except_market from member where id = '".$value['id']."'";

                $qr = $this->adb->query($sql, array());
                $mem_info = $qr->result_array();
                $except_market_list = json_decode($mem_info[0]['except_market']);

                $new_shop_info = $this->naver->array_check($shop_info, $except_market_list);
                $m_level = $mem_info[0]['m_level'];

                $warning = "N";
                $msg = "";

                //업체순위 체크
                $sql = "select company_name from member where id = '".$value['id']."'";

                $qr = $this->adb->query($sql, array());
                $result = $qr->result_array();

                $company_name = $result[0]['company_name'];
                $array_key = array_search($company_name,$new_shop_info['names']);

                if($array_key !== false) {
                    $array_key = $array_key + 1;
                }else{
                    $array_key = 0;
                }

                if($value2['first_company'] != $new_shop_info['names'][0]){
                    $warning = "Y";
                    $msg .= "[1위업체변동 ".$value2['first_company']." > ".$new_shop_info['names'][0]."]<br>";
                }

                if($value2['first_price'] != $new_shop_info['prices'][0]){
                    $warning = "Y";
                    $msg .= "[1위가격변동 ".$value2['first_price']."원 > ".$new_shop_info['prices'][0]."원]<br>";
                }

                if($value2['first_delivery_cost'] != $new_shop_info['deli_costs'][0]){
                    $warning = "Y";
                    $msg .= "[1위배송비변동 ".$value2['first_delivery_cost']."원 > ".$new_shop_info['deli_costs'][0]."원]<br>";
                }

                if($m_level == 2){
                    if($value2['second_company'] != $new_shop_info['names'][1]){
                        $warning = "Y";
                        $msg .= "[2위업체변동 ".$value2['second_company']." > ".$new_shop_info['names'][1]."]<br>";
                    }

                    if($value2['second_price'] != $new_shop_info['prices'][1]){
                        $warning = "Y";
                        $msg .= "[2위가격변동 ".$value2['second_price']."원 > ".$new_shop_info['prices'][1]."원]<br>";
                    }

                    if($value2['second_delivery_cost'] != $new_shop_info['deli_costs'][1]){
                        $warning = "Y";
                        $msg .= "[2위배송비변동 ".$value2['second_delivery_cost']."원 > ".$new_shop_info['deli_costs'][1]."원]<br>";
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
                        'change_count'	=> $value2['change_count'] + 1,
                        'update_date'	=> date("Y-m-d H:i:s"),
                        'my_rank'	=> $array_key
                    );

                    $this->udb->where('no', $value2['no']);
                    $rt = $this->udb->update($this->table['naver_shop_product'], $update);

                    if($rt){
                        //업데이트 로그 추가
                        $insert = array(
                            'product_no'	=> $value2['no'],
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

                    $this->udb->where('no', $value2['no']);
                    $this->udb->update($this->table['naver_shop_product'], $update);
                }

                // Sub 메뉴 삭제 후 재추가
                $sql = "delete from ".$this->table['naver_shop_product_sub']." where product_no in (".$value2['no'].")";
                $rt = $this->udb->query( $sql );

                for($i=0; $i<sizeof($new_shop_info['names']); $i++){
                    $insert = array(
                        'product_no'	=> $value2['no'],
                        'company_name'	=> $new_shop_info['names'][$i],
                        'product_price'	=> $new_shop_info['prices'][$i],
                        'delivery_cost'	=> $new_shop_info['deli_costs'][$i],
                        'site_href'	=> $new_shop_info['links'][$i],
                    );

                    $this->udb->set($insert);
                    $this->udb->insert($this->table['naver_shop_product_sub']);
                };

            }
        }

        return true;
    }


    function all_naver_keyword_db_update(){
        $sql = "select id, db from member";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        foreach ($result as $key => $value){
            $this->udb = $this->load->database($value['db'], TRUE);

            $this->table['naver_keyword_product'] = "udb_".$value['id'].".naver_keyword_product";
            $this->table['naver_keyword_product_sub'] = "udb_".$value['id'].".naver_keyword_product_sub";

            $sql = "select no, keyword_name, min_price, max_price, sort, ads_rank_yn, bundle_yn from ".$this->table['naver_keyword_product'];
            $qr = $this->udb->query($sql, array());
            $data = $qr->result_array();

            foreach ($data as $key2 => $value2){

                $url = "http://shopping.naver.com/search/all.nhn?origQuery=".urlencode($value2['keyword_name'])."&pagingIndex=1&pagingSize=20&viewType=list&sort=".$value2['sort']."&minPrice=".$value2['min_price']."&maxPrice=".$value2['max_price']."&frm=NVSHPRC&query=".urlencode($value2['keyword_name']);

                $shop_info = $this->scrap->search_naver_keyword($url,$value2['ads_rank_yn'],$value2['bundle_yn']);

                //업체순위 체크
                $sql = "select keyword_company_name from member where id = '".$value['id']."'";

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

                $this->udb->where('no', $value2['no']);
                $rt = $this->udb->update($this->table['naver_keyword_product'], $update);

                if($rt){
                    // Sub 메뉴 삭제 후 재추가
                    $sql = "delete from ".$this->table['naver_keyword_product_sub']." where product_no in (".$value2['no'].")";
                    $rt = $this->udb->query( $sql );

                    if($rt){
                        for($i=0; $i<sizeof($shop_info['company_names']); $i++){
                            $insert = array(
                                'product_no'	=> $value2['no'],
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
                    }
                }
            }
        }

        return true;
    }
}