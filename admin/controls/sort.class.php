<?php

Class sort extends common {

    public function index() {
        $data = D('sort')->field('id, sname,keywords,description,path, concat(path, "-", id) as abspath')->order('abspath, id')->r_select(array('goods', 'id', 'sid', array('goods')));
        foreach ($data as $k => $v) { //遍历取得商品数量
            $data[$k]['number'] = count($v['goods']);
            unset($data[$k]['goods']);
        }
        $this->assign('data', $data);
        $this->display();
    }

    public function add() {
        if ($_POST) {
            $model = D('sort');
            //组合path
            if ($_POST['pid'] == 0) {
                $_POST['path'] = 0;
            } else {
                $sort = $model->field('id,sname,pid,path')->find($_POST['pid']);
                $_POST['path'] = $sort['path'] . '-' . $_POST['pid'];
            }

            //添加
            if ($model->insert($_POST)) {
                $this->success('添加成功', 2, 'sort/index');
            } else {
                $this->error($model->getMsg(), 2, 'sort/add');
            }
        }

        $this->assign('selectForm', D('sort')->selectForm('pid'));
        $this->display();
    }

    public function edit() {
        $model = D('sort');
        if ($_POST) {
            /////////////////////这里判断PATH/////////////////////////////////////////////////////////////
            //取出两分类path (一个新选择的path)
            $data1 = $model->field('path')->find($_POST['pid']);
            $ppath = $data1['path']; //新选择的path

            $data2 = $model->field('path')->find($_POST['id']);
            $xpath = $data2['path']; //当前操作节点的path 
            //新插入的path
            if ($_POST['pid'] == 0) {
                $_POST['path'] = 0;
            } else {
                $_POST['path'] = $ppath . '-' . $_POST['pid'];
            }

            //不能将自己移动到自己的子类别中
            if (in_array($_POST['id'], explode('-', $_POST['path']))) {
                $this->error('不能将 [' . $_POST['sname'] . '] 移动到自己的子类别中');
            }

            //移动分类时 将子分类一起移动过去
            $srcpath = $xpath . '-' . $_POST['id'];
            $cpath = $_POST['path'] . '-' . $_POST['id']; //现在有的操作的分类ID相连 
            //所有子分类一起更新
            $model->where("path like '{$srcpath}%'")->update("path=replace(path, '{$srcpath}', '{$cpath}')");
            //////////////////////////////////////////////////////////////////////////////////////////////////
            //更新操作
            if ($model->update($_POST)) {
                $this->success('修改成功', 2, 'sort/index');
            } else {
                $this->error($model->getMsg(), 2, 'sort/edit/id/' . $_POST['id']);
            }
        }

        $id = !empty($_GET['id']) ? intval($_GET['id']) : '';
        $this->assign('selectForm', $model->selectForm('pid', $id));
        $this->assign('sort', $model->find($id));
        $this->display();
    }

    //删除
    public function del() {
        $id = !empty($_GET['id']) ? intval($_GET['id']) : '';
        $model = D('sort');
        if ($model->total(array('pid' => $id) > 0)) { //存在子分类不删
            $this->error('存在子分类', 2, 'index');
        }

        if (D('goods')->total(array('sid' => $id))) { //存在商品不删
            $this->error('分类下存在商品', 2, 'index');
        }

        if ($model->delete($id)) {
            $this->success('删除成功', 2, 'index');
        } else {
            $this->error('删除失败', 2, 'index');
        }
    }

}

?>