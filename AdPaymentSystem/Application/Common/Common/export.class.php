<?php
namespace Common\Common;

/**
 * Summary of export 导出
 */
class export{
   
    /**
     * Summary of exportExcel 导出Excel
     * @param mixed $fileName 导出Excel名
     * @param mixed $headArr Cell第一行数组
     * @param mixed $data 导出数据
     */
    public function exportExcel($fileName,$sheetArray){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        
        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        
        for ($indexSheet = 0; $indexSheet <count($sheetArray); $indexSheet++)
        {
            $objPHPExcel->createSheet($indexSheet);
            //获取每个工作表的数据
            $headArr=$sheetArray[$indexSheet]['headArr'];
            $data=$sheetArray[$indexSheet]['data'];
            $width=$sheetArray[$indexSheet]['width']==null?20:$sheetArray[$indexSheet]['width'];
            $specialArray=$sheetArray[$indexSheet]['specialArray']==null?array():$sheetArray[$indexSheet]['specialArray'];
        	//设置表头
            $cellArray = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            $key = 0;
            foreach($headArr as $v){
                $colum = $cellArray[$key];
                $objPHPExcel->setActiveSheetIndex($indexSheet)->getColumnDimension($colum)->setWidth($width);
                $objPHPExcel->setActiveSheetIndex($indexSheet) ->setCellValue($colum.'1', split(',',$v)[1]);
                $key += 1;
            }

            $column = 2;
            //foreach($data as $key => $rows){ //行写入
            //    $span = ord("A");
            //    foreach($rows as $keyName=>$value){// 列写入
            //        $j = chr($span);
            //        $objActSheet->setCellValue($j.$column, $value);
            //        $span++;
            //    }
            //    $column++;
            //}
            
            for($i=0;$i<count($data);$i++){  //行
                for($j=0;$j<count($cellArray);$j++){ //列
                    if(in_array(split(',',$headArr[$j])[1],$specialArray))
                    {
                        $objPHPExcel->getActiveSheet($indexSheet)->setCellValueExplicit($cellArray[$j].($i+$column), strval($data[$i][split(',',$headArr[$j])[0]]),\PHPExcel_Cell_DataType::TYPE_STRING2);
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet($indexSheet)->setCellValue($cellArray[$j].($i+$column), $data[$i][split(',',$headArr[$j])[0]]);
                    }
                }             
            }  
        }
        
        

        $fileName = iconv("utf-8", "gb2312", $fileName);
        
        //重命名表
        //$objPHPExcel->getActiveSheet(0)->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\".xls");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
        
        //$cellNum=count($expCellName);
        //$dataNum=count($expTableData);
        //import('Org.Util.PHPExcel');
        //$objPHPExcel=new \PHPExcel();
        //$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        //for($i=0;$i<$cellNum;$i++){
        //    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        //} 
        //for($i=0;$i<$dataNum;$i++){
        //    for($j=0;$j<$cellNum;$j++){
        //        $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
        //    }             
        //}  
        //header('pragma:public');
        //header('Content-type:application/vnd.ms-excel;charset=utf-8;');
        //header('Content-Disposition:attachment;filename='.$xlsTitle.'.xls');//attachment新窗口打印inline本窗口打印
        //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        //$objWriter->save('php://output'); 
        //exit;
    }
}


