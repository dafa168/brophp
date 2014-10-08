<?php
	//全局可以使用的通用函数声明在这个文件中.

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
	$type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 上传图片 返回小图 中图 原图
  * @param string $input file输入框名称
 * @return mixed
 */
/*
在控制器中使用
$up = upload() ;
if ($up[0]){
    $_POST['ori_ic'] = $up[1] ;
    $_POST['zt_pic'] = 'zt_' . $up[1] ;
    $_POST['xt_pic'] = 'xt_' . $up[1] ;
}else{
    $this->error($up[1], 3, 'add') ;
}
*/
function upload($input){

    $up = new FileUpload() ;

    // $up->set('thumb', array('width'=>400, 'height'=>400)) ; //设置缩略图

    // $up->set('watermark', array( 'water'=>'./public/images/water.gif', 'position'=>9 )) ; //打水印

    if ($up->upload($input)){

        $yt = $up->getFileName() ; //获取原图名称

        $img = new Image() ;

        $img->thumb($yt, 150, 150, 'xt_') ; //缩略小图
        $img->thumb($yt, 150, 150, 'zt_') ; //缩略小图

        return array('true', $yt) ; //返回原图

    }else{
        return array( 'false', $up->getErrorMsg() ) ;
    }


}