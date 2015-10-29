<?php
namespace Dlp\Plugins;

/**
 * 负责处理create_time，update_time
 */
class StrRand {
    public static $CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public static $CHARS_ARRAY = array( 
            '0','1','2','3','4','5','6','7','8','9',
            'A','B','C','D','E','F','G','H','I','J',
            'K','L','M','N','O','P','Q','R','S','T',
            'U','V','W','X','Y','Z');
    
    /**
     * 产生长度为$len的随机字符串
     * @param number $len
     */
    public static function rand($len) {
        $data = '';
        $seed = mt_rand(1, 100);
        $source = time() . ':';
        for ( ; $len > 0; $len -= 40) {
            $source .= $seed;
            if ($len > 40)
                $data .= sha1($source);
            else
                $data .= substr(sha1($source), 0, $len);
        }
        return $data;
    }
    
    /**
     * 生成核销码 8位
     *
     * 核销码是36进制的8位数
     * 前3位是天数，中间4位是随机数，最后1位是校验码
     *
     * @return String 8位核销码
     */
    public static function gencode8()
    {
        $array = array();
        $days = intval(time() / (24 * 3600)) % (36 * 36 * 36);
        for ($i = 0; $i < 3; $i ++) {
            $array[$i] = $days % 36;
            $days = intval($days / 36);
        }
        for ($i = 3; $i < 7; $i++)
            $array[$i] = mt_rand(0, 35);
        
        $code = '';
        $verify = 0;
        for ($i = 0; $i < 7; $i++) {
            $code .= self::toBase36Digit($array[$i]);
            $verify = ($verify + $array[$i]) % 47;
        }
        
        $code .= self::toBase36Digit($verify);
        return $code;
    }
    
    /**
     * 10进制转36进制
     * @param
     *            Integer num 0~35
     * @return String '0'~'9','a'~'z'
     */
    public static function toBase36Digit ($num)
    {
        if ($num < 0 || $num > 35) 
            $num = ($num % 36 + 36) % 36;
        
        return StrRand::$CHARS[$num];
    }
}
