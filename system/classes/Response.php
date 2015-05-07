<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http��Ӧ������
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Response extends Ada_Response{

	//��Ӧ����
	private $body = '';
	
	/**
	* ��ȡHttp��Ӧ����
	* @param Void
	* @return String
	*/
	public function body() {
		if(func_num_args() > 0) {
			$this->body = func_get_arg(0);
		}
		return $this->body;
	}
	
	/**
	* ��ȡHttp��Ӧ״̬��
	* @param Void
	* @return Int
	*/
	public function code() {
		return 200;
	}

	public function __toString() {
		return $this->body;
	}
}