<?php 
Class comment extends common{

	public function index(){

		$model = D('comment') ;
		$count = $model->total() ;
		/*
			参数一：  传递总数
			参数二：  每页显示条数
			参数三：  附加参数 
		*/
		$page = new Page($count, 10) ;
		$data = $model->limit($page->limit)->select() ;

		$this->assign( 'page', $page->fpage() ) ;
		$this->assign('data', $data) ;
		$this->display() ;
	}

	public function del(){
		$id = !empty($_GET['id']) ? intval($_GET['id']) : '' ;

		$model  =  D('comment') ;
		
		if ($model->where(array('id'=>$id))->delete()){
			$this->success('删除成功',2,'comment/index') ;
		}else{
			$this->error('删除失败!',2,'comment/index') ;
		}
	}

}
 ?>