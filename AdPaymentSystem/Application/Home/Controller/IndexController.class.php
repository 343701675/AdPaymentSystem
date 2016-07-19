<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\import;

class IndexController extends BaseController {
    public function index(){
        $this->display();
    }
    
    /**
     * Summary of defaultmoney 期初金额页面
     */
    public function defaultmoney(){
        if(!empty(I('post.import'))){
            $this->defaultmoney_import();
        }
        $this->display();
    }
    
    /**
     * Summary of defaultmoney_import 期初金额导入
     */
    public function defaultmoney_import(){
        //文件是否存在，即是否有文件
        if(empty($_FILES))
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件未上传'),U('Index/defaultmoney'),U('Index/defaultmoney')),"utf-8","text/html");
            return;
        }
        $config = array(
        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
        'exts'          =>  array('xlsx','xls'), //允许上传的文件后缀
        'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath'      =>  './Public/Upload/', //保存根路径
        );
        //检测上传目录是否存在，不存在则创建目录
        if(!file_exists($config['rootPath']))
        {
            mkdir($config['rootPath']);
        }
        $upload=new \Think\Upload($config);
        $info=$upload->uploadOne($_FILES['excel']);  //上传返回的基本信息，二维数组
        if(!$info)
        {
            $this->show(IsMsg(array(State=>0,Msg=>$upload->getError()),U('Index/defaultmoney'),U('Index/defaultmoney')),"utf-8","text/html");
            
        }
        $filename=$config['rootPath'].$info['savepath'].$info['savename'];
        $exts=$info['ext'];
        $this->exceltodb($filename,$exts);
    }
    
    /**
     * Summary of exceltodb 导入期初数据
     * @param mixed $filename 
     * @param mixed $exts 
     */
    public function exceltodb($filename,$exts='xls')
    {
        //导入PHPExcel类库，因为没有命名空间，只能用import导入
        import('Org.Util.PHPExcel');
        //创建PHPExcel对象，需加上\
        $PHPExcel=new \PHPExcel();
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }
        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取Excel文件数据
        $import=new import();
        $xlsData=$import->GetExcelDataBySheet($PHPExcel,0);
        if(count($xlsData)==0)
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件无数据'),U('Index/defaultmoney'),U('Index/defaultmoney')),"utf-8","text/html");
            return;
        }
        
        //修改数据
        $editxlsData=$this->editdata($xlsData,'D',0);
        
        //重组数据
        foreach ($editxlsData as $k=>$v){
            //基础数据
            //$v['birthday']=is_numeric($v['birthday'])?date('Y-m-d',strtotime('1900-01-01'. '+'.($v['birthday']-2).' day')):$v['birthday'];
            //$Personnel[$k]['birthday']=$v['birthday'];
            $defaultmoney[$k]['yearmonth']=$v['yearmonth'];
            $defaultmoney[$k]['customname']=rtrim($v['customname']);
            $defaultmoney[$k]['defaultmoney']=$v['defaultmoney'];
        }
        //var_dump($defaultmoney);
        //exit;
        //查询是否有相同的客户名称
        $editxlsDataErr=array();
        $i=0;
        $defaultmoney_model=M('defaultmoney');
        foreach ($defaultmoney as $k=>$v){
            $result=$defaultmoney_model->where("customname='%s'",$v['customname'])->select();
            if($result!=null)
            {
                $editxlsDataErr[$i]=array('data'=>$this->reorganizederror($v,$v['customname']),'msg'=>'客户名称重复');$i++;
                continue;
            }
        }
        //若有错误数据，则需要返回前台页面提示错误信息
        if(count($editxlsDataErr)>0)
        {
            $this->showdisplay(array(State=>0,Msg=>'文件数据有误'),$editxlsDataErr);
            return;
        }
        //开始插入数据
        foreach ($defaultmoney as $k=>$v){ 
            $defaultmoney_model->add($v);
        }
        
        $this->showdisplay(array(State=>1,Msg=>"导入成功"),null,'导入成功');
       
    }
    
    /**
     * Summary of customdebit 借方表页面
     */
    public function customdebit(){
        if(!empty(I('post.import'))){
            $this->customdebit_import();
        }
        $this->display();
    }
    
    /**
     * Summary of customdebit_import 借方表导入
     */
    public function customdebit_import(){
        //文件是否存在，即是否有文件
        if(empty($_FILES))
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件未上传'),U('Index/customdebit'),U('Index/customdebit')),"utf-8","text/html");
            return;
        }
        $config = array(
        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
        'exts'          =>  array('xlsx','xls'), //允许上传的文件后缀
        'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath'      =>  './Public/Upload/', //保存根路径
        );
        //检测上传目录是否存在，不存在则创建目录
        if(!file_exists($config['rootPath']))
        {
            mkdir($config['rootPath']);
        }
        $upload=new \Think\Upload($config);
        $info=$upload->uploadOne($_FILES['excel']);  //上传返回的基本信息，二维数组
        if(!$info)
        {
            $this->show(IsMsg(array(State=>0,Msg=>$upload->getError()),U('Index/customdebit'),U('Index/customdebit')),"utf-8","text/html");
            
        }
        $filename=$config['rootPath'].$info['savepath'].$info['savename'];
        $exts=$info['ext'];
        $this->exceltodb1($filename,$exts);
    }
    
    /**
     * Summary of exceltodb 导入借方表数据
     * @param mixed $filename 
     * @param mixed $exts 
     */
    public function exceltodb1($filename,$exts='xls')
    {
        //导入PHPExcel类库，因为没有命名空间，只能用import导入
        import('Org.Util.PHPExcel');
        //创建PHPExcel对象，需加上\
        $PHPExcel=new \PHPExcel();
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }
        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取Excel文件数据
        $import=new import();
        $xlsData=$import->GetExcelDataBySheet($PHPExcel,0);
        if(count($xlsData)==0)
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件无数据'),U('Index/customdebit'),U('Index/customdebit')),"utf-8","text/html");
            return;
        }
        
        //修改数据
        $editxlsData=$this->editdata($xlsData,'E',1);
        
        //重组数据
        $m=0;
        $customdebit=array();  //借方
        $n=0;
        $customcredit=array(); //贷方
        foreach ($editxlsData as $k=>$v){
            //基础数据
            //$v['birthday']=is_numeric($v['birthday'])?date('Y-m-d',strtotime('1900-01-01'. '+'.($v['birthday']-2).' day')):$v['birthday'];
            //$Personnel[$k]['birthday']=$v['birthday'];
            if($v['debitmoney']>0){
                $customdebit[$m]['yearmonth']=$v['yearmonth'];
                $customdebit[$m]['customname']=rtrim($v['customname'])==''?'其他':rtrim($v['customname']);
                $customdebit[$m]['debitmoney']=$v['debitmoney'];
                $m++;
            }
            
            else if($v['creditmoney']>0){
                $customcredit[$n]['yearmonth']=$v['yearmonth'];
                $customcredit[$n]['customname']=rtrim($v['customname'])==''?'其他':rtrim($v['customname']);
                $customcredit[$n]['creditmoney']=$v['creditmoney'];
                $n++;
            }
            else{
                //跳过
            }
        }
        
        //var_dump($customdebit);
        //exit;
        $customdebit_model=M('customdebit');
        //开始插入数据
        foreach ($customdebit as $k=>$v){ 
            $customdebit_model->add($v);
        }
        
        $customcredit_model=M('customcredit');
        //开始插入数据
        foreach ($customcredit as $k=>$v){ 
            $customcredit_model->add($v);
        }
        
        $this->showdisplay(array(State=>1,Msg=>"导入成功"),null,'导入成功');
        
    }
    
    /**
     * Summary of customdebit 贷方表页面
     */
    public function customcredit(){
        if(!empty(I('post.import'))){
            $this->customcredit_import();
        }
        $this->display();
    }
    
    /**
     * Summary of customdebit_import 贷方表导入
     */
    public function customcredit_import(){
        //文件是否存在，即是否有文件
        if(empty($_FILES))
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件未上传'),U('Index/customcredit'),U('Index/customcredit')),"utf-8","text/html");
            return;
        }
        $config = array(
        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
        'exts'          =>  array('xlsx','xls'), //允许上传的文件后缀
        'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath'      =>  './Public/Upload/', //保存根路径
        );
        //检测上传目录是否存在，不存在则创建目录
        if(!file_exists($config['rootPath']))
        {
            mkdir($config['rootPath']);
        }
        $upload=new \Think\Upload($config);
        $info=$upload->uploadOne($_FILES['excel']);  //上传返回的基本信息，二维数组
        if(!$info)
        {
            $this->show(IsMsg(array(State=>0,Msg=>$upload->getError()),U('Index/customcredit'),U('Index/customcredit')),"utf-8","text/html");
            
        }
        $filename=$config['rootPath'].$info['savepath'].$info['savename'];
        $exts=$info['ext'];
        $this->exceltodb2($filename,$exts);
    }
    
    /**
     * Summary of exceltodb 导入贷方表数据
     * @param mixed $filename 
     * @param mixed $exts 
     */
    public function exceltodb2($filename,$exts='xls')
    {
        //导入PHPExcel类库，因为没有命名空间，只能用import导入
        import('Org.Util.PHPExcel');
        //创建PHPExcel对象，需加上\
        $PHPExcel=new \PHPExcel();
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }
        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取Excel文件数据
        $import=new import();
        $xlsData=$import->GetExcelDataBySheet($PHPExcel,0);
        if(count($xlsData)==0)
        {
            $this->show(IsMsg(array(State=>0,Msg=>'文件无数据'),U('Index/customcredit'),U('Index/customcredit')),"utf-8","text/html");
            return;
        }
        
        //修改数据
        $editxlsData=$this->editdata($xlsData,'D',2);
        
        //重组数据
        foreach ($editxlsData as $k=>$v){
            //基础数据
            //$v['birthday']=is_numeric($v['birthday'])?date('Y-m-d',strtotime('1900-01-01'. '+'.($v['birthday']-2).' day')):$v['birthday'];
            //$Personnel[$k]['birthday']=$v['birthday'];
            $customcredit[$k]['yearmonth']=$v['yearmonth'];
            $customcredit[$k]['customname']=rtrim($v['customname']);
            $customcredit[$k]['creditmoney']=$v['creditmoney'];
        }
        //var_dump($customcredit);
        //exit;
        $customcredit_model=M('customcredit');
        //开始插入数据
        foreach ($customcredit as $k=>$v){ 
            $customcredit_model->add($v);
        }
        
        $this->showdisplay(array(State=>1,Msg=>"导入成功"),null,'导入成功');
        
    }
    
    /**
     * Summary of editdata 修改数据
     * @param mixed $exceldata 
     * @param mixed $allColumn 
     * @param mixed $sheet 
     * @return mixed
     */
    public function editdata($exceldata,$allColumn,$sheet)
    {
        foreach ($exceldata as $k=>$v){
            for ($currentColumn='A'; $allColumn!=$currentColumn;$currentColumn++)
            {
        	    $returndata[$k][$this->headerarr($exceldata[1][$currentColumn],$sheet)] = trim($v[$currentColumn]);
            }
        }
        //去掉首行
        array_shift($returndata);
        return $returndata;
    }
    
    /**
     * Summary of headerarr 头数组
     * @param mixed $str 传入的字符串
     * @param mixed $sheet 第几个表
     */
    public function headerarr($str,$sheet)
    {
        if($sheet==0)
        {
            switch($str)
            {
                case "年月":
                    $re="yearmonth";
                    break;
                case "客户名称":
                    $re="customname";
                    break;
                case "期初金额":
                    $re="defaultmoney";
                    break;
            }
        }
        if($sheet==1)
        {
            switch($str)
            {
                case "年月":
                    $re="yearmonth";
                    break;
                case "客户名称":
                    $re="customname";
                    break;
                case "本期借方":
                    $re="debitmoney";
                    break;
                case "本期贷方":
                    $re="creditmoney";
                    break;
            }
        }
        return $re;  
    }
    
    /**
     * Summary of reorganizederror 因为前台没有必要显示所有信息，所以就只显示基本信息和错误字段数据，此方法就是这个目的
     * @param mixed $v 
     * @param mixed $errorv 
     * @return mixed
     */
    public function reorganizederror($v,$errorv)
    {
        $reorganizederror=array();
        $reorganizederror['customname']=$v['customname'];
        $reorganizederror['error']=$errorv;
        return $reorganizederror;
    }
    
    
}