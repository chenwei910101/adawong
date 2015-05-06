<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Mysql��չ���ݿ���������ʵ����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Driver_Mysql extends Ada_Database_Driver {

	//���ݿ�������Ϣ
	private $config;
	//���Ӿ��
	private $identity;
	//resource
	protected $resource;

	public function __construct($config) {
		$this->config = $config;
	}

	/**
	* ִ��һ����ѯ���
	* @param String $sql ��ѯ���
	* @return Object Ada_Database_Driver_Mysql_Result
	*/
	public function select($sql){
		$this->dblink();
		$this->query($sql);
		return new	Ada_Database_Driver_Mysql_Result($this->resource);
	}

	/**
	* ִ��һ���������
	* @param String $table ���ݿ����
	* @param Array $params ��������,��������key��Ϊ�ֶ���
	* @return Bool
	*/
	public function insert($table, $params){
		$this->dblink();
		if ($this->query(Ada_Database_Query::InsertString($table, $params))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* ִ��һ���������
	* @param String $table ���ݿ����
	* @param Array $params ��������,��������key��Ϊ�ֶ���
	* @param String $where ��������
	* @return Bool
	*/
	public function update($table, $params, $where=NULL){
		$this->dblink();
		return $this->query(Ada_Database_Query::updateString($table, $params, $where));
	}

	/**
	* ִ��һ��ɾ�����
	* @param String $table ���ݿ����
	* @param String $where ɾ������
	* @return Bool
	*/
	public function delete($table, $where=NULL){
		$this->dblink();
		return $this->query(Ada_Database_Query::deleteString($table, $params, $where));
	}

	/**
	* ��������������id
	* @param Void
	* @return Int
	*/
	public function lastId() {
		return mysql_insert_id($this->identity);
	}

	/**
	* ����Ӱ�������
	* @param Void
	* @return Int
	*/				
	public function affect() {
		return mysql_affected_rows($this->identity);
	}

	/**
	* ��������
	* @param Void
	* @return Bool
	*/
	public function start() {
		$this->dblink();
		return $this->query("START transaction");
	}
	
	/**
	* �ع�����
	* @param Void
	* @return Bool
	*/
	public function rollback() {
		$this->dblink();
		return $this->query("ROLLBACK");
	}

	/**
	* �ύ����
	* @param Void
	* @return Bool
	*/
	public function commit() {
		$this->dblink();
		return $this->query("COMMIT");
	}

	private function dblink() {
		if (is_resource($this->identity)) {
			return TRUE;
		}
		if(!$this->identity = @mysql_connect($this->config['hostname'], $this->config['username'], $this->config['password'])) {
			throw new Ada_Exception(mysql_error(), mysql_errno());
		}
		$this->query("SET NAMES {$this->config['charset']}");
		return TRUE;
	}

	/**
	* ѡ�����ݿ�
	*/
	private function choose() {
		if(!mysql_select_db($this->config['database'])) {
			throw new Ada_Exception(mysql_error(), mysql_errno());
		}
		return TRUE;
	}
	
	/**
	* ִ�����
	*/
	private function query($sql) {
		$this->choose();
		if(!$this->resource = mysql_query($sql, $this->identity)) {
			throw new Ada_Exception(mysql_error(), mysql_errno());
		}
		return TRUE;
	}

	public function __destruct() {
		if (is_resource($this->identity)) {
			mysql_close($this->identity);
		}
	}
}