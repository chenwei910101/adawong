<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* �ⲿ���������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Request_External extends Ada_Request {
	
	public function __construct() {
		if (extension_loaded('curl')) {
			$this->curl();
		} else if (function_exists('fsockopen')) {
			$this->fsoc();
		} else {
			$this->head();
		}

	}

	/**
	* curl����ʽ
	*/
	private	function curl() {
		$ch = curl_init(self::$uri);
		if (self::$method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array(self::$params) ? self::$params : array());
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		self::$body = curl_exec($ch);
		curl_close($ch);
	}
	
	/**
	* socket����ʽ
	*/
	private	function fsoc() {
		$uri = str_ireplace('http://', '' , self::$uri);
		$fp = fsockopen($uri, self::$port);
		$out = self::$method." / HTTP/1.1\r\n";
		$out.= "Host:{$uri}\r\n";
		$out.= "\r\n";
		fwrite($fp, $out);
		while(!feof($fp)) {
			echo self::$body.=fgets($fp);
		}
		fclose($fp);
	}
	
	/**
	* �Զ��崦��ʽ
	*/
	private function head() {
		
	}
}