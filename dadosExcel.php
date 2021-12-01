<?php
function dadosExcel(){
    require_once "PHPExcel/Classes/PHPExcel.php";
    $arquivo = "arquivos/excel/".$_SESSION["campanha"].".xls";
    
    if(!file_exists($arquivo))
    	$arquivo = "arquivos/excel/".$_SESSION["campanha"].".xlsx";
    
    if(!file_exists($arquivo))
    	$arquivo = false;

    if(!$arquivo){
        echo $_SESSION["campanha"].".xls não é um arquivo excel";
    }else{
    	$obExcel = PHPExcel_IOFactory::load($arquivo);

        $colunas = $obExcel->setActiveSheetIndex(0)->getHighestColumn();
        $totalColunas = PHPExcel_Cell::columnIndexFromString($colunas);

        $totalLinhas = $obExcel->setActiveSheetIndex(0)->getHighestRow();

        for($l = 1; $l <= $totalLinhas ; $l++){
            $celular = utf8_decode($obExcel->getActiveSheet()->getCellByColumnAndRow(0, $l)->getValue());
            $arr_celular []= array(
                'celular' => $celular
            );
        }
    }
    return $arr_celular;
}
?>