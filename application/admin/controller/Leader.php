<?php
namespace app\admin\controller;

use think\Db;
use think\Request;

use app\admin\model\Leader as LeaderModel;




class Leader extends Base
{
    /**
     * 初始化 处理 (构造函数)
     */

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

//渲染领队列表界面
    public function index()
    {

        $this->view->assign('title', '领队列表');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        $this->view->count = LeaderModel::count();//查询数据数量

        $list =LeaderModel::paginate(8); //每页显示8条

        $this -> view -> assign('list', $list);
        //渲染管理员列表模板
        return $this->view->fetch('admin_list');
    }
    //渲染领队编辑界面
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
    //更新领队操作
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
            return ['status' => 1, 'message' => '更新成功'];
        } else {
            return ['status' => 0, 'message' => '更新失败,请检查'];
        }
    }

    //删除操作
    public function deleteUser(Request $request)
    {
        $user_id = $request->param('id');
        LeaderModel::update(['is_delete' => 1], ['id' => $user_id]);
        LeaderModel::destroy($user_id);

    }

    //恢复删除操作
    public function unDelete()
    {
        LeaderModel::update(['delete_time' => NULL], ['is_delete' => 1]);
    }

    //添加领队操作界面
    public function  adminAdd()
    {
        $this->view->assign('title','添加领队');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        return $this->view->fetch('admin_add');
    }



    //添加操作
    public function save(Request $request)
    {
//
        $data=input('post.');
//        dump($data);
        $code=Db::execute("insert into leader value(null,2,:name,:password,:realname,:stu_num,:tel,:grade,:spe,:class,:team1,:stu_num1,:team2,:stu_num2,:team3,:stu_num3,:team4,:stu_num4,'未报名',0,'暂未设置','未报名',null,'暂未设置',null,null,null)",$data);

        if($code){
            //跳转
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }

    }
    //检测学号是否可用
    public function checkStuNum(Request $request)
    {
        $userNum = trim($request->param('stu_num'));
        $status = 1;
        $message = '学号可用';
        if (LeaderModel::get(['stu_num' => $userNum])) {
            //如果在表中查询到该学号
            $status = 0;
            $message = '学号重复,请重新输入~~';
        }
        return ['status' => $status, 'message' => $message];
    }





    /**
     * 渲染团体成绩列表
     */

    //4*100米（男）成绩列表界面
    public function ranking1()
    {
        $this->view->assign('title','4*100米（男）成绩列表');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art1','4*100米（男）')->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('ranking1');
    }

    //4*400米（男）成绩列表界面
    public function ranking2()
    {
        $this->view->assign('title','4*400米（男）成绩列表');
        $this->view->assign('keyword','');
        $this->view->assign('desc','');

        $list=Db::table('leader')->where('art2','4*400米（男）')->select();
        $this -> view -> assign('list', $list);

        return $this->view->fetch('ranking2');
    }




    /**
     * 渲染团体成绩更改界面
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
     * 更新团体项目成绩
     */

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
     * 渲染团体项目赛程表界面
     */
    //团体项目赛程表
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
     * 渲染团体项目赛程表修改界面
     */
    //4*100米比赛时间修改
    public function changeTime1(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','成绩更改界面');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('changeTime1');
    }



    //4*400米比赛时间修改界面
    public function changeTime2(Request $request)
    {
        $user_id = $request -> param('id');
        $result = LeaderModel::get($user_id);
        $this->view->assign('title','成绩更改界面');
        $this->view->assign('keywords','');
        $this->view->assign('desc','');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('changeTime2');
    }



    /**
     * 修改更新项目赛程操作
     */
    //更新4*100米比赛时间界面
    public function changeTime_edit1(Request $request)
    {
        //获取表单返回的数据
        $param = $request->param();
        //去掉表单中为空的数据,即没有修改的内容
        foreach ($param as $key => $value) {
            if (!empty($value)) {
                $data[$key] = $value;
            }
        }
        $result = LeaderModel::where('art1','=','4*100米（男）')->update([
            'time1'=>$data['time1']
        ]);
        if (true == $result) {
            return ['status' => 1, 'message' => '更新成功'];
        } else {
            return ['status' => 0, 'message' => '更新失败,请检查'];
        }
    }

    //更新4*400米比赛时间
    public function changeTime_edit2(Request $request)
    {
        //获取表单返回的数据
        $param = $request->param();
        //去掉表单中为空的数据,即没有修改的内容
        foreach ($param as $key => $value) {
            if (!empty($value)) {
                $data[$key] = $value;
            }
        }
        $result = LeaderModel::where('art2','=','4*400米（男）')->update([
            'time2'=>$data['time2']
        ]);
        if (true == $result) {
            return ['status' => 1, 'message' => '更新成功'];
        } else {
            return ['status' => 0, 'message' => '更新失败,请检查'];
        }
    }

    /**
     * 渲染团体项目报名情况界面
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

    /**
     * 渲染团体项目历史记录界面
     */
    public function history()
    {
        $this->view->assign('title', '团体项目历史记录');
        $this->view->assign('keywords', '');
        $this->view->assign('desc', '');

        //4*100米最好成绩
        $list1 = Db::table('leader')->where('score1 > 0')->order("score1 asc")->limit(1)->find();
        //插入数据库man_history中
        Db::table('leader_history')->insert($list1);
        $data1 = Db::table('leader_history')->where('score1 > 0')->order("score1 asc")->limit(1)->select();
        $this -> view -> assign('data1', $data1);

        //4*400米最好成绩
        $list2 = Db::table('leader')->where('score2 > 0')->order("score2 asc")->limit(1)->find();
        //插入数据库man_history中
        Db::table('leader_history')->insert($list2);
        $data2 = Db::table('leader_history')->where('score2 > 0')->order("score2 asc")->limit(1)->select();
        $this -> view -> assign('data2', $data2);



        return $this->fetch('leader_history');
    }
    
}

