<?php
/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 12:39
 */

class Naver
{

    function Naver() {

    }

    //지식쇼핑 가격비교
    function array_check($shop_info, $except_market_list){
        foreach ($except_market_list as $key => $value){
            if (($key = array_search($value, $shop_info['names'])) !== false) {
                unset($shop_info['names'][$key]);
                unset($shop_info['prices'][$key]);
                unset($shop_info['deli_costs'][$key]);
                unset($shop_info['links'][$key]);
            }
        }

        $shop_info['names'] = array_values($shop_info['names']);
        $shop_info['prices'] = array_values($shop_info['prices']);
        $shop_info['deli_costs'] = array_values($shop_info['deli_costs']);
        $shop_info['links'] = array_values($shop_info['links']);

        return $shop_info;
    }
}