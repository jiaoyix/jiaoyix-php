<?php

namespace Jiaoyix;

class WebhookServer
{
    /**
     * _app_id
     *
     * @var string
     */
    protected $_app_id;

    /**
     * _eventCallback
     *
     * @var string
     */
    protected $_eventCallback;

    /**
     * __construct
     */
    public function __construct($app_id) {
        $this->_app_id = $app_id;
    }

    /**
     * authentication
     *
     * @return boolean
     */
    public function authentication() {
        // TODO

        return true;
    }

    /**
     * run
     *
     * @return void
     */
    public function run() {

        try {
            $log_path = 'wechat/pay.' . date('Y-m-d') . '.log';

            if (!$this->authentication()) {
                throw new Restful_Exception('authentication failed', 100);
            }

            $input = file_get_contents('php://input');
            $message = array('input' => $input);

            $decode_input = json_decode($input, true);
            if ($decode_input) {
                // TODO 验证交易+签名
                call_user_func($this->_eventCallback, $decode_input);
            }
        } catch (Exception $e) {
            $message['exception']['code'] = $e->getCode();
            $message['exception']['message'] = $e->getMessage();
        }
    }

    /**
     * setEventCallback
     *
     * @return
     */
    public function setEventCallback($eventCallback) {
        $this->_eventCallback = $eventCallback;
    }

}
