<?php
namespace app\admin\controller;


use think\Db;
use think\Request;

use app\admin\model\Course as CourseModel;




class Course extends Base
{
    /**
     * 初始化 处理 (构造函数)
     */

    public function _initialize()
    {
        parent::_initialize(); // 父类初始化的时候有内容,子类是会继承的,但是子类如果也有初始化的时候,父类是会被覆盖掉的,为了保留父类的初始化内容就会使用parent::_initialize();
    }


    //渲染秩序表列表
    public function index()
    {
        $this->view->assign('title', '秩序表');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        $this->view->count = CourseModel::count();//查询数据数量

        $list =CourseModel::paginate(8);

        $this -> view -> assign('list', $list);
        //渲染秩序表列表模板
        return $this->view->fetch('course_list');
    }


    //渲染编辑秩序表弹出框界面
    public function adminEdit(Request $request)
    {
        $user_id = $request -> param('id');
        $result =CourseModel::get($user_id);

        $this->view->assign('title','秩序表编辑');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');

        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('course_edit');
    }
    //更新秩序表操作
    public function editUser(Request $request)
    {
        //获取表单返回的数据
//        $data = $request -> param();
        $param = $request->param();

        //去掉表单中为空的数据,即没有修改的内容
        foreach ($param as $key => $value) {
            if (!empty($value)) {
                $data[$key] = $value;
            }
        }

        $condition = ['id' => $data['id']];
        $result = CourseModel::update($data, $condition);


        if (true == $result) {
            return ['status' => 1, 'message' => '更新成功'];
        } else {
            return ['status' => 0, 'message' => '更新失败,请检查'];
        }
    }

    //删除操作
    public function deleteUser(Request $request)
    {
        $user_id = $request->param('id');
        CourseModel::update(['is_delete' => 1], ['id' => $user_id]);
        CourseModel::destroy($user_id);

    }

    //恢复删除操作
    public function unDelete()
    {
        CourseModel::update(['delete_time' => NULL], ['is_delete' => 1]);
    }

    //渲染秩序表添加界面
    public function  adminAdd()
    {
        $this->view->assign('title','添加秩序');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        return $this->view->fetch('course_add');
    }



    //添加操作
    public function save(Request $request)
    {
//
        $data=input('post.');
//        dump($data);
        $code=Db::execute("insert into course value(null,:item,:count,:rule,null,null,null)",$data);

        if($code){
            //跳转
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }

    }

}

