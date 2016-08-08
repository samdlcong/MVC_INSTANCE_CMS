<?php

class adminModel{
	public $_table = 'user';

	public function getRow_by_username($username){
		$sql = 'select * from '.$this->_table.' where username="'.$username.'"';
		return  DB::getRow($sql);
	}

}