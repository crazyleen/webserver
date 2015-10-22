<?php
namespace Dlp\Controllers;

/**
 * 负责返回含有错误码的json数据
 */
abstract class ResponseController extends SessionController {

    /* SUCC */
    const CODE_SUCC = 0;

    /* OTHER */
    const CODE_SYSTEM_NOT_ACTIVATED = -10001;
    const CODE_SYSTEM_BUSY = -10002;

    /* ERROR */
    const CODE_NO_LOGIN = -1;
    const CODE_NO_PERMISSION = -2;
    const CODE_ERROR_METHOD = -3;

    /* FAIL */
    const CODE_FAIL = 1000;
    const CODE_FAIL_PARAM = 1001;
    const CODE_FAIL_PASSWORD = 1002;
    const CODE_FAIL_PERMISSION = 1003;
    const CODE_FAIL_EXPIRED = 1004;   // 接口过期
    const CODE_FAIL_CODE = 1005;   // 验证码错误
    const CODE_FAIL_CONSISTENT = 1006;   // 不一致
    const CODE_FAIL_REPEAT = 1007;
    
    const CODE_FAIL_LIMIT = 1101;  // 数目限制
    const CODE_FAIL_INSUFFICIENT = 1102;  // 余额不足

    /* Model */
    const CODE_FAIL_NOT_FOUND = 2001;
    const CODE_FAIL_NOT_OWN = 2002;
    const CODE_FAIL_STATUS_FROZEN = 2003;
    const CODE_FAIL_STATUS_SYSTEM_FROZEN = 2004;
    const CODE_FAIL_OCCUPIED = 2011;

    /* DB Operate */
    const CODE_FAIL_DB_BEGIN = 2101;
    const CODE_FAIL_DB_COMMIT = 2102;

    const CODE_FAIL_DB_CREATE = 2201;
    const CODE_FAIL_DB_UPDATE = 2202;
    const CODE_FAIL_DB_DELETE = 2203;
    const CODE_FAIL_DB_UNIQUE_COL = 2204;

    /* File */
    const CODE_FAIL_FILE = 3001;
    const CODE_FAIL_IMAGE = 3101;
    const CODE_FAIL_IMAGE_TYPE = 3102;
    const CODE_FAIL_IMAGE_FROMAT = 3103;
    const CODE_FAIL_IMAGE_SIZE = 3104;
    const CODE_FAIL_IMAGE_RATIO = 3105;

    /* Weixin */
    const CODE_FAIL_WEIXIN_LOGIN = 4000;
    const CODE_FAIL_WEIXIN_LOGIN_REFRESH_TOKEN = 4001;
    const CODE_FAIL_WEIXIN_LOGIN_INVALID_REFRESH_TOKEN = 4002;

    /* Weixin Open */
    const CODE_FAIL_WEIXIN_OPEN = 4100;
    const CODE_FAIL_WEIXIN_OPEN_UNAUTHORIZED = 4101;
    const CODE_FAIL_WEIXIN_OPEN_GET_AUTHORIZATION_INFO = 4102;
    const CODE_FAIL_WEIXIN_OPEN_GET_AUTHORIZER_INFO = 4103;
    const CODE_FAIL_WEIXIN_OPEN_UPLOAD = 4104;
    const CODE_FAIL_WEIXIN_OPEN_SEND_NEWS = 4105;
    const CODE_FAIL_WEIXIN_OPEN_HAS_SENT_NEWS = 4106;
    const CODE_FAIL_WEIXIN_OPEN_NOT_VERIFIED = 4107;

    /* Bwky Plant sunflower */
    const CODE_FAIL_BWKY_HAS_PLANTED = 5001;
    const CODE_FAIL_BWKY_HAS_WATERED = 5002;
    const CODE_FAIL_BWKY_CAN_NOT_PICK = 5003;
    const CODE_FAIL_BWKY_HAS_DEAD = 5004;
    const CODE_FAIL_BWKY_NO_GRASS = 5005;
    const CODE_FAIL_BWKY_NO_BANE = 5006;
    const CODE_FAIL_BWKY_NO_FERTILIZER = 5007;
    const CODE_FAIL_BWKY_REACH_MAX_FERTILIZER_DAYS = 5008;

