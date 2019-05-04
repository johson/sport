<?php
namespace app\admin\controller;


use think\Db;
use think\Request;

use app\admin\model\Judgment as JudgmentModel;




class Judgment extends Base
{
    /**
     * 初始化 处理 (构造函数)
     */

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    //渲染裁判员列表界面
    public function index()
    {

        $this->view->assign('title', '裁判员');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        $this->view->count = JudgmentModel::count();//查询数据数量

        $list =JudgmentModel::paginate(8); //每页显示6条

        $this -> view -> assign('list', $list);
        //渲染管理员列表模板
        return $this->view->fetch('admin_list');
    }


    //渲染裁判员编辑界面
    public function adminEdit(Request $request)
    {
        $user_id = $request -> param('id');
        $result =JudgmentModel::get($user_id);
        $this->view->assign('title','裁判员列表');
        $this->view->assign('keywords','裁判员列表');
        $this->view->assign('desc','裁判员列表');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('admin_edit');
    }

    //更新裁判员信息操作
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
        $result = JudgmentModel::update($data, $condition);



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
        JudgmentModel::update(['is_delete' => 1], ['id' => $user_id]);
        JudgmentModel::destroy($user_id);

    }

    //恢复删除操作
    public function unDelete()
    {
        JudgmentModel::update(['delete_time' => NULL], ['is_delete' => 1]);
    }

    //渲染裁判员添加界面
    public function  adminAdd()
    {
        $this->view->assign('title','添加裁判员');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        return $this->view->fetch('admin_add');
    }



    //裁判员添加操作
    public function save(Request $request)
    {
//
        $data=input('post.');
//        dump($data);
        $code=Db::execute("insert into judgment value(null,3,:name,:password,:realname,:stu_num,:tel,:grade,:spe,:class,:art,null,null,null)",$data);

        if($code){
            //跳转
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }

    }

}
