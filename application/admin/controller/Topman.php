<?php
namespace app\admin\controller;

use think\Session;
use think\Request;
use think\Response;
use think\captcha\Captcha;

class Topman extends Base
{
    /**
     * 初始化 处理 (构造函数)
     */

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 渲染登陆页面
     */
    public function login()
    {
        $this->alreadyLogin();
        if (Session::get('userId') > 0) {
            $this->error('请勿重复登陆!');
        }

        return $this->fetch();
    }

    /**
     * 登陆操作
     */
    public function checkLogin(Request $request)
    {
        $data = $request->param();//获取参数

        //判断是否为空
        if (empty($data['name'])) {
            $this->error('用户账号不能为空!');
        }
        if (empty($data['password'])) {
            $this->error('密码不能为空!');
        }


        //获取验证码
        $captcha = new Captcha();
        if (!$captcha->check($data['verify'])) {
            $this->error('验证码不正确!');
        }

        $model = new \app\admin\model\Topman();
//        $result = $model->where(['name' => $data['name'], 'password' => md5($data['password'])])->find();
        $result = $model->where(['name' => $data['name'], 'password' => $data['password'] ])->find();

        if (!$result) {
            $this->error('账号或密码错误，请重新输入!');
        }
        //删除密码
        unset($result['password']);

        //写入session
        Session::set('userId', $result['id']);
        Session::set('userName', $result['name']);
        Session::set('user_info', $model->getData());

        return Response::create(['code' => 1, 'msg' => '登录成功，点击【确定】进入~', 'data' => $result], 'JSON');




    }



   /**
     * 登出操作
     */
    public function logout()
    {
        Session::delete('userId');
        Session::delete('userName');
        Session::delete('user_info');
        $this ->success('注销登陆，正在返回','topman/login');
        return Response::create(['code' => 1, 'info' => '退出成功！'], 'json');
    }



    /**
     *实例化验证码
     */
    public function captcha_img()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }
}
