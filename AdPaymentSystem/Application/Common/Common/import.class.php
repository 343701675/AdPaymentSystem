<?php
namespace Common\Common;

/**
 * Summary of import 导入
 */
class import{
    
    /**
     * Summary of GetExcelDataBySheet 根据传入的$i获取Excel中Sheet数据
     * @param mixed $PHPExcel 载入的文件对象
     * @param mixed $i 默认为第一个sheet
     */
    public function GetExcelDataBySheet($PHPExcel,$i=0)
    {
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet($i);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //取有值的标题，以标题为准,获取总列数
        for ($currentColumn='A'; $allColumn!=$currentColumn+1;$currentColumn++)
        {
        	$cell =$currentSheet->getCell($currentColumn.'1')->getValue();
            if($cell==null)
                break;  
        }
        $allColumn=$currentColumn;
        
        $allRow=$currentSheet->getHighestRow();
        //获取总行数
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            $cell =$currentSheet->getCell('A'.$currentRow)->getValue();
            if($cell==null)
                break;
        }
        $allRow=$currentRow-1;
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn!=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $cell =$currentSheet->getCell($address)->getValue();
                //富文本转换字符串
                if($cell instanceof PHPExcel_RichText){
                    $cell  = $cell->__toString();
                }
                $data[$currentRow][$currentColumn]=$cell;
            }
        }
        return $data;
    }
}


