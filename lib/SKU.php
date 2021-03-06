<?php

namespace Jiaoyix;

class SKU extends ApiResource
{
    /**
     * @param string $id The ID of the SKU to retrieve.
     * @param array|string|null $opts
     *
     * @return SKU
     */
    public static function retrieve($id, $params = null, $opts = null)
    {
        return self::_retrieve($id, $params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return SKU The created SKU.
     */
    public static function create($params = null, $opts = null)
    {
        return self::_create($params, $opts);
    }

    /**
     * @param array|string|null $opts
     *
     * @return SKU The saved SKU.
     */
    public function save($params = null, $opts = null)
    {
        return $this->_save($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection of SKUs
     */
    public static function all($params = null, $opts = null)
    {
        return self::_all($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return SKU The deleted sku.
     */
    public function delete($params = null, $opts = null)
    {
        return $this->_delete($params, $opts);
    }
}
