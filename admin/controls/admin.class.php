<?php

Class admin extends common {

    public function index() {

        $model = D('admin');

        $this->mess('管理员用户不能删除，否则将不能登录系统, 用户被删除时,他的文章及评论等所有信息也会一同删除. ');
        $arr = $_GET;
        $pget = $where = '';

        $select = !empty($arr['gid']) ? $arr['gid'] : 0;
        $search = !empty($arr["search"]) ? $arr['search'] : "";
        $this->assign('select', D('group')->groupSelect('gid', $select));

        if ($select != 0) {  //选择用户组
            $where["gid"] = $select;
            $pget.="/gid/{$select}";  //分页条件
            $this->assign("gid", $select);
        }
        if ($search != "") {    //搜索
            $where["username"] = "%{$arr["search"]}%";
            $pget.="/search/{$arr["search"]}";  //分页条件
        }


        $page = new Page($model->total($where), 15, $pget);
        $data = $model->field('id, username, login_time, login_ip, locked')->limit($page->limit)->where($where)->select();

        // p($data) ; 

        $page->set("head", "个用户");
        $this->assign("fpage", $page->fpage(0, 3, 2, 4, 5, 6));
        $this->assign("page", $page->page);
        $this->assign('data', $data);
        $this->assign("search", $search);
        $this->display();
    }

    public function add() {

        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息. ');
        $this->assign("select", D("group")->groupSelect("gid", 2));

        $this->display();
    }

    public function insert() {
        $model = D('admin');

        $_POST['password'] = md5(md5(substr(trim($_POST['password']), 5, 15)));

        if ($model->insert($_POST, 1, 1)) {
            $this->mess("添加用户 <b>{$_POST["username"]}</b> 成功,可以继续添加！. ", true);
            $this->assign("select", D("group")->groupSelect("gid", 2));
        } else {

            $this->mess($model->getMsg(), false);
            $this->assign("post", $_POST);
            $this->assign("select", D("group")->groupSelect("gid", $_POST['gid']));
        }

        $this->display("add");
    }

    public function mod() {


        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $admin = D("admin")->field("id,gid,username,locked")->find($id);

        $this->mess('提示: 带<span class="red_font">*</span>的项目为必填信息. ');

        p($admin);
        $this->assign("select", D("group")->groupSelect("gid", $admin['gid']));

        $this->assign("admin", $admin);
        $this->display();
    }

    public function update() {
        if ($_POST["password"] == "") {
            unset($_POST["password"]);
        } else {
            $_POST['password'] = md5(md5(substr(trim($_POST['password']), 5, 15)));
        }

        $model = D('admin');

        $affectedrow = $model->update($_POST, 1, 1);

        if ($affectedrow) {
            $this->redirect('index');
        } else {
            if ($affectedrow === 0) {
                $mess = "用户记录没有被改变！";
            } else {
                $mess = $model->getMsg();
            }

            $this->mess($mess, false);
            $this->assign("admin", $_POST);
            $this->assign("select", D("group")->groupSelect("gid", $_POST['gid']));
            $this->display("mod");
        }
    }

    public function del() {

        if (!empty($_POST)) {
            $id = intval($_POST["id"]);
        } else {
            $id = intval($_GET["id"]);
        }

        if ($id === 1)
            $this->error("管理员不可删除!", 2, 'index'); //管理员不让删除

        if (!empty($_GET["search"]))
            $pget.="/search/{$_GET["search"]}";

        if (!empty($_GET["gid"]))
            $pget.="/gid/{$_GET["gid"]}";

        if (D("admin")->where(array('id' => $id))->delete()) {
            $this->redirect("index", "page/{$_GET['page']}" . $pget);
        } else {
            $this->error("删除用户失败!", 3, "user/index/page/{$_GET['page']}" . $pget);
        }
    }

}

?>