<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-19
 * Time: 오후 2:39
 */

class Mmember extends CI_Model {

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
    }

    //-----------------------------------------------------------------------------
    //  로그인
    //-----------------------------------------------------------------------------
    function login($id, $pw) {
        //로그 기록
        $insert = array(
            'id'	=> $id,
            'ip'	=> $_SERVER["REMOTE_ADDR"],
            'browser'	=> $_SERVER["HTTP_USER_AGENT"],
        );

        $this->adb->set($insert);
        $this->adb->insert("login_log");

        //로그인
        $sql = "SELECT * FROM member WHERE status = 'Y' and id = ? and pw = password('".$pw."')";

        $qr = $this->adb->query($sql, array($id));
        $row = $qr->row_array();

        $re = "n";

        if(count($row) > 0){
            if(date("Y-m-d H:i:s") > $row['end_date']){
                $re = "e";
            }else{
                $re = "y";

                // 로그인 정보
                $this->session->set_userdata('U_ID', $row['id']);
                $this->session->set_userdata('U_NAME', $row['name']);
                $this->session->set_userdata('U_DB', $row['db']);
                $this->session->set_userdata('LIMIT_DB', $row['naver_shop_limit_db']);
                $this->session->set_userdata('KEYWORD_LIMIT_DB', $row['naver_keyword_limit_db']);
                $this->session->set_userdata('DETAIL_LIMIT_DB', $row['detail_limit_db']);
                $this->session->set_userdata('END_DATE', $row['end_date']);
            }
        }

        return $re;

        // funciton - End
    }

    //-----------------------------------------------------------------------------
    //  멤버추가
    //-----------------------------------------------------------------------------
    function add_member($insert,$pw) {

        $this->adb->set('pw', 'password("'.$pw.'")', false);
        $this->adb->set($insert);
        $rt = $this->adb->insert('member');

        return $rt;
    }

    //-----------------------------------------------------------------------------
    //  데이터베이스 추가
    //-----------------------------------------------------------------------------
    function create_database($db_name) {
        //로그인
        $sql = "CREATE DATABASE ".$db_name;

        $qr = $this->udb->query($sql);

        return $qr;
    }

    //-----------------------------------------------------------------------------
    //  table
    //-----------------------------------------------------------------------------
    function create_table($db_name, $udb) {
        $this->udb = $this->load->database($udb, TRUE);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".category (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  category_name varchar(100) COLLATE utf8_bin NOT NULL,
                  PRIMARY KEY (no),
                  KEY no (no)
                ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".naver_keyword_product (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  min_price int(11) NOT NULL DEFAULT '0',
                  max_price int(11) NOT NULL DEFAULT '0',
                  category_no int(11) NOT NULL COMMENT '카테고리 넘버',
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
                  mdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',
                  update_date timestamp NULL DEFAULT NULL COMMENT '최근 업데이트일',
                  memo varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '메모',
                  sort varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
                  warning enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N' COMMENT '가격변동알림',
                  shop_link varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '지식쇼핑 링크',
                  keyword_name varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '상품명',
                  first_company varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '1위 업체명',
                  first_price int(11) NOT NULL DEFAULT '0' COMMENT '1위 가격',
                  first_delivery_cost int(11) NOT NULL DEFAULT '0' COMMENT '1위 배송비',
                  my_rank int(11) NOT NULL DEFAULT '0' COMMENT '나의 순위',
                  ads_rank_yn enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'Y' COMMENT '광고랭킹포함여부',
                  bundle_yn enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'Y' COMMENT '묶임상품가져오기여부',
                  PRIMARY KEY (no)
                ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".naver_keyword_product_sub (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  product_no int(11) NOT NULL,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  company_name varchar(50) COLLATE utf8_bin NOT NULL,
                  product_name varchar(200) COLLATE utf8_bin NOT NULL,
                  product_price int(11) NOT NULL,
                  delivery_cost int(11) NOT NULL,
                  site_href text COLLATE utf8_bin NOT NULL,
                  img_src varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '이미지 링크',
                  PRIMARY KEY (no)
                ) ENGINE=InnoDB AUTO_INCREMENT=19936 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".naver_shop_product (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  category_no int(11) NOT NULL COMMENT '카테고리 넘버',
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
                  mdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',
                  update_date timestamp NULL DEFAULT NULL COMMENT '최근 업데이트일',
                  memo varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '메모',
                  warning enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N' COMMENT '가격변동알림',
                  shop_link varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '지식쇼핑 링크',
                  img_src varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '이미지 링크',
                  nv_mid varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
                  product_name varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '상품명',
                  change_count int(11) NOT NULL DEFAULT '0' COMMENT '가격변경빈도수',
                  first_company varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '1위 업체명',
                  first_price int(11) NOT NULL DEFAULT '0' COMMENT '1위 가격',
                  first_delivery_cost int(11) NOT NULL DEFAULT '0' COMMENT '1위 배송비',
                  second_company varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '2위 업체명',
                  second_price int(11) NOT NULL DEFAULT '0' COMMENT '2위 가격',
                  second_delivery_cost int(11) NOT NULL DEFAULT '0' COMMENT '2위 배송비',
                  my_rank int(11) NOT NULL DEFAULT '0' COMMENT '나의 순위',
                  PRIMARY KEY (no),
                  UNIQUE KEY nv_mid (nv_mid),
                  KEY category_no (category_no),
                  KEY no (no)
                ) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".naver_shop_product_sub (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  product_no int(11) NOT NULL,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  company_name varchar(50) COLLATE utf8_bin NOT NULL,
                  product_price int(11) NOT NULL,
                  delivery_cost int(11) NOT NULL,
                  site_href text COLLATE utf8_bin NOT NULL,
                  PRIMARY KEY (no),
                  KEY product_no (product_no)
                ) ENGINE=InnoDB AUTO_INCREMENT=21332 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".detail_shop_product (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  category_no int(11) NOT NULL COMMENT '카테고리 넘버',
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
                  mdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',
                  memo varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '메모',
                  warning enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N' COMMENT '가격변동알림',
                  shop_link varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '지식쇼핑 링크',
                  img_src varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '이미지 링크',
                  product_name varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '상품명',
                  price int(11) NOT NULL DEFAULT '0' COMMENT '1위 가격',
                  delivery_cost int(11) NOT NULL DEFAULT '0' COMMENT '1위 배송비',
                  PRIMARY KEY (no),
                  KEY category_no (category_no)
                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".detail_shop_product_sub (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  product_no int(11) NOT NULL,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  update_date timestamp NULL DEFAULT NULL COMMENT '최근 업데이트일',
                  price int(11) NOT NULL,
                  warning enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N' COMMENT '가격변동알림',
                  delivery_cost int(11) NOT NULL,
                  company_name varchar(50) COLLATE utf8_bin NOT NULL,
                  shop_link varchar(500) COLLATE utf8_bin NOT NULL,
                  memo varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '메모',
                  change_count int(11) NOT NULL DEFAULT '0' COMMENT '가격변경빈도수',
                  PRIMARY KEY (no),
                  KEY product_no (product_no)
                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".detail_shop_product_log (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  product_no int(11) NOT NULL,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  contents varchar(200) COLLATE utf8_bin NOT NULL,
                  PRIMARY KEY (no),
                  KEY product_no (product_no)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".naver_shop_update_log (
                  no int(11) NOT NULL AUTO_INCREMENT,
                  product_no int(11) NOT NULL,
                  wdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  contents varchar(200) COLLATE utf8_bin NOT NULL,
                  PRIMARY KEY (no),
                  KEY product_no (product_no)
                ) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

        $qr = $this->udb->query($sql);

        return true;
    }

    //-----------------------------------------------------------------------------
    //  계정 중복 체크
    //-----------------------------------------------------------------------------
    function check_id($id) {
        $sql = "SELECT count(*) as total FROM member WHERE id = ?";
        $qr = $this->adb->query($sql, array($id));
        $row = $qr->row_array();

        return $row;
    }
}