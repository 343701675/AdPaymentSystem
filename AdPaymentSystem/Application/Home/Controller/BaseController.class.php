<?php
namespace Home\Controller;
use Think\Controller;
use Home\Common\IDuty;

class BaseController  extends Controller {
    function _initialize(){
        //自动加载某些
    }
    
    /**
     * Summary of ajaxReturnData
     * @param mixed $data 
     */
    public function ajaxReturnData($data)
    {
        //if($data['state']==1)
        //{
        //    $this->ajaxReturn($data['data'],'JSON');
        //}
        $this->ajaxReturn($data,'JSON');
    }
    
    /**
     * Summary of showdisplay 此方法用于提示信息后传递参数给模板页
     * @param mixed $msg 状态及提示
     * @param mixed $error 错误数据
     */
    public function showdisplay($msg,$error,$msg1=''){
        $Msg=$msg["Msg"];
        if($msg["State"]==1){
            if($msg1==='')
            {
                $this->display(); 
            }
            else
            {
                $this->show("<script>alert('$msg1');</script>");    
            }
        }else{
            $this->show("<script>alert('$Msg');</script>");
            if($error==null)
                $error=[];
            $this->assign("error",JsonEncode($error));
        }
    }
    
}