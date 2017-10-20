<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/16
 * Time: 21:10
 */

namespace app\admin\controller;
use app\admin\common\Base;
use think\File;
use think\Db;
use think\Request;

class Info extends Base
{
    protected $table = 'carousel';
    /**
     * 问题列表
     * @return view
     */
    public function questionList()
    {
        return $this->fetch('question-list');
    }

    /**
     * 删除问题
     * @return view
     */
    public function questionDel()
    {
        return $this->fetch('question-del');
    }

    /**
     * 轮播列表
     * @return View
     */
    public function bannerList()
    {
        $row = 3;
        $this->islogin();           //检查是否登录
        $data = $this->pageSelectList('carousel',$row);
        if(isset($data['page'])){
            $list = $data['list'];
            $page = $data['page'];
            $this->assign('page',$page);
        }
        $num = count($list);
        $this->assign(['num'=>$num,'list'=>$list]);
        //dump($list);
        return $this->fetch('banner-list');
    }

    /**
     * 添加轮播图模板
     * @return mixed
     */
    public function bannerAdd()
    {
        return $this->fetch('banner-add');
    }

    /**
     * 新增轮播图片
     * @return \think\response\Json
     */
    public function addImage()
    {
        //获取上传的图片
        $file = request()->file('image');
        $desc = request()->param('desc');
        $url = request()->param('url');
        //移动到/public/uplaods/images/banner
        $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
        if($info){
            $status = 1;
            $msg = "新增成功！";
            //存入数据库
           $path = "__UPLOAD__/";
           $name = $info->getSaveName();
           $src = $path.$name;
           $data = ['desc'=>$desc,'src'=>$src,'url'=>$url];
           Db::table('carousel')->insert($data);
        }else{
            $status=0;
            $msg = $info->getError();
        }
        if($status==0){
            $this->error($msg);
        }else{
            $this->success($msg);
        }
    }

    /**
     * 是否显示轮播图
     * @param Request $request
     */
    public function changeStatus(Request $request)
    {
        $table = $this->table;
        $this->setStatus($request,$table);
    }

    /**
     * 渲染修改页面
     * @param Request $request
     * @return mixed
     */
    public function bannerEdit(Request $request)
    {
        $id = $request->param('id');
        $list = Db::table('carousel')->where(['id'=>$id])->find();
        $this->assign('list',$list);
        return $this->fetch('banner-edit');
    }
    public function editImage(Request $request)
    {
        $id = $request->param('id');
        $image = $request->file('image');
        $desc = $request->param('desc');
        $url = $request->param('url');
        $data = ['desc'=>$desc,'url'=>$url];
        $result = Db::table('carousel')->where(['id'=>$id])->update($data);
        if ($result){
            $this->success('成功！');
        }
    }
}