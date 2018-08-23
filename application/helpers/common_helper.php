<?php
function xmp($array,$mode=false){
	if($_SERVER['REMOTE_ADDR'] == '61.36.100.245') {
    echo "<div style='position:relative;z-index:99999;background:#CE6601;font-Weight:bold;padding:3px;width:500px;word-break:break-all;'>현재 IP : ".$_SERVER['REMOTE_ADDR']."</div>";
    echo "<div style='position:relative;z-index:99999;background:#FFFFFF;width:500px;word-break:break-all;'><xmp>";
    print_r($array);
    echo "</xmp></div>";

    $temp = debug_backtrace();
    echo "<div style='position:relative;z-index:99999;background:#cdcece;font-Weight:bold;padding:3px;width:800px;word-break:break-all;'>본 xmp 함수는 다음 파일에서 호출 되었습니다 : ";
    print_r($temp[0]['file']);
    echo "</div>";

	}
}
?>