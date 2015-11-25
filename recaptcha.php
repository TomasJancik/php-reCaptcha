<?php
/**
* This class handles server side verification of Google's reCaptcha v2
*/
class reCaptcha {
	private static $url = 'https://www.google.com/recaptcha/api/siteverify';
	
	/** @var string */
	private $secret;
	
	/**
	* Set the secret key for your SITE
	*/
	public function setSecret($secret) {
		$this->secret = $secret;
	}
	
	/**
	* Makes the verification reques to Google
	* @var response The POST['g-recaptcha-response'] string. If left empty, it's loaded automaticaly
	* @return bool
	*/
	public function verify($response = false) {
		if(empty($this->secret)) {
			throw new RuntimeException('The SECRET was not set');
		}
		
		if(!$response) {
			$response = $_POST['g-recaptcha-response'];
		}
	
		// prepare cURL request to verify
		$curl = curl_init(self::$url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array(
			'secret' => $this->secret,
			'response' => $response,
			'remoteIp' => $_SERVER['REMOTE_ADDR']
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$result = json_decode(curl_exec($curl));
		
		return $result->success;
	}
}
