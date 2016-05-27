<?php

namespace Jiaoyix;

class Charge extends ApiResource
{
    /**
     * @param string $id The ID of the charge to retrieve.
     * @param array|string|null $options
     *
     * @return Charge
     */
    public static function retrieve($id, $params = null, $options = null)
    {
        return self::_retrieve($id, $params, $options);
    }

    /**
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return Charge The created charge.
     */
    public static function create($params = null, $options = null)
    {
        $log_path = 'wechat/pay.' . date('Y-m-d') . '.log';
        $message = array(
            'start' => 'Jiaoyix SDK Charge create',
            'params' => $params,
        );
        // 判断是否使用jiaoyix的支付系统
        if ($params['use_jiaoyix_id']) {
            return self::_create($params, $options);
        }

        // 如果APP使用自己的支付系统，需要生成第三方支付的请求配置，并更新prepayid到jiaoyix进行记录方便与微信对账使用
        $charge = self::_create($params, $options);

        return $charge;
    }

    /**
     * @param array|string|null $opts
     *
     * @return Order The saved Order.
     */
    public function save($params = null, $opts = null)
    {
        return $this->_save($params, $opts);
    }
}
