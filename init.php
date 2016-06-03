<?php

// Jiaoyix singleton
require(dirname(__FILE__) . '/lib/Jiaoyix.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/AutoPagingIterator.php');
require(dirname(__FILE__) . '/lib/Util/RequestOptions.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');
require(dirname(__FILE__) . '/lib/Util/Util.php');
require(dirname(__FILE__) . '/lib/Util/QrCode.php');

// HttpClient
require(dirname(__FILE__) . '/lib/HttpClient/ClientInterface.php');
require(dirname(__FILE__) . '/lib/HttpClient/CurlClient.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/RateLimit.php');

// Plumbing
require(dirname(__FILE__) . '/lib/ApiResponse.php');
require(dirname(__FILE__) . '/lib/JsonSerializable.php');
require(dirname(__FILE__) . '/lib/JiaoyixObject.php');
require(dirname(__FILE__) . '/lib/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/AttachedObject.php');
require(dirname(__FILE__) . '/lib/WebhookServer.php');

// Jiaoyix API Resources
require(dirname(__FILE__) . '/lib/Charge.php');
require(dirname(__FILE__) . '/lib/Collection.php');
require(dirname(__FILE__) . '/lib/Order.php');
require(dirname(__FILE__) . '/lib/OrderCancelApplication.php');
require(dirname(__FILE__) . '/lib/Product.php');
require(dirname(__FILE__) . '/lib/SKU.php');
require(dirname(__FILE__) . '/lib/User.php');
require(dirname(__FILE__) . '/lib/ApplicationFee.php');
require(dirname(__FILE__) . '/lib/Event.php');
require(dirname(__FILE__) . '/lib/Refund.php');
require(dirname(__FILE__) . '/lib/Transfer.php');
// Jiaoyix Pay
require(dirname(__FILE__) . '/lib/WxPay.php');
require(dirname(__FILE__) . '/lib/WxpubOAuth.php');
