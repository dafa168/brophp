<?php

class Index extends common {
    
    //后台首页
    public function index() {
        $GLOBALS["debug"] = 0;
        $this->display();
    }

    //输出系统信息
    public function main() {
        $m = D();
        $arr = gd_info(); //GD info
        $set = array(
            'dbVersion' => $m->dbVersion(),
            'dbSize' => $m->dbSize(),
            'fkVersion' => '1.0',
            'domain' => $_SERVER['SERVER_NAME'],
            'software' => $_SERVER['SERVER_SOFTWARE'],
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'gdVersion' => $arr['GD Version'],
            'Register_Globals' => ini_get("register_globals") ? 'On' : 'Off',
            'Magic_Quotes_Gpc' => ini_get("magic_quotes_gpc") ? 'On' : 'Off',
            'uploadMaxSize' => ini_get("post_max_size"),
        );

        $this->assign('set', $set);
        $this->display();
    }

}
