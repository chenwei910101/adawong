<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ���ݿ��ѯ�������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Result_Select extends Ada_Database_Result {
	
	public function __construct(Ada_Database $object) {
	
	}

	/**
	* �����ݲ�ѯ�ṹ��ʽ��ΪXml
	* @param Void
	* @return Xml
	*/
	public function toXml(){
	
	}
	
	/**
	* �����ݲ�ѯ�ṹ��ʽ��ΪXml
	* @param Void
	* @return Object
	*/
	public function toObj(){
		
	}
	
	/**
	* ֱ�ӷ������ݲ�ѯ���\
	* @param Void
	* #return Array
	*/
	public function __toString() {
		return array();
	}
}