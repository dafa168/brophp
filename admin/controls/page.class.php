<?php

Class page extends common {

    public function index() {
        
        $where = array() ;
        $model = D('page');
        $count = $model->where($where)->total();
        /*
          参数一：  传递总数
          参数二：  每页显示条数
          参数三：  附加参数
         */
        $page = new Page($count, 10);
        $data = $model->where($where)->limit($page->limit)->select();

        $this->assign('page', $page->fpage());
        $this->assign('data', $data);
        $this->display();
    }

    public function insert() {
        if ($_POST) {
            $model = D('page');
            $_POST['addtime'] = time();
            if ($model->insert($_POST)) {
                $this->success('添加成功', 2, 'page/index');
            } else {
                $this->error($model->getMsg(), 2, 'page/add');
            }
        }
    }

    public function add() {
        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息.');
        $this->assign("ck", Form::editor("body", "full", 300, "#FAFAFA"));
        $this->display();
    }

    public function edit() {
        if ($_POST) {
            $model = D('page');
            if ($model->update($_POST)) {
                $this->success('修改成功', 2, 'page/index');
            } else {
                $this->error($model->getMsg(), 2, 'page/edit/id' . $_POST['id']);
            }
        }

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $model = D('page');
        $page = $model->where(array('id' => $id))->find();
        $this->assign('page', $page);
        $this->assign("ck", Form::editor("body", "full", 300, "#FAFAFA"));
        $this->display();
    }

    public function del() {
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $model = D('page');

        if ($model->where(array('id' => $id))->delete()) {
            $this->success('删除成功', 2, 'page/index');
        } else {
            $this->error('删除失败!', 2, 'page/index');
        }
    }

}

?>