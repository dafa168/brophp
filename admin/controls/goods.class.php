<?php

Class goods extends common {

    public function index() {

        $model = D('goods');

        if (!empty($_GET['sid'])) { //存在CID
            $sid = intval($_GET['sid']);

            $sname = array();
            $sname = D('sort')->field('id, sname')->where(array('id' => $sid))->find();

            //分页开始
            $count = $model->total(array('sid' => $sid));
            /*
              参数一：  传递总数
              参数二：  每页显示条数
              参数三：  附加参数
             */
            $page = new Page($count, 10, 'sid/' . $sid);

            $data = $model->where(array('sid' => $sid))->order('id desc')->limit($page->limit)->select();

            foreach ($data as $k => $v) {
                $data[$k]['sname'] = $sname['sname'];
            }

            $this->assign('sname', $sname['sname']);
        } else { //不存在CID
            //分页开始
            $count = $model->total();
            /*
              参数一：  传递总数
              参数二：  每页显示条数
              参数三：  附加参数
             */
            $page = new Page($count, 10);

            $data = $model->order('id desc')->limit($page->limit)->select();
            $sname = array();
            foreach ($data as $k => $v) {
                $sname = D('sort')->field('id, sname')->where(array('id' => $v['sid']))->find();
                $data[$k]['sname'] = $sname['sname'];
            }

            $this->assign('sname', '');
        }

        // p($data); 

        $this->assign('fpage', $page->fpage());
        $this->assign('data', $data);
        $this->display();
    }

    public function add() {
        if ($_POST) {

            $model = D('goods');

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

            // p($_POST) ; die;
            //添加文章
            if ($model->insert($_POST)) {
                $this->success('添加成功', 2, 'goods/index/cid/' . $_POST['cid']);
            } else {

                if (file_exists($pic)) { //如果提交失败 则删除文件
                    $path = PROJECT_PATH . 'public/uploads/';
                    unlink($path . $pic);
                }

                $this->error($model->getMsg(), 2, 'goods/add');
            }
        }

        $this->assign('selectForm', D('sort')->selectForm('sid'));
        $this->assign("ck", Form::editor("description", "full", 300, "#FAFAFA"));
        $this->display();
    }

    public function edit() {

        $model = D('goods');

        if ($_POST) {

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

                $this->success('修改成功', 2, 'goods/index');
            } else {

                if (file_exists($pic)) { //如果提交失败 则删除文件
                    $path = PROJECT_PATH . 'public/uploads/';
                    unlink($path . $pic);
                }

                $this->error($model->getMsg(), 2, 'goods/edit/id' . $_POST['id']);
            }
        }

        $id = !empty($_GET['id']) ? intval($_GET['id']) : '';

        $sid = !empty($_GET['sid']) ? intval($_GET['sid']) : '';

        $this->assign('selectForm', D('sort')->selectForm('sid', $sid));
        $this->assign('goods', $model->find($id));
        $this->assign("ck", Form::editor("description", "full", 300, "#FAFAFA"));

        $this->display();
    }

    public function del() {


        if ($_POST) {
            $ids = $_POST['id'];
        } else {
            $ids = !empty($_GET['id']) ? intval($_GET['id']) : '';
        }

        $comment = D('comment');
        $goods = D('goods');

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

        if ($goods->delete($ids)) { //删除文章
            $this->success('删除成功', 2, 'goods/index');
        } else {
            $this->error('删除失败!', 2, 'goods/index');
        }
    }

}

?>