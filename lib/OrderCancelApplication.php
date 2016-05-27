<?php

namespace Jiaoyix;

class OrderCancelApplication extends ApiResource
{
    /**
     * @return string The API URL for this Jiaoyix OrderCancelApplication.
     */
    public static function classUrl()
    {
        return "/v1/order_cancel_applications";
    }

    /**
     * @param string $id The ID of the Order to retrieve.
     * @param array|string|null $opts
     *
     * @return Order
     */
    public static function retrieve($id, $params = null, $opts = null)
    {
        return self::_retrieve($id, $params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Order The created Order.
     */
    public static function create($params = null, $opts = null)
    {
        return self::_create($params, $opts);
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
