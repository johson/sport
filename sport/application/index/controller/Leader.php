<?php
namespace app\index\controller;


use think\Db;
use think\Request;
use app\index\model\Leader as LeaderModel;




class Leader extends Base
{
    /**
     * 初始化 处理 (构造函数)
     */

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 渲染报名界面
     */
    public function index()
    {

        //通过session('userId')查询对应数据
        $id= Request::instance()->session('userId');
        $list=Db::table('leader')->where('id',$id)->select();
        $this -> view -> assign('list', $list);

        $this->view->assign('title', '');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        //报名界面
        return $this->view->fetch('admin_list');
    }


    /**
     * 渲染修改报名项目界面
     */

    public function adminEdit(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','领队列表');
        $this->view->assign('keywords','领队员列表');
        $this->view->assign('desc','领队列表');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('admin_edit');
    }


    /**
     * 更新数据操作（报名与修改个人信息公用）
     */
    //更新数据操作
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
        $result = LeaderModel::update($data, $condition);



        if (true == $result) {
            return ['status' => 1, 'message' => '成功'];
        } else {
            return ['status' => 0, 'message' => '失败,请检查'];
        }
    }


    /**
     * 渲染团体成绩查询界面
     */
    //团队成绩查询
    public function search(){
        $this->view->assign('title','查询结果');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');

        //通过session('userId')查询对应数据
        $id= Request::instance()->session('userId');
        $list=Db::table('leader')->where('id',$id)->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('search_list');
    }



    /**
     * 渲染团体信息界面
     */
    //团队信息
    public function message(){
        $this->view->assign('title','团队信息');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');

        //通过session('userId')查询对应数据
        $id= Request::instance()->session('userId');
        $list=Db::table('leader')->where('id',$id)->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('message_list');
    }




    /**
     * 渲染团队信息修改界面
     */
    public function messageEdit(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','团队信息修改');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('message_edit');
    }


    /**
     * 渲染团体项目赛程表界面
     */
    public function time()
    {
        $this->view->assign('title','团体项目赛程表');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list1=Db::table('leader')->where('art1','4*100米（男）')->limit(1)->select();
        $this -> view -> assign('list1', $list1);

        $list2=Db::table('leader')->where('art2','4*400米（男）')->limit(1)->select();
        $this -> view -> assign('list2', $list2);

        return $this->view->fetch('time_list');
    }



    /**
     * 渲染比赛项目规则界面
     */
    public function rule()
    {
        $this->view->assign('title','比赛项目规则说明');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        return $this->view->fetch('rule');
    }


    /**
     * 渲染团队参数信息界面
     */
    public function matchMessage()
    {
        $this->view->assign('title','团队参赛信息');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        //通过session('userId')查询对应数据
        $id= Request::instance()->session('userId');
        $list=Db::table('leader')->where('id',$id)->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('matchMessage');
    }



    /**
     * 渲染团体比赛成绩报名界面
     */

    //4*100米（男）成绩排名界面
    public function ranking1()
    {
        $this->view->assign('title','4*100米（男）成绩排名');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art1','4*100米（男）')->order('score1 asc')->limit(10)->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('ranking1');
    }

    //4*400米（男）成绩排名界面
    public function ranking2()
    {
        $this->view->assign('title','4*400米（男）成绩排名');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art2','4*100米（男）')->order('score2 asc')->limit(10)->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('ranking2');
    }



    /**
     * 渲染团体比赛所有成绩列表界面
     */

//4*100米（男）成绩列表界面
    public function score1()
    {
        $this->view->assign('title','4*100米（男）成绩列表');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art1','4*100米（男）')->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('score1');
    }

    //4*400米（男）成绩列表界面
    public function score2()
    {
        $this->view->assign('title','4*400米（男）成绩列表');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art2','4*400米（男）')->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('score2');
    }



    /**
     * 渲染团体比赛成绩更改界面
     */
    //4*100米（男）成绩更改界面
    public function changeScore1(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','成绩更改界面');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('changeScore1');
    }

    //4*400米（男）成绩更改界面
    public function changeScore2(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','成绩更改界面');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('changeScore2');
    }


    /**
     * 更新成绩操作
     */
//更新男运动员成绩
    public function changeScore_edit(Request $request)
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
        $result = LeaderModel::update($data, $condition);

        if (true == $result) {
            return ['status' => 1, 'message' => '更新成功'];
        } else {
            return ['status' => 0, 'message' => '更新失败,请检查'];
        }
    }

    /**
     * 渲染项目报名情况界面
     */
    public function situation1()
    {
        $this->view->assign('title', '4*100米（男）报名情况');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        $this->view->count = Db::table('leader')->where('art1','4*100米（男）')->count();//查询数据数量

        $list = Db::table('leader')->where('art1','4*100米（男）')->select();

        $this -> view -> assign('list', $list);

        return $this->view->fetch('situation1');
    }
    public function situation2()
    {
        $this->view->assign('title', '4*400米（男）报名情况');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        $this->view->count = Db::table('leader')->where('art2','4*400米（男）')->count();//查询数据数量

        $list = Db::table('leader')->where('art2','4*400米（男）')->select();

        $this -> view -> assign('list', $list);

        return $this->view->fetch('situation2');
    }
}
