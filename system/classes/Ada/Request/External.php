<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* �ⲿ���������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Request_External extends Ada_Request {

	//��Ӧ����
	private $body = '';
	//�������
	private $request;
	
	/**
	* ���췽��
	* @param Request $request
	* @return Void
	*/
	public function __construct(Request $request) {
		$this->request = $request;
		if (!extension_loaded('curl')) {
			$body = $this->curl();
		} else if (function_exists('fsockopen')) {
			$this->fsoc();
		} else {
			$this->head();
		}
		$this->request->response->body($this->body);
	}

	/**
	* destruct
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->request, $this->body);
	}

	/**
	* ʹ��curl��չ��������
	* @param Void
	* @return String
	*/
	private	function curl() {
		$ch = curl_init($this->request->uri);
		if ($this->request->method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($this->request->params) ? $this->request->params : array());
		}
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$this->body = curl_exec($ch);
		//curl_getinfo($ch, CURLINFO_HTTP_CODE);  //״̬��
		curl_close($ch);
	}
	
	/**
	* ʹ��fsockopen��������
	* @param Void
	* @return Void
	*/
	private	function fsoc() {
		$uri = parse_url($this->request->uri);
		$data = '';
		if ($this->request->method == 'POST' && is_array($this->request->params)) {
			$data = http_build_query($this->request->params);
		}
		$fp = fsockopen($uri['host'], 80);
		$out = $this->request->method." ".(isset($uri['path']) ? $uri['path'] : '/')." HTTP/1.0 \r\n";
		$out.= "Host:".$uri['host']."\r\n";
		$out.= "Content-length:".strlen($data)."\r\n";
		$out.= "\r\n";
		if ($this->request->method == 'POST' && !empty($data)) {
			$out.= $data;
			$out.="Content-type:application/x-www-form-urlencoded\r\n";
		}
		fwrite($fp, $out);
		while(!feof($fp)) {
			$this->body.= fgets($fp);
		}
		fclose($fp);
	}

	/**
	* �Զ��崦��ʽ
	*/
	private function head() {
		
	}
}