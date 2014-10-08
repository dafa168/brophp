<?php

Class login extends Action {

    public function index() {
        $this->display();
    }

    //登录
    public function login() {

        $this->validate();
        
        $db = D('admin') ;
        $user = $db->field('id,gid,username,locked')
                ->where(array("username" => htmlspecialchars(trim($_POST['username'])), "password" => md5(md5(substr(trim($_POST['password']), 5, 15))), "locked" => 0))
                ->find();

        // p($user) ; die;

        if ($user) {
            $group = D("group")->field('gname,description,adminadmin,articleadmin,cateadmin,commentadmin,goodsadmin,pageadmin,sortadmin,groupadmin,webadmin')
                    ->where(array("id" => $user["gid"]))
                    ->find();

            $guser = array_merge($user, $group); //合并用户和组
            if ($guser["adminadmin"] || $guser["webadmin"] || $guser["articleadmin"]) {
                $_SESSION = $guser;
                $_SESSION["isLogin"] = 1;
                $_SESSION["login"] = 1;

                //更新IP和时间
                $data = array(
                    'id' => $user['id'],
                    'login_time' => time(),
                    'login_ip' => get_client_ip()
                        );
                $db->update($data);

                $this->redirect("index/index");
            } else {
                $this->error("不能登录后台，权限不足！", 3, "index");
            }
        } else {
            $this->error("用户登录失败,请重新登录！", 3, "index");
        }
    }

    //注销
    public function logout() {

        $_SESSION = array(); //session置空

        if (isset($_COOKIE[session_name()])) { //是否使用到cookies
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy(); //销毁session

        $this->success('注销成功!!!', 3, 'login/index');
    }

    //验证码
    public function vcode() {
        echo new Vcode(60, 25, 4);
    }

    //验证
    private function validate() {
        $stats = false;
        $errormess = "登录失败：<br>";
        if (!preg_match('/^\S+$/i', $_POST["username"])) {
            $errormess.="用户名不能为空!<br>";
            $stats = true;
        }
        if (!preg_match('/^\S+$/i', $_POST["password"])) {
            $errormess.="用户密码不能为空!<br>";
            $stats = true;
        }
        if (strtoupper($_POST["code"]) != $_SESSION["code"]) {
            $errormess.="验证码输出错误!<br>";
            $stats = true;
        }
        if ($stats) {
            $this->error($errormess, 3, "index");
        }
    }

}

?>