<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Mysql��չ���ݿ���������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Driver_Mysql extends Ada_Database{
	
	private $db;

	public function __construct() {
	
	}

	/**
	* ִ��һ����ѯ���
	* @param String $sql ��ѯ���
	* @return Object Ada_Database_Result_Selectʵ��
	*/
	public function select($sql){
		return new	Ada_Database_Result_Select($this);
	}

	public function update(){
	
	}

	public function insert(){
	
	}

	public function delete(){
	
	}
	
	protected function dblink(){
		
	}

	public function __destruct(){
		
	}
}