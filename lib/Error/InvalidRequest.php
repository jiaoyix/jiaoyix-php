<?php

namespace Jiaoyix\Error;

class InvalidRequest extends Base
{
    public function __construct(
        $message,
        $jiaoyixParam,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->jiaoyixParam = $jiaoyixParam;
    }

    public function getJiaoyixParam()
    {
        return $this->jiaoyixParam;
    }
}
