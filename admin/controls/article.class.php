<?php

Class article extends common {

    public function index() {

        $model = D('article');


        if (!empty($_GET["cid"])) {

            $where = $cid = $pget = '';

            $where["cid"] = $_GET["cid"];
            $pget.="/cid/{$_GET["cid"]}";
            $cid = $_GET['cid'];
        } else {
            $cid = 0;
        }

        if (!empty($_GET["search"])) {
            $where["title"] = "%{$_GET["search"]}%";
            $pget.="/search/" . $_GET["search"];
            $this->assign("search", $_GET["search"]);
        }

        $cate = D('cate');
        $this->assign("select", $cate->selectForm("cid", $cid));

        $page = new Page($model->total($where), 15, $pget);
        $arts = $model->field()->where($where)->order('id desc')->limit($page->limit)->select();

        $cname = array();
        foreach ($arts as $k => $v) {
            $cname = $cate->field('id, cname')->where(array('id' => $v['cid']))->find();
            $arts[$k]['cname'] = $cname['cname'];
        }
        unset($cname);

        $this->mess("最新文章列表");
        $this->assign("data", $arts);
        $this->assign("fpage", $page->fpage());
        $this->assign("page", $page->page);

        $this->display();
    }

    public function add() {

        $this->mess('提示: 带<span style="color:red;">*</span>的项目为必填信息.');
        $this->assign("ck", Form::editor("body", "full", 300, "#FAFAFA"));
        $this->assign('select', D('cate')->selectForm());
        $this->display();
    }

    public function insert() {
        if ($_POST) {

            $model = D('article');

            if ($_FILES['pic']['error'] == 0) { //如果这个错误不存在 才执行上传
                //文件上传
                $pic = $model->upload();

                if (!$pic) {
                    $this->error($model->getMsg());
                } else {
                    $_POST['pic'] = $pic;
                }
            }

            $_POST['addtime'] = time();

            //添加文章
            if ($model->insert($_POST)) {
                $this->success('添加成功', 2, 'article/index/cid/' . $_POST['cid']);
            } else {

                if (file_exists($pic)) { //如果提交失败 则删除文件
                    $path = PROJECT_PATH . 'public/uploads/';
                    unlink($path . $pic);
                }

                $this->error($model->getMsg(), 2, 'article/add');
            }
        }
    }

    public function mod() {
        $this->assign('select', D('cate')->selectForm('cid', intval($_GET['cid'])));
        $this->assign('article', D('article')->where(array('id' => $id))->find(intval($_GET['id'])));
        $this->mess('提示: 带<span style="color:red">*</span>的项目为必填信息.');
        $this->assign("ck", Form::editor("body", "full", 300, "#FAFAFA"));
        $this->display();
    }

    public function update() {
        if ($_POST) {
            $model = D('article');
            if ($_FILES['pic']['error'] == 0) { //如果这个错误不存在 才执行上传
                //文件上传
                $pic = $model->upload();
                if (!$pic) {
                    $this->error($model->getMsg());
                } else {
                    $_POST['pic'] = $pic;
                }
                $name = PROJECT_PATH . '/public/uploads/' . $_POST['oldPic'];
                if (file_exists($name))
                    unlink($name);  //如果原图存在则删除
            }
            if ($model->update($_POST)) {
                $this->success('修改成功', 2, 'index');
            } else {
                $this->error($model->getMsg(), 2, 'article/mod/id' . $_POST['id']);
            }
        }
    }

    public function del() {

        if ($_POST) {
            $ids = $_POST['id'];
        } else {
            $ids = !empty($_GET['id']) ? intval($_GET['id']) : '';
        }

        $comment = D('comment');
        $article = D('article');

        $cids = array();
        foreach ($ids as $v) { //遍历取得评论ID
            $cids[] = $comment->field('id')->where(array('aid' => $v['id']))->select();
        }

        if ($cids) { //如果存在则删除
            $comment_ids = array();
            foreach ($cids as $v) {
                foreach ($v as $x) {
                    $comment_ids[] = implode(',', $x);
                }
            }
            $comment->delete($comment_ids); //删除评论
            unset($comment_ids);
        }
        unset($cids);

        if ($article->delete($ids)) { //删除文章
            $this->success('删除成功', 2, 'index');
        } else {
            $this->error('删除失败!', 2, 'index');
        }
    }

}

?>