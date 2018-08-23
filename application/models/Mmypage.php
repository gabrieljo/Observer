<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 5:02
 */

class Mmypage extends CI_Model {
    // 생성자
    function __construct()
    {
        parent::__construct();

        $this->adb = $this->load->database('adb', TRUE);
    }

    //-----------------------------------------------------------------------------
    //  카테고리 리스트 불러오기
    //-----------------------------------------------------------------------------
    function get_myinfo() {
        $sql = "select id, tel, email, email_check from member where id = '".$_SESSION['U_ID']."'";

        $qr = $this->adb->query($sql, array());
        $result = $qr->result_array();

        return $result;
    }

    //-----------------------------------------------------------------------------
    //  프로필 수정
    //-----------------------------------------------------------------------------
    function edit_myinfo($info) {

        if($info['now_password'] != ""){
            $sql = "SELECT count(*) as total FROM member WHERE id = ? and pw = password('".$info['now_password']."')";

            $qr = $this->adb->query($sql, array($_SESSION['U_ID']));
            $row = $qr->row_array();

            if($row['total'] == 0){
                return "error";
            }
        }

        if($info['email_check'] === "Y"){
            $email_check = "Y";
        }else{
            $email_check = "N";
        }

        $update = array(
            'tel'	 => $info['tel'],
            'email'	 => $info['email'],
            'email_check'	 => $email_check,
        );

        if($info['now_password'] != ""){
            $this->adb->set('pw', 'password("'.$info['new_password'].'")', false);
        }

        $this->adb->where('id', $_SESSION['U_ID']);
        $rt = $this->adb->update('member', $update);

        return $rt;
    }

}