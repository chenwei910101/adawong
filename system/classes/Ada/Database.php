<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ���ݿ���ʲ�����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Database {

	/**
	* �����ѯ����,ִ��һ����ѯ���
	*/
	abstract public	function select($sql);
	
	/**
	* ������뷽��,ִ��һ���������
	*/
	abstract public	function insert();
	
	/**
	* ������·���,ִ��һ���������
	*/
	abstract public	function update();
	
	/**
	* ����ɾ������,ִ��һ��ɾ�����
	*/
	abstract public	function delete();

	protected	function __construct() {}
}