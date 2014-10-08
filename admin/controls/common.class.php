<?php
class Common extends Action {

	//初始化
	function init(){

		// if(!file_exists("./runtime/install.lock")){
		// 	header("Location:./install/index.php");
		// }  //以后要做的安装程序

		if(!(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"]===1)){
			$this->redirect("login/index");
		}
		
		//权限判断
		/*
		$webadmin=array('base','flink','album', 'image','column','notice');
		if(in_array($_GET["m"], $webadmin) && $_SESSION["webadmin"]!=1){
			$this->error("权限不足，你不是网络编辑不能操作这个模块", 3, "index/index");
		}
		$articleadmin=array('article', 'play');
		if(in_array($_GET["m"], $articleadmin) && $_SESSION["articleadmin"]!=1){
			$this->error("权限不足，你不能对文章进行操作", 3, "index/index");
		}
		$useradmin=array('admin', 'group');
		if(in_array($_GET["m"], $useradmin) && $_SESSION["useradmin"]!=1){
			$this->error("权限不足，你不能对用户及用户组进行管理", 3, "index/index");
		}
		*/

		//判断权限
		if ( $_GET['m'] == 'goods' && $_SESSION['goodsadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'page' && $_SESSION['pageadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'sort' && $_SESSION['sortadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'group' && $_SESSION['groupadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'comment' && $_SESSION['commentadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'admin' && $_SESSION['adminadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'article' && $_SESSION['articleadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index') ;
		}
		if ( $_GET['m'] == 'cate' && $_SESSION['cateadmin'] != 1 ){
			$this->error("用户{$_SESSION['username']}没有权限访问此模块 ！", 2, 'index/index' ) ;
		}

		//判断某个模块下的操作权限
		// if ( $_GET['m'] == 'cate' && $_GET['a'] == 'add' && $_SESSION['add'] != 1 ){
		// 	$this->error("用户{$_SESSION['username']}没有权限访问此模块添加操作 ！", 2, 'index/index') ;
		// }

	}

	//显示信息
	function mess($mess="ok", $is=null){
		$message="";
		if(is_array($mess)){
			foreach($mess as $m){
				$message.=$m;
			}	
		}else{
			$message=$mess;
		}

		if(is_null($is)){
			$this->assign("mess", "");
		}else if($is){
			$this->assign("mess", "ok");
		}else{
			$this->assign("mess", "error");
		}
		$this->assign("tmess", $message);
	}

	function upimage(){
		$path=PROJECT_PATH.'public/uploads';
		
		global $pictureSize;
		$up=new FileUpload($path.'/tmp');
		
		$up->set("allowtype", array("gif", "png", "jpg", "jpeg"));
		
		   // ->set("thumb", array("width"=>$pictureSize["maxWidth"], "height"=>$pictureSize["maxHeight"]))
		   // ->set("watermark", array("water"=>$path.'/'.WATER, "position"=>POSITION));

		if($up->upload("upload")){
			$filename=$up->getFileName();
			// $_SESSION["article"][]=$filename;
			$this->mkhtml(B_PUBLIC."/uploads/tmp/".$filename);
		}else{
			$mess=strip_tags($up->getErrorMsg());	
			$this->mkhtml('', $mess);
		}
	}

	function upflash(){
		$up=new FileUpload(PROJECT_PATH.'public/uploads/tmp');
		$up->set("allowtype", array("flv","swf"));
		if($up->upload("upload")){
			$filename=$up->getFileName();
			// $_SESSION["article"][]=$filename;
			$this->mkhtml(B_PUBLIC."/uploads/tmp/".$filename);
		}else{
			$mess=strip_tags($up->getErrorMsg());	
			$this->mkhtml('', $mess);
		}
	}

	protected function mkhtml($fileurl,$message="") {
		$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].', \''.$fileurl.'\', \''.$message.'\');</script>';
		exit($str);
	}


}