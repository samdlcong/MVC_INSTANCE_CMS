<?php

class newsModel {
	public $_table = 'news';
	public function count(){
		$sql = 'select count(*) from '.$this->_table;
		$arr=DB::getRow($sql);
		return $arr['count(*)'];
	}

	public function getnewsinfo($id){
		if(empty($id)){
			return array();
		}else{
			$id = intval($id);
			return DB::findById($this->_table,$id,$fields="*");
		}
	}

	public function newssubmit($data){
		extract($data);
		if(empty($title)||empty($content)){
			return 0;
		}
		$title = addslashes($title);
		$content = addslashes($content);
		$author = addslashes($author);
		$from = addslashes($from);
		$data = array(
			'title'=>$title,
			'content'=>$content,
			'author'=>$author,
			'from'=>$from,
			'dateline'=>time()
		);
		if($_POST['id']!=''){
			DB::update($this->_table,$data,$where="id={$id}",$order=null,$limit=null);
			return 2;	
		}else{
			DB::add($this->_table,$data);
			return 1;
		}
	}

	public function getAll_orderby_dateline(){
		return DB::find($this->_table,$where=null,$fields="*",$group=null,$having=null,$order="dateline desc",$limit=null);
	}

	public function del_by_id($id){
		return DB::delete($this->_table,$where="id = {$id}",$order=null,$limit=null);
	}

	public function get_news_list(){
		$data = $this->getAll_orderby_dateline();
		foreach ($data as $k => $news) {
			$data[$k]['content'] = mb_substr(strip_tags($data[$k]['content']),0,200);
			$data[$k]['dateline'] = date('Y-m-d H:i:s',$data[$k]['dateline']);
		}
		return $data;
	}
}