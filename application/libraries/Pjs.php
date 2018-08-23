<?
/**
 * JAVASCRIPT 라이브러리
 */

// 클래스 시작
class PJS {

    /**
     * 생성자
     */
    function PJS() {

    }

    /**
     * Error 화면
     */
    function error($msg) {
        $msg = addslashes($msg);
        echo "
		<script>
		window.alert('$msg');
		history.back();
		</script>
		";
        exit;
    }

    /**
     * JS alert
     */
    function alert($msg) {
        echo "
		<script>
		window.alert('$msg');
		</script>
		";
    }

    /**
     * href
     */
    function href($url) {
        echo "
		<script>
		document.location.href = '$url';
		</script>
		";
        exit;
    }

    /**
     * href
     */
    function close_pop() {
        echo "
		<script>
		window.close();
		</script>
		";
        exit;
    }

    /**
     * 오프너 갱신 시키고 창닫기
     */
    function opener_reload_close(){
        echo "<script>opener.location.reload();";
        echo "window.close();";
        echo "</script>";
        exit;
    }

    /**
     * 오프너 창닫기
     */
    function opener_close(){
        echo "<script>";
        echo "window.close();";
        echo "</script>";
        exit;
    }

    /**
     * Post 방식으로 이동
     */
    function go_post($url,$data){
        echo "<form method=post action='".$url."' name='goform'>";
        foreach($data as $key=>$val) {
            if($val!="") {
                if(is_array($val)) {
                    foreach($val as $k=>$v) {
                        echo "<input type='hidden' name='".$key."[]' value='$v'>";
                    }
                }else{
                    echo "<input type='hidden' name='$key' value='$val'>";
                }
            }
        }
        echo "</form>";
        echo "<SCRIPT LANGUAGE='JavaScript'>document.goform.submit();</SCRIPT>";
        exit;
    }

} // end class
?>