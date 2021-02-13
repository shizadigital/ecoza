<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log {
    
    protected $CI;
    
    public function __construct(){
		$this->CI =& get_instance();
	}

	/**
	 * create log activity
	 *
	 * @param string $msg
	 * @param string $logType
	 * @param string $logTable
	 * @return bool
	 */
	public function set_log($msg = null, $logType = null, $logTable = null, $masterId = null){
		$ci = $this->CI;

		if(get_option('logactivity')==='y'){

			$getId = getNextId('logId', 'activity_log');

			$logTable 	= ($logTable!=null) ? filter_txt($logTable):'';
			$logType 	= ($logType!=null) ? filter_txt($logType):'';
			$msg 		= ($msg!=null) ? filter_txt($msg):'';
			$masterId 	= ($masterId!=null) ? filter_txt($masterId):'';

			$logData = [
				'logId' => $getId,
				'storeId' => storeId(),
				'userLogin' => (string) filter_txt($ci->session->userdata('username')),
				'logTable' => (string)$logTable,
				'logIdMaster' => $masterId,
				'logType' => (string)$logType,
				'logDescription' => (string)$msg,
				'logURL' => this_url(),
				'logDateTime' => date('Y-m-d H:i:s'),
				'logIP' => getIP(),
				'logBrowser' => getBrowser(true),
				'logOS' => getOS()
			];
			return $ci->sm->insert('activity_log', $logData);

		} else {

			return true;

		}
	}

	
}
