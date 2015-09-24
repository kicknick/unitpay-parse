<?php

require '../parse-php-sdk-master/autoload.php'; 
use Parse\ParseClient;
ParseClient::initialize('Application ID', 'REST API Key', 'Master Key');

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;



class UnitPay{

	public function getResult($req) {

		if(empty($req['method']) || empty($req['params']) || !is_array($req['params'])) {
			return $this->getResponseError("invalid request");
		}

		$method=$req['method'];
		$params=$req['params'];

		if($method=='check') {
			return $this->getResponseSuccess('CHECK is successful');
		}


		if($method=='pay') {
			return $this->pay($params);
		}
	}

    private function getResponseSuccess($message) {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "result" => array(
                "message" => $message
            ),
            'id' => 1,
        ));
    }

    private function getResponseError($message) {
        return json_encode(array(
            "jsonrpc" => "2.0",
            "error" => array(
                "code" => -32000,
                "message" => $message
            ),
            'id' => 1
        ));
    }


    private function pay($params) {
    	$sum = $params['sum'];
    	$profit = $params['profit'];
    	$unitpayId = $params['unitpayId'];
    	$account = $params['account'];
    	$paymentType = $params['paymentType'];
    	$orderSum = $params['orderSum'];
        $date = $params['date'];
        $paymentType = $params['paymentType'];
        $orderCurrency = $params['orderCurrency'];
        // $errorMessage = $params['errorMessage'];

    	$unitPay = new ParseObject("UnitPay");
    	$unitPay->set('sum', $sum);
    	$unitPay->set('profit', $profit);
    	$unitPay->set('unitpayId', $unitpayId);
    	$unitPay->set('account', $account);
    	$unitPay->set('paymentType', $paymentType);
    	$unitPay->set('orderSum', $orderSum);
        $unitPay->set('date', $date);
        $unitPay->set('paymentType', $paymentType);
        $unitPay->set('orderCurrency', $orderCurrency);
        // $unitPay->set('errorMessage', $errorMessage);

	    try{
			$unitPay->save();
			// $parseId = $unitPay->getObjectId();
			return $this->getResponseSuccess('PAY is successful');

		} catch (ParseException $ex) {
			return $this->getResponseError('pay error');
		}
    } 	
}


$unitPay = new UnitPay();
echo $unitPay->getResult($_GET);



// CHECK
// account date operator orderCurrency orderSum paymentType phone profit projectId sign sum unitpayId

// PAY
// account date operator orderCurrency orderSum paymentType phone profit projectId sign sum unitpayId
