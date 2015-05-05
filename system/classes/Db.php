<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ���ݿ���ʲ�������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Db {
	//���浥������
	private static $instance = NULL;

	/**
	* ��ȡһ����������ʵ��
	*/
	public static function factory($name='default', $config=NULL) {
		if (self::$instance === NULL){
			if ($config === NULL) {
				$config = Config::load('database');
			}
			if (isset($config[$name], $config[$name]['driver'])) {
				$driver = 'Ada_Database_Driver_'.$config[$name]['driver'];
				self::$instance = new $driver();
			} else {
				throw new Ada_Exception('No database configuration file specified');
			}
		}
		return self::$instance;
	}
}