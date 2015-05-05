<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ���ܽ��ܾ���ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class	Ada_Crypt_Xor{
	
	/**
	* �����Ľ��м���
	* @param	String	$encode	�����ַ�
	* @param	String	$secret	������Կ
	* @return	String	���ؼ���֮�������
	*/
	public	static	function	encode ($string, $secret) {
		$text = '';
		$index = $i = 0;
		$count = array();
		$chars = md5($secret);
		$count[] = strlen($chars);
		$count[] = strlen($string);
		while ($i < $count[1]) {
			if ($index == strlen($count[0])) $index = 0;
			$text.= $chars[$index].($string[$i] ^ $chars[$index++]);
			$i++;
		}
		return	base64_encode(self::secret($text, $secret));
	}
	
	/**
	* �����Ľ��н���
	* @param	String	$encode	�����ַ�
	* @param	String	$secret	������Կ
	* @return	String	���ؽ���֮�������
	*/
	public	static	function	decode ($string, $secret) {
		$text = '';
		$index = 0;
		$string = self::secret(base64_decode($string), $secret);
		$count = strlen($string);
		while ($index < $count) {
			$code = $string[$index];
			$text.= $string[++$index] ^ $code;
			$index++;
		}
		return	$text;
	}
	
	/**
	* �����ĺ���Կ���м��ܽ���
	* @param	String	$string	����
	* @param	String	$secret	��Կ
	* @return	String	���ؼ��ܵ�����
	*/
	private	static	function	secret ($string, $secret) {
		$text = '';
		$index = $i = 0;
		$count = array();
		$chars = md5($secret);
		$count[] = strlen($chars);
		$count[] = strlen($string);
		while ($i < $count[1]) {
			if ($index == strlen($count[0])) $index = 0;
			$text.= $string[$i] ^ $chars[$index++];
			$i++;
		}
		return	$text;
	}
}