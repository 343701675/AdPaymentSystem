<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\import;

class CustomController extends BaseController {
    public function detail(){
        $year=date('Y',time());
        $this->year=$year;
        $this->display();
    }
    
    public function detailajax($customname,$month,$year){
        if(empty($customname))
        {
            $this->ajaxReturnData(null);
        }
        //优先默认客户年详细情况
        if(!empty($year))
        {
            $startyear=$year.'-01';
            $endyear=$year.'-12';
            $para_array=array($startyear,$startyear,$customname,$customname,$startyear,$endyear,$customname,$startyear,$endyear,$startyear,$startyear,$startyear,$endyear,$startyear,
                $endyear,$customname);
            // 实例化一个model对象 没有对应任何数据表
            $Model = new \Think\Model() ;
            //获取此月的月汇总数据
            $sql="select '上期结转' as yearmonth, main.customname,'' as debitmoney, 
'' as creditmoney,main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

where main.customname='%s'

union all

(SELECT yearmonth,customname,debitmoney,'' as creditmoney,'' as finalmoney FROM adpayment.ad_customdebit where customname='%s' and yearmonth>='%s' and yearmonth<='%s')

union all

(SELECT yearmonth,customname,'' as debitmoney,creditmoney,'' as finalmoney FROM adpayment.ad_customcredit where customname='%s' and yearmonth>='%s' and yearmonth<='%s')

union all

select '本期合计'as yearmonth,'' as customname,ifnull(debit2.debitmoneysum2,0) as debitmoney,
ifnull(credit2.creditmoneysum2,0) as creditmoney,
main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0)-ifnull(debit2.debitmoneysum2,0)+ifnull(credit2.creditmoneysum2,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

left join  (SELECT customname,sum(debitmoney) as debitmoneysum2  FROM adpayment.ad_customdebit where yearmonth>='%s' and yearmonth<='%s' group by customname) debit2
on main.customname=debit2.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum2 FROM adpayment.ad_customcredit where yearmonth>='%s' and yearmonth<='%s' group by customname) credit2
on main.customname=credit2.customname

where main.customname='%s'";
            $data=$Model->query($sql,$para_array);
            $this->ajaxReturnData($data);
        }
        else if(!empty($month))
        {
            $para_array=array($month,$month,$customname,$month,$customname,$month,$customname,$month,$month,$month,$month,$month,$customname,$month);
            // 实例化一个model对象 没有对应任何数据表
            $Model = new \Think\Model() ;
            //获取此月的月汇总数据
            $sql="select '上期结转' as yearmonth, main.customname,'' as debitmoney, 
'' as creditmoney,main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

where main.customname='%s'  and main.yearmonth<'%s'

union all

(SELECT yearmonth,customname,debitmoney,'' as creditmoney,'' as finalmoney FROM adpayment.ad_customdebit where customname='%s' and yearmonth='%s')

union all

(SELECT yearmonth,customname,'' as debitmoney,creditmoney,'' as finalmoney FROM adpayment.ad_customcredit where customname='%s' and yearmonth='%s')

union all

select '本期合计'as yearmonth,'' as customname,ifnull(debit2.debitmoneysum2,0) as debitmoney,
ifnull(credit2.creditmoneysum2,0) as creditmoney,
main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0)-ifnull(debit2.debitmoneysum2,0)+ifnull(credit2.creditmoneysum2,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

left join  (SELECT customname,sum(debitmoney) as debitmoneysum2  FROM adpayment.ad_customdebit where yearmonth='%s' group by customname) debit2
on main.customname=debit2.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum2 FROM adpayment.ad_customcredit where yearmonth='%s' group by customname) credit2
on main.customname=credit2.customname

where main.customname='%s'  and main.yearmonth<'%s'";
            $data=$Model->query($sql,$para_array);
            $this->ajaxReturnData($data);
        }
        $this->ajaxReturnData(null);
    }
    
    public function month(){
        $month=date('Y-m',time());
        $this->month=$month;
        $this->display();
    }
    
    public function monthajax($customname,$month){
        $month=$month==''?date('Y-m',time()):$month;
        $where=" where main.yearmonth<'%s'";
        $para_array=array($month,$month,$month,$month,$month,$month);
        if(!empty($customname))
        {
            $where.=" and main.customname='%s'";
            array_push($para_array,$customname);
        }
        
        // 实例化一个model对象 没有对应任何数据表
        $Model = new \Think\Model() ;
        //获取此月的月汇总数据
        $sql="select '%s' as month,main.customname,main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0) as defaultmoney,ifnull(debit2.debitmoneysum2,0) as debitmoney,
ifnull(credit2.creditmoneysum2,0) as creditmoney,
main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0)-ifnull(debit2.debitmoneysum2,0)+ifnull(credit2.creditmoneysum2,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

left join  (SELECT customname,sum(debitmoney) as debitmoneysum2  FROM adpayment.ad_customdebit where yearmonth='%s' group by customname) debit2
on main.customname=debit2.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum2 FROM adpayment.ad_customcredit where yearmonth='%s' group by customname) credit2
on main.customname=credit2.customname".$where;
        $data=$Model->query($sql,$para_array);
        $this->ajaxReturnData($data);
    }
    
    public function year(){
        $year=date('Y',time());
        $this->year=$year;
        $this->display();
    }
    
    public function yearajax($customname,$year){
        $year=$year==''?date('Y',time()):$year;
        $startyear=$year.'-01';
        $endyear=$year.'-12';
        //本年度才有期初金额也算在内
        //$where=" where main.yearmonth<'%s'";
        $where=" where 1=1 and main.yearmonth<='%s'";
        $para_array=array($year,$startyear,$startyear,$startyear,$endyear,$startyear,$endyear,$endyear);
        if(!empty($customname))
        {
            $where.=" and main.customname='%s'";
            array_push($para_array,$customname);
        }
        // 实例化一个model对象 没有对应任何数据表
        $Model = new \Think\Model() ;
        //获取此月的月汇总数据
        $sql="select '%s'as year,main.customname,main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0) as defaultmoney,ifnull(debit2.debitmoneysum2,0) as debitmoney,
ifnull(credit2.creditmoneysum2,0) as creditmoney,
main.defaultmoney-ifnull(debit1.debitmoneysum1,0)+ifnull(credit1.creditmoneysum1,0)-ifnull(debit2.debitmoneysum2,0)+ifnull(credit2.creditmoneysum2,0) as finalmoney from adpayment.ad_defaultmoney main

left join  (SELECT customname,sum(debitmoney) as debitmoneysum1  FROM adpayment.ad_customdebit where yearmonth<'%s' group by customname) debit1
on main.customname=debit1.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum1 FROM adpayment.ad_customcredit where yearmonth<'%s' group by customname) credit1
on main.customname=credit1.customname

left join  (SELECT customname,sum(debitmoney) as debitmoneysum2  FROM adpayment.ad_customdebit where yearmonth>='%s' and yearmonth<='%s' group by customname) debit2
on main.customname=debit2.customname

left join  (SELECT customname,sum(creditmoney) as creditmoneysum2 FROM adpayment.ad_customcredit where yearmonth>='%s' and yearmonth<='%s' group by customname) credit2
on main.customname=credit2.customname".$where;
        $data=$Model->query($sql,$para_array);
        $this->ajaxReturnData($data);
    }
}