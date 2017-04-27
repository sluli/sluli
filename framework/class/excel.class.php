<?php
class excel {
    public static function xlsToArray($file_name){
        require_once(IA_ROOT . '/framework/opp/excel/PHPExcel.php');
        $phpreader = new PHPExcel_Reader_Excel2007();
        if(!$phpreader->canRead($file_name)){
            $phpreader = new PHPExcel_Reader_Excel5();
            if (!$phpreader->canRead($file_name)){
                message('读取文件失败');
            }
        }
        $PHPExcel = $phpreader->load($file_name);
        $currentSheet = $PHPExcel->getSheet(0);
        $allcolumn = $currentSheet->getHighestColumn();
        if(strlen($allcolumn) > 1){
            $allcolumn = 'Z';
        }
        $allrow = $currentSheet->getHighestRow();
        $data = $da = array();
        for($rindex = 1;$rindex <= $allrow;$rindex++){
            $ccell = array();
            for($cindex = 'A';$cindex <= $allcolumn;$cindex++){
                $addr = $cindex.$rindex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if(!empty($da) && !empty($da[$cindex])){
                    $ccell[$da[$cindex]] = $cell;
                }else{
                    if(!empty($cell)){
                        $ccell[$cindex] = $cell;
                    }
                }
            }
            $data[] = $ccell;
            if($rindex == 1){
                $da = $ccell;
            }
        }
        return $data;
    }

    public static function arrayToXls( $data , $filename = 'export'){
        require_once(IA_ROOT . '/framework/opp/excel/PHPExcel.php');
        require_once(IA_ROOT . '/framework/opp/excel/PHPExcel/Writer/Excel5.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($data as $rowId => $row){
            $char = ord('A');
            foreach ($row as $colId => $col){
                $colChar = chr( $char++ );
                $line = $rowId+1;
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue("{$colChar}{$line}", $col );
            }
        }
        //exit();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save(str_replace('.php', '.xls', __FILE__));
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename={$filename}.xls");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save("php://output");
    }

    public static function arrayToCsv( $data ){
        self::arrayToXls( $data);
        return ;
        $filename = time().'.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $xls_data = [];
        foreach ($data as $row){
            $str = implode(',', $row);
            $xls_data[] = iconv('utf-8','gb2312', $str);
        }
        echo implode("\n", $xls_data);
    }

    public static function getCsvHeader( $keys ){
        $data = [];
        $keys = is_array($keys) ? $keys : explode(',', $keys);
        foreach ($keys as $key){
            $data[] = \APP::$lang->get( $key );
        }
        return $data;
    }
    public static function getCsvData( $row, $keys){
        $data = [];
        $keys = is_array($keys) ? $keys : explode(',', $keys);
        foreach ($keys as $key){
            if( strpos($key, '[]')!==false ){
                $data[] = implode(' ', $row[str_replace('[]','',$key)]);
            } else {
                $data[] = $row[$key];
            }

        }
        return $data;
    }
}