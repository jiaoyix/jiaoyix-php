<?php
namespace Jiaoyix;
require_once('WxPay/WxPay.Api.php');
require_once('WxPay/WxPay.NativePay.php');

/**
 * 微信支付类
 * 基于微信官方支付 PHP-SDK 实现
 */
class WxPay
{

    /**
     * setWxPayConfig
     * 除 notify 方法外，其他方法的调用请先设置微信支付相关信息，既首先调用本方法
     * @return void
     */
    public static function setWxPayConfig($config)
    {
        WxPayConfig::$app_id = $config['app_id'];
        WxPayConfig::$mch_id = $config['mch_id'];
        WxPayConfig::$key = $config['key'];
        WxPayConfig::$app_secret = $config['app_secret'];
        WxPayConfig::$notify_url = $config['notify_url'];
    }

    /**
     *
     * 支付结果通用通知
     */
    public static function notify($callback, &$msg)
    {
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //如果返回成功则验证签名
        try {
            $wxpay_data_base = new WxPayDataBase();
            $result = $wxpay_data_base->FromXml($xml);

            $result = $wxpay_data_base->GetValues();

        } catch (WxPayException $e){
            $msg = $e->errorMessage();
            return false;
        }

        return call_user_func($callback, $result);
    }

    /**
     *
     * 验证微信签名
     */
    public static function checkSign()
    {
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //如果返回成功则验证签名
        try {
            $result = WxPayResults::Init($xml);
        } catch (WxPayException $e){
            return false;
        }

        return true;
    }

    /**
     *
     * 生成扫描支付URL,模式一
     * @param product_id 商品ID
     */
    public static function getPrePayUrl($product_id)
    {
        $notify = new NativePay();
        $url = $notify->GetPrePayUrl($product_id);

        return $url;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput $input
     */
    public static function getPayUrl($input)
    {
        $notify = new NativePay();
        $result = $notify->GetPayUrl($input);
        $url = $result["code_url"];

        return $url;
    }

    /**
     *
     * 按类型获取支付凭证
     * @param data
     */
    public static function getPayConfig($data)
    {
        $input = self::getUnifiedOrder($data);
        $config = WxPayApi::unifiedOrder($input);

        if ($config['return_code'] == 'FAIL') {
            throw new WxPayException($config['return_msg'], 1);
        }

        if ($data['trade_type'] = 'JSAPI') {
            $jsapi = new WxPayJsApiPay();

            $jsapi->SetAppid($config["appid"]);
            $jsapi->SetTimeStamp(strtotime($data['time_start']));
            $jsapi->SetNonceStr(WxPayApi::getNonceStr());
            $jsapi->SetPackage("prepay_id=" . $config['prepay_id']);
            $jsapi->SetSignType("MD5");
            $jsapi->SetPaySign($jsapi->MakeSign());
            $parameters = json_encode($jsapi->GetValues());

            return $parameters;
        } else if ($data['trade_type'] = 'APP') {
            // TODO HBuilder
            // // 参与签名的字段名为appId，partnerId，prepayId，nonceStr，timeStamp，package。注意：package的值格式为Sign=WXPay
            // $time_stamp = time();
            // $pack   = 'Sign=WXPay';
            // //输出参数列表
            // $prePayParams =array();
            // $prePayParams['appid']      =$config['appid'];
            // $prePayParams['partnerid']  =$config['mch_id'];
            // $prePayParams['prepayid']   =$config['prepay_id'];
            // $prePayParams['noncestr']   =$config['nonce_str'];
            // $prePayParams['package']    =$pack;
            // $prePayParams['timestamp']  =$time_stamp;
            // $prePayParams['sign']       =$config['sign'];

            // return $prePayParams;
        }

        return $config;
    }

    /**
     *
     * 生成预支付订单
     * @param data
     *  + body
     *  + out_trade_no
     *  + total_fee
     *  + product_id
     *  + time_expire
     *  + attach
     *  + openid
     */
    public static function getUnifiedOrder($data)
    {
        $input = new WxPayUnifiedOrder();

        // 商品描述
        $body = '商品付款';
        if ($data['body']) {
            $body = $data['body'];
        }
        $input->SetBody($body);

        // 商户订单号
        $input->SetOut_trade_no($data['out_trade_no']);

        // 订单交易总额
        $input->SetTotal_fee($data['total_fee']);

        // 商品ID
        if ($data['product_id']) {
            $input->SetProduct_id($data['product_id']);
        }

        $input->SetTime_start(date("YmdHis", $data['time_start']));

        // 订单过期时间，微信最长过期时间可设置为 2 小时，最短为5分钟
        $input->SetTime_expire(date("YmdHis", strtotime($data['time_start']) + 7200));

        // 订单通知回调的 url
        $input->SetNotify_url(WxPayConfig::$notify_url);

        // 支付类型：扫码支付
        $input->SetTrade_type($data['trade_type']);

        // 选填参数设置
        if ($data['attach']) {
            $input->SetAttach($data['attach']);
        }

        // 扫码支付模式一，第一次微信回调会带有用户的 openid，请求生成预支付 id 时需要加入到请求参数内
        if ($data['openid']) {
            $input->SetOpenid($data['openid']);
        }

        return $input;
    }
}
