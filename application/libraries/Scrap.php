<?php
include('lib/Snoopy.class.php');
include('lib/simple_html_dom.php');

/**
 * Created by PhpStorm.
 * User: vs
 * Date: 2017-10-24
 * Time: 오후 12:39
 */

class Scrap
{
    /**
     * 생성자
     */
    function SCRAP() {

    }

    //지식쇼핑 가격비교
    function search_naver($link){
        $snoopy=new snoopy;
        $snoopy->fetch($link);

        $html = str_get_html($snoopy->results);

        // 이름 가져오기
        foreach($html->find('div[class=h_area] > h2') as $element) {
            $product_name = trim($element->innertext);
        }

        // 이미지 가져오기
        foreach($html->find('img[id=viewImage]') as $element) {
            $img_src = $element->src;
        }

        $i = 0;
        $names = array();
        $prices = array();
        $deli_costs = array();
        $links = array();

        //이름
        foreach($html->find('span[class=mall]') as $element) {
            foreach($element->find('A') as $element2) {
                if($element2->find('img')){
                    foreach($element2->find('img') as $element3) {
                        $names[$i] = $element3->alt;
                    }
                }else{
                    $names[$i] = trim($element2->innertext);
                }

                $links[$i] = $element2->href;

                $i++;
            }
        }

        //가격
        $i = 0;
        foreach($html->find('td[class=price]') as $element) {
            foreach($element->find('A') as $element2) {
                $prices[$i] = preg_replace("/[^0-9]*/s", "", $element2->innertext);
                $i++;
            }
        }

        //배송비
        $i = 0;
        foreach($html->find('td[class=gift]') as $element) {
            $deli_costs[$i] = preg_replace("/[^0-9]*/s", "", $element->innertext);
            if(!$deli_costs[$i]){
                $deli_costs[$i] = 0;
            }

            $i++;
        }

        $arr = array();
        $arr['product_name'] = $product_name;
        $arr['img_src'] = $img_src;
        $arr['names'] = $names;
        $arr['prices'] = $prices;
        $arr['deli_costs'] = $deli_costs;
        $arr['links'] = $links;

        return $arr;
    }

