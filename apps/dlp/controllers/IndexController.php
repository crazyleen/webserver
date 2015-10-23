<?php
namespace Dlp\Controllers;

class IndexController extends ResponseController {

    /**
     * 首页
     */
    public function indexAction() {        
        
        echo "<h1>Hello!</h1>";
        $this->redis->set("name", 'token=13414134141412412');
		echo \Phalcon\Tag::linkTo("test", "link to test Here!");
        $this->logD("dlp/index", "access index");
        echo '<h1>hello world</h1>';
    }

    public function testAction() {        
        
        echo "<h1>Hello!</h1>";
        $name = $this->redis->get("name");
        echo '<h1>' . $name . '</h1>';
    }

    public function performanceAction() {
        $uid = $this->redis->incr("grobal:next_uid");
        $uid = sprintf("uid:%d:code", $uid);
        $name = $this->generateCode();
        $this->redis->set($uid, $name);

        $result = array(
            "code" => $this->redis->get($uid),
            "uid" => $uid
            );
        $this->responseJson($result);
    }

    /**
     * 生成核销码
     *
     * 核销码是36进制的8位数
     * 前3位是天数，中间4位是随机数，最后1位是校验码
     *
     * @return String  8位核销码
     */
    private static function generateCode() {

        $days = intval( time() / (24 * 3600) ) % (36 * 36 * 36);
        $code = '';
        $array = array();
        for ($i = 0; $i < 3; $i++) {
            $array[$i] = $days % 36;
            $code .= self::toBase36Digit($array[$i]);
            $days = intval($days / 36);
        }
        for ($i = 3; $i < 7; $i++) {
            $array[$i] = mt_rand(0, 35);
            $code .= self::toBase36Digit($array[$i]);
        }

        $code .= self::toBase36Digit(($array[0] * 2 + $array[1] * 5 + $array[2] * 8 +
            $array[3] * 3 + $array[4] * 7 + $array[5] * 4 +
            $array[6] * 6) % 36);
        return $code;
    }

    /**
     * @param  Integer num  0~35
     * @return String  '0'~'9','a'~'z'
     */
    private static function toBase36Digit($num) {
        if ($num < 10) {
            return chr(ord('0') + $num);
        }
        $num = $num - 10;
        if ($num < 26) {
            return chr(ord('a') + $num);
        }
        return '';
    }

}
