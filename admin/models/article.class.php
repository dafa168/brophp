<?php 
Class article {

	//文件上传
	function upload(){

		$up = new FileUpload() ;

		//设置参数
		$up->set('allowtype', array('gif', 'jpg', 'jpeg', 'png'))
			->set('maxsize', 2000000) ;
			// ->set('thumb', array('width'=>300, 'height'=>300))
			// ->set('watermark', array('water'=>'logo.gif', 'position'=>5)) ;

		if ($up->upload('pic')){
			return $up->getFileName() ;
		}else{
			$this->setMsg($up->getErrorMsg()) ;
			return false ;
		}

	}


}
 ?>