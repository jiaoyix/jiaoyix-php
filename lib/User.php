<?php

namespace Jiaoyix;

class User extends ApiResource
{
    /**
     * @param string|null $id
     * @param array|string|null $opts
     *
     * @return Account
     */
    public static function retrieve($id = null, $params = null, $opts = null)
    {
        if (!$opts && is_string($id) && substr($id, 0, 5) === 'user_') {
            $opts = $id;
            $id = null;
        }
        return self::_retrieve($id, $params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Account
     */
    public static function create($params = null, $opts = null)
    {
        return self::_create($params, $opts);
    }

    /**
     * @param array|string|null $opts
     *
     * @return Account
     */
    public function save($params = null, $opts = null)
    {
        return $this->_save();
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection of Accounts
     */
    public static function all($params = null, $opts = null)
    {
        return self::_all($params, $opts);
    }
}
