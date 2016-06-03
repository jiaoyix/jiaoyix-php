<?php

namespace Jiaoyix;

class Transfer extends ApiResource
{
    /**
     * @param string $id The ID of the transfer to retrieve.
     * @param array|string|null $opts
     *
     * @return Transfer
     */
    public static function retrieve($id, $opts = null)
    {
        return self::_retrieve($id, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection of Transfers
     */
    public static function all($params = null, $opts = null)
    {
        return self::_all($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Transfer The created transfer.
     */
    public static function create($params = null, $opts = null)
    {
        return self::_create($params, $opts);
    }
}
