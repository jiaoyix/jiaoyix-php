<?php

namespace Jiaoyix;

class Product extends ApiResource
{
    /**
     * @param string $id The ID of the Product to retrieve.
     * @param array|string|null $opts
     *
     * @return Product
     */
    public static function retrieve($id, $params = null, $opts = null)
    {
        return self::_retrieve($id, $params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Product The created Product.
     */
    public static function create($params = null, $opts = null)
    {
        return self::_create($params, $opts);
    }

    /**
     * @param array|string|null $opts
     *
     * @return Product The saved Product.
     */
    public function save($params = null, $opts = null)
    {
        return $this->_save($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Collection of Products
     */
    public static function all($params = null, $opts = null)
    {
        return self::_all($params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Product The deleted product.
     */
    public function delete($params = null, $opts = null)
    {
        return $this->_delete($params, $opts);
    }
}
