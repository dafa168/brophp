<?php

Class cate extends Common {

    //关联查询
    public function index() {

        $model = D('cate');

        $this->mess('提示：可以通过重新排序改变栏目的在首页中的显示顺序,数值小的排在前面，还可以关闭部分栏目的显示.<br>注意：只能删除空栏目，如果样目下有文章或子栏目，请先删除.');
        /*
          参数一：  传递总数
          参数二：  每页显示条数
          参数三：  附加参数 如某个分类ID
         */
        $page = new Page($model->total(), 15);
        $data = $model->field('id,cname,keywords,description')->order('id desc')->limit($page->limit)->r_select(array('article', 'id as aid', 'cid', array('art')));

        //遍历取得数量
        foreach ($data as $k => $v) {
            $data[$k]['num'] = count($v['art']);
            unset($data[$k]['art']);
        }

        $this->assign('page', $page->fpage());
        $this->assign('data', $data);
        $this->display();
    }

    public function add() {
        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息. ');
        $this->display();
    }

    //添加
    public function insert() {

        $model = D('cate');
        if ($model->insert($_POST, 1, 1)) {
            $this->mess("新分类 <b>{$_POST["cname"]}</b> 添加成功，可以继续添加！", true);
        } else {
            $this->assign($_POST);
            $this->mess($model->getMsg(), false);
        }
        $this->display("add");
    }

    public function mod() {
        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息。<br>注意：不能将类别移动到自己的子类中去. ');
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $model = D('cate');
        $cate = $model->where(array('id' => $id))->find();
        $this->assign('cate', $cate);
        $this->display();
    }

    //编辑
    public function update() {

        $model = D('cate');

        if ($model->update($_POST)) {
            $this->success('修改成功', 2, 'index');
        } else {
            $this->mess($model->getMsg(), false);
            $this->assign($_POST);
            $this->display("mod");
        }
    }

    //删除
    public function del() {
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $model = D('cate');

        if (D('article')->total(array('cid' => $id))) { //存在文章不删
            $this->error('分类下存在文章', 2, 'index');
        }

        if ($model->delete($id)) {
            $this->success('删除成功', 2, 'index');
        } else {
            $this->error('删除失败', 2, 'index');
        }
    }

}

?>