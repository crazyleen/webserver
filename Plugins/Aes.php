<?php

namespace HCE\Plugins;

/**
 * 使用AES加密
 */
class Aes {
  
    /** 
     * 算法,有128/192/256三种长度 
     */  
    const METHOD = 'aes-256-ecb';
  
    /** 
     * 加密 
     * @param string $key   密钥 
     * @param string $str   需加密的字符串，普通编码
     * @return base64编码 string  
     */  
    static public function encode($key, $str) {  
        $data = openssl_encrypt($str, self::METHOD, $key, true);
        return base64_encode($data); 
    }  
      
    /** 
     * 解密 
     * @param string $key     密钥
     * @param string $str     需解密的字符串，base64编码
     * @return string  
     */  
    static public function decode($key, $str) { 
        $data = base64_decode($str);
        return openssl_decrypt($data, self::METHOD, $key, true); 
    }
}