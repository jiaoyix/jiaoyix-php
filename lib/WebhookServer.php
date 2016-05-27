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
            \Logger::writeln($log_path, 'start Jiaoyix SDK WebhookServer run');

            if (!$this->authentication()) {
                \Logger::writeln($log_path, 'start Jiaoyix SDK WebhookServer run: no authentication');
                throw new Restful_Exception('authentication failed', 100);
            }

            $input = file_get_contents('php://input');
            $message = array('input' => $input);
            \Logger::writeln($log_path, json_encode($message));

            $decode_input = json_decode($input, true);
            if ($decode_input) {
                // TODO 验证交易+签名
                \Logger::writeln($log_path, 'is decode_input true');
                call_user_func($this->_eventCallback, $decode_input);
            }
        } catch (Exception $e) {
            $message['exception']['code'] = $e->getCode();
            $message['exception']['message'] = $e->getMessage();
            Logger::writeln($log_path, json_encode($message));
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