    //키워드 가격비교
    function search_naver_keyword($link,$mode,$mode2){
        $snoopy=new snoopy;
        $snoopy->fetch($link);

        $html = str_get_html($snoopy->results);

        $imgs = array();
        $names = array();
        $prices = array();
        $company_names = array();
        $deli_costs = array();
        $links = array();
        $bundle_yn = array();

        // 광고수 가져오기
        $ads_count = 0;

        foreach($html->find('a[class=ad_stk]') as $element) {
            $ads_count++;
        }

        $i = 0;
        $real_count_img = 0;
        $real_count_name = 0;
        $real_count_price = 0;
        $real_count_company_name = 0;
        $real_count_deli_cost = 0;
        $real_count_url = 0;

        // 묶음여부 가져오기
        foreach($html->find('li[class=_itemSection]') as $li_element) {

            $bundle_yn[$i] = "Y";

            foreach ($li_element->find('ul[class=mall_option] > li(0)') as $element) {
                $bundle_yn[$i] = "N";
            }

            $i++;
        }

        //정보 가져오기
        $i = -1;
        $bundle_count = 0;
        foreach($html->find('li[class=_itemSection]') as $li_element) {
            if($mode2 == "N"){
                if($bundle_yn[$bundle_count] == "N"){
                    $i++;
                }
            }else if($mode2 == "Y"){
                $i++;
            }

            // 택배비 가져오기
            foreach($li_element->find('ul[class=mall_option] > li(0)') as $element) {

                preg_match("@<em[^>]*>([^<]+)</em>@", $element->innertext, $matches);

                if($mode == "N"){
                    if($ads_count <= $i){
                        $deli_costs[$real_count_deli_cost] = preg_replace("/[^0-9]*/s", "", $matches[1]);

                        if($deli_costs[$real_count_deli_cost] == ""){
                            $deli_costs[$real_count_deli_cost] = 0;
                        }

                        $real_count_deli_cost++;
                    }
                }else{
                    $deli_costs[$i] = preg_replace("/[^0-9]*/s", "", $matches[1]);
                    if($deli_costs[$i] == ""){
                        $deli_costs[$i] = 0;
                    }
                }
            }

            if(!isset($deli_costs[$i])){
                $deli_costs[$i] = 0;
            }

            //이미지 가져오기기
            foreach($li_element->find('img[class=_productLazyImg]') as $element) {
                if($mode == "N"){
                    if($ads_count <= $i){
                        $imgs[$real_count_img] = $element->attr['data-original'];
                        $real_count_img++;
                    }
                }else{
                    $imgs[$i] = $element->attr['data-original'];
                }
            }

            // 제목 가져오기
            foreach($li_element->find('img[class=_productLazyImg]') as $element) {
                if($mode == "N"){
                    if($ads_count <= $i){
                        $names[$real_count_name] = $element->alt;
                        $real_count_name++;
                    }
                }else{
                    $names[$i] = $element->alt;

                    if($ads_count > $i){
                        $names[$i] = "<p>[광고상품]</p>".$names[$i];
                    }
                }
            }

            // 가격 가져오기
            foreach($li_element->find('span[class=num _price_reload]') as $element) {

                if($mode == "N"){
                    if($ads_count <= $i){
                        $prices[$real_count_price] = preg_replace("/[^0-9]*/s", "", $element->innertext);
                        $real_count_price++;
                    }
                }else{
                    $prices[$i] = preg_replace("/[^0-9]*/s", "", $element->innertext);
                }
            }

            // 회사명 가져오기
            foreach($li_element->find('p[class=mall_txt] > a[class=mall_more]') as $element) {

                if($mode == "N"){
                    if($ads_count <= $i){
                        $company_names[$real_count_company_name] = $element->title;
                        $real_count_company_name++;
                    }
                }else{
                    $company_names[$i] = $element->title;
                }
            }

            // url 가져오기
            foreach($li_element->find('div[class=img_area] > a') as $element) {
                if($element->href != "#"){

                    if($mode == "N"){
                        if($ads_count <= $i){
                            $links[$real_count_url] = $element->href;
                            $real_count_url++;
                        }
                    }else{
                        $links[$i] = $element->href;
                    }

                }
            }

            $bundle_count++;
        }

        $arr = array();
        $arr['product_name'] = $names;
        $arr['img_src'] = $imgs;
        $arr['company_names'] = $company_names;
        $arr['prices'] = $prices;
        $arr['deli_costs'] = $deli_costs;
        $arr['links'] = $links;

        return $arr;
    }

    //스토어팜 가격비교
    function search_storefarm($link){

        $snoopy=new snoopy;
        $snoopy->fetch($link);

        $html = str_get_html($snoopy->results);

        // 회사명 가져오기
        foreach($html->find('a[class=N=a:lid.home]') as $element) {
            $company_name = $element->plaintext;
        }

        // 이름 가져오기
        foreach($html->find('dt[class=prd_name]') as $element) {
            $prod_name = $element->plaintext;
        }

        // 이미지 가져오기
        foreach($html->find('img[class=_view_image_area]') as $element) {
            $img_src = $element->src;
        }

        //가격
        $price = 0;

        foreach($html->find('p[class=fc_point sale]') as $element) {
            $prices = $element->find('span[class=thm]');
            $price = preg_replace("/[^0-9]*/s", "", $prices[0]->innertext);
        }

        //배송비
        $deli_cost = 0;

        foreach($html->find('span[class=_deliveryBaseFeeAreaValue ag]') as $element) {
            $deli_cost = preg_replace("/[^0-9]*/s", "", $element->innertext);
        }

        //무료배송 처리
        if($deli_cost == ""){
            $deli_cost = 0;
        }

        $arr = array();
        $arr['price'] = $price;
        $arr['deli_cost'] = $deli_cost;
        $arr['img_src'] = $img_src;
        $arr['prod_name'] = trim($prod_name);
        $arr['company_name'] = trim($company_name);

        return $arr;
    }

}