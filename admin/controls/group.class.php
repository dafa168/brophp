<?php

Class group extends common {

    public function index() {

        $model = D('group');

        // $page = new Page( $model->total() , 15) ;
        // $data = $model->field('id, gname, description')->limit($page->limit)->select() ;
        $data = $model->field('id, gname, description')->select();
        $this->mess('管理员用户组不能删除，否则将不能登录系统. ');
        // $this->assign( 'fpage', $page->fpage() ) ;
        $this->assign("data", $data);
        $this->display();
    }

    //添加
    public function add() {
        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息. ');
        $this->display();
    }

    public function insert() {
        $group = D("group");

        if ($group->insert($_POST, 1, 1)) {
            $this->mess("用户组{$_POST["gname"]}添加成功！. ", true);
            $this->assign("data", D("group")->field('id, gname,description')->select());
            $this->display('index');
        } else {
            $this->mess($group->getMsg(), false);
            $this->assign($_POST);
            $this->display('add');
        }
    }

    //修改
    public function mod() {
        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息. ');
        $this->assign(D("group")->find(intval($_GET['id'])));
        $this->display();
    }

    public function update() {
        $group = D("group");

        $_POST["cateadmin"] = !empty($_POST["cateadmin"]) ? $_POST["cateadmin"] : 0;
        $_POST["articleadmin"] = !empty($_POST["articleadmin"]) ? $_POST["articleadmin"] : 0;
        $_POST["pageadmin"] = !empty($_POST["pageadmin"]) ? $_POST["pageadmin"] : 0;
        $_POST["commentadmin"] = !empty($_POST["commentadmin"]) ? $_POST["commentadmin"] : 0;
        $_POST["sortadmin"] = !empty($_POST["sortadmin"]) ? $_POST["sortadmin"] : 0;
        $_POST["goodsadmin"] = !empty($_POST["goodsadmin"]) ? $_POST["goodsadmin"] : 0;
        $_POST["groupadmin"] = !empty($_POST["groupadmin"]) ? $_POST["groupadmin"] : 0;
        $_POST["adminadmin"] = !empty($_POST["adminadmin"]) ? $_POST["adminadmin"] : 0;
        $_POST["webadmin"] = !empty($_POST["webadmin"]) ? $_POST["webadmin"] : 0;

        $affectedrow = $group->update($_POST, 1, 1);

        if ($affectedrow) {
            $this->mess("用户组{$_POST["groupname"]}修改成功！. ", true);
            $this->assign("data", D("group")->field('id, gname,description')->select());
            $this->display('index');
        } else {
            if ($affectedrow === 0)
                $mess = "数据没有改变";
            else
                $mess = $group->getMess();

            $this->mess($mess, false);
            $this->assign($_POST);
            $this->display('mod');
        }
    }

    //删除
    public function del() {
        $group = D("group");

        if (intval($_GET['id']) === 1)
            $this->error('系统禁止删除超级管理员组!');

        if (D("admin")->total(array('gid' => intval($_GET['id']))) > 0) {

            $this->mess('请将该用户组中所有成员移动到其他组中再删除!', false);
        } else {

            if ($group->delete($_GET['id'])) {
                $this->mess('成功删除用户组！', true);
            } else {
                $this->mess($group->getMsg(), false);
            }
        }
        $this->assign("data", D("group")->field('id, gname,description')->select());
        $this->display('index');
    }

}

?>