    protected function responseJson($arr) {

        $arr['time'] = $_SERVER['REQUEST_TIME'];

        $this->view->disable();
        $this->response->setContentType ('application/json', 'UTF-8');
        $this->response->setJsonContent($arr, JSON_HEX_APOS|JSON_HEX_QUOT);
        $this->response->send();
        ob_flush(); flush();
        ob_flush(); flush();
        ob_flush(); flush();
    }


    protected function responseJsonSystemNotActivated() {

        $this->responseJson(array(
            'code' => self::CODE_SYSTEM_NOT_ACTIVATED,
            'desc' => '系统未激活，请联系管理员！'
        ));
    }

    protected function responseJsonSystemBusy() {

        $this->responseJson(array(
            'code' => self::CODE_SYSTEM_BUSY,
            'desc' => '系统繁忙，请稍后再来！'
        ));
    }


    protected function responseJsonNoLogin($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_NO_LOGIN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '未登录'
        ));
    }

    protected function responseJsonNoPermission($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_NO_PERMISSION,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '没有权限进行该操作'
        ));
    }

    protected function responseJsonErrorMethod($method='method', $ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_ERROR_METHOD,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '调用方法错误',
            'method' => $method,
        ));
    }


    protected function responseJsonSucc($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_SUCC,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '成功',
            'data' => array_key_exists('data', $ret) ? $ret['data'] : NULL,
        ));
    }

    protected function responseJsonFail($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '失败',
        ));
    }

    protected function responseJsonFailParam($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_PARAM,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '参数错误',
            'param' => array_key_exists('param', $ret) ? $ret['param'] : '',
        ));
    }

    protected function responseJsonFailPassword($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_PASSWORD,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '密码错误',
        ));
    }

    protected function responseJsonFailPermission($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_PERMISSION,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '权限错误',
        ));
    }

    protected function responseJsonFailExpired($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_EXPIRED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '超过可用时间',
        ));
    }

    protected function responseJsonFailCode($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_CODE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '验证码错误',
        ));
    }

    protected function responseJsonFailConsistent($ret=array()) {
    
        $this->responseJson(array(
            'code' => self::CODE_FAIL_CONSISTENT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '不一致',
        ));
    }

    protected function responseJsonFailRepeat($ret=array()) {
    
        $this->responseJson(array(
            'code' => self::CODE_FAIL_REPEAT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '重复',
        ));
    }

    protected function responseJsonFailLimit($ret=array()) {
    
        $this->responseJson(array(
            'code' => self::CODE_FAIL_LIMIT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '超过限制',
        ));
    }

    protected function responseJsonFailInsufficient($ret=array()) {
    
        $this->responseJson(array(
            'code' => self::CODE_FAIL_INSUFFICIENT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '余额不足',
        ));
    }
    
    
    protected function responseJsonNotFound($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_NOT_FOUND,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '未发现',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
        ));
    }

    protected function responseJsonNotOwn($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_NOT_OWN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '未拥有',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
        ));
    }

    protected function responseJsonOccupied($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_OCCUPIED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '已占用',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
        ));
    }

    protected function responseJsonStatusFrozen($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_STATUS_FROZEN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '已冻结',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
        ));
    }

    protected function responseJsonStatusSystemFrozen($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_STATUS_SYSTEM_FROZEN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '已系统冻结',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
        ));
    }

    /* 关于数据库的错误的响应 */
    /* Responses of Database Failure */
    protected function responseJsonFailDbBegin($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_BEGIN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '数据库事务开始错误',
        ));
    }

    protected function responseJsonFailDbCommit($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_COMMIT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '数据库事务提交错误',
        ));
    }

    protected function responseJsonFailDbCreate($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_CREATE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '数据库插入数据错误',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
            'message' => array_key_exists('message', $ret) ? $ret['message'] : NULL,
        ));
    }

    protected function responseJsonFailDbUpdate($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_UPDATE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '数据库更新数据错误',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
            'message' => array_key_exists('message', $ret) ? $ret['message'] : NULL,
        ));
    }

    protected function responseJsonFailDbDelete($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_DELETE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '数据库更新数据错误',
            'model' => array_key_exists('model', $ret) ? $ret['model'] : '',
            'message' => array_key_exists('message', $ret) ? $ret['message'] : NULL,
        ));
    }

    protected function responseJsonFailDbUniqueCol($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_DB_UNIQUE_COL,
            'desc' => '数据库插入了重复的记录',
        ));
    }

    /* 关于文件上传的错误的响应 */
    /* Responses of Upload Failure */
    protected function responseJsonFailFile($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_FILE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传文件错误',
        ));
    }

    protected function responseJsonFailImage($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_IMAGE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传图片文件错误',
        ));
    }

    protected function responseJsonFailImageType($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_IMAGE_TYPE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传图片类型错误',
        ));
    }

    protected function responseJsonFailImageFormat($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_IMAGE_FORMAT,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传图片格式错误',
        ));
    }

    protected function responseJsonFailImageSize($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_IMAGE_SIZE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传图片尺寸错误',
        ));
    }

    protected function responseJsonFailImageRatio($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_IMAGE_RATIO,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传图片比例错误',
        ));
    }

    /* 关于微信的错误的响应 */
    /* Responses of Failure Related to Weixin */
    protected function responseJsonFailWeiXinLogin($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_LOGIN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '微信登录失败',
        ));
    }

    protected function responseJsonFailWeiXinLoginRefreshToken($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_LOGIN_REFRESH_TOKEN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '刷新access_token失败',
        ));
    }

    protected function responseJsonFailWeiXinLoginInvalidRefreshToken($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_LOGIN_INVALID_REFRESH_TOKEN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '无效的refresh_token',
        ));
    }

    protected function responseJsonFailWeiXinOpen($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '微信开放平台错误',
        ));
    }

    protected function responseJsonFailWeiXinOpenUnauthorized($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_UNAUTHORIZED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '微信公众号未授权',
        ));
    }

    protected function responseJsonFailWeiXinOpenAuthorization($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_GET_AUTHORIZATION_INFO,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '获取授权信息失败',
        ));
    }

    protected function responseJsonFailWeiXinOpenAuthorizer($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_GET_AUTHORIZER_INFO,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '获取授权用户信息失败',
        ));
    }

    protected function responseJsonFailWeiXinOpenUpload($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_UPLOAD,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '上传资源到微信失败',
        ));
    }

    protected function responseJsonFailWeiXinOpenSendNews($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_SEND_NEWS,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '发送图文失败',
        ));
    }

    protected function responseJsonFailWeiXinOpenHasSentNews($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_HAS_SENT_NEWS,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '今天已发送图文',
        ));
    }

    protected function responseJsonFailWeiXinOpenNotVerified($ret=array()) {
        $this->responseJson(array(
            'code' => self::CODE_FAIL_WEIXIN_OPEN_NOT_VERIFIED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '公众号未认证',
        ));
    }

    /* 关于百万葵园的错误操作的响应 */
    /* Responses Related to Bai Wan Kui Yuan */
    protected function responseJsonFailBwkyHasPlanted($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_HAS_PLANTED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '您已经在种植葵花了',
        ));
    }

    protected function responseJsonFailBwkyHasWatered($ret= array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_HAS_WATERED,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '今天您已经浇过水了',
        ));
    }

    protected function responseJsonFailBwkyCanNotPick($ret= array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_CAN_NOT_PICK,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '还不能采摘',
        ));
    }

    protected function responseJsonFailBwkyNoGrass($ret= array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_NO_GRASS,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '没有长草哦',
        ));
    }

    protected function responseJsonFailBwkyNoBane($ret= array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_NO_BANE,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '没有虫子',
        ));
    }

    protected function responseJsonFailBwkyNoFertilizer($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_NO_FERTILIZER,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '没有肥料',
        ));
    }

    protected function responseJsonFailBwkyHasDead($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_HAS_DEAD,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '花已经死掉了',
        ));
    }

    protected function responseJsonFailBwkyReachMaxFertilizerDays($ret=array()) {

        $this->responseJson(array(
            'code' => self::CODE_FAIL_BWKY_REACH_MAX_FERTILIZER_DAYS,
            'desc' => array_key_exists('desc', $ret) ? $ret['desc'] : '施肥天数达到最大值',
        ));
    }

}
// the script ends here with no PHP closing tag
