<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Request {

	//����uri
	protected	static $uri = '';
	//����˿�
	protected	static $port = 80;
	//��Ӧ����
	protected	static $body = '';
	//���󷽷�
	protected	static $methods = array('GET', 'POST');
	//�������
	protected	static $params = array();
	//����Э��
	protected	static $protocol = 'http';
	//���浥������
	protected	static $instance = NULL;
	
	/**
	* ��ȡһ������ʵ��
	* ����һ��Requestʵ�����������û��ָ��uri����uriû�а���http�����ж�Ϊ�ڲ����󣬷����ж�Ϊ�ⲿ����
	* @param String $uri �����uri
	* @return Ref
	*/
	public static function factory($uri=NULL) {
		if (self::$instance === NULL) {
			self::$instance = new Request($uri);
		}
		self::$uri = $uri;
		return	self::$instance;
	}
	
	/**
	* ����httpЭ������ʽ,���������ǰ�����$this->methods������
	* @param String $method ����ʽ
	* @param Mixed	$params	�������
	* @return Ref
	*/
	public function method($method='get', $params = NULL) {
		$method = strtoupper($method);
		if (!in_array($method, self::$methods)) {
			throw new Ada_Exception('Request method error');
		}
		self::$params = $params;
		return	self::$instance;
	}

	/**
	* ����uri�Ƿ����http��ȷ��ִ���ڲ������ⲿ����
	* @param Void
	* @return Ref
	*/
	public function execute() {
		if (strpos(self::$uri, self::$protocol) !== FALSE) {
			return	$this->external(); //�ⲿ����
		} else {
			return	$this->internal(); //�ڲ�����
		}
	}

	/**
	* �ڲ�����
	* request::factory('welcome/say')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function internal() {
		new	Ada_Request_Internal(Route::factory()->routes(Config::load('Route'))->matchs($this->uri()));
	}
	
	/**
	* �ⲿ����
	* request::factory('http://www.baidu.com')->method()->execute()->body();
	* @param Void
	* @return Void
	*/
	private function external() {
		new	Ada_Request_External();
	}
	
	/**
	* ��ȡ��ǰ�����uri
	* @param Void
	* @return String
	*/
	private function uri() {
		if (self::$uri != NULL) {
			return	self::$uri;
		} else {
			return '';
		}
	}

	/**
	* ���췽��
	* @param String $uri �����uri
	*/
	private	function __construct($uri) {
		self::$uri = $uri;
	}


	public function __toString(){
		return self::$body;
	}
}