<?php


$this->__file = '/bitrix/components/bitrix/crm.product.section.tree/templates/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.product.section.tree/templates/.default';
use \insyte\HL_save;
$hl = new HL_save();
$id_arr = $hl->get_service();
if(strpos(strtolower($arResult['JS_EVENTS_MANAGER_ID']), 'product') !== false){
    foreach ($arResult['INITIAL_TREE'] as $key => $val) {
        if(in_array($val['ID'], $id_arr)){
            unset($arResult['INITIAL_TREE'][$key]);
        }
    }
    if(in_array($arResult['SECTION_ID'], $id_arr)){
        $arResult['SECTION_ID'] = $arResult['INITIAL_TREE'][key($arResult['INITIAL_TREE'])]['ID'] ?? 0;
    }
}
if(strpos(strtolower($arResult['JS_EVENTS_MANAGER_ID']), 'service') !== false){
    foreach ($arResult['INITIAL_TREE'] as $key => $val) {
        if(!in_array($val['ID'], $id_arr)){
            unset($arResult['INITIAL_TREE'][$key]);
        }
    }
    if(!in_array($arResult['SECTION_ID'], $id_arr)){
        $arResult['SECTION_ID'] = $id_arr[0];
    }
}
foreach ($arResult['INITIAL_TREE'] as $key => $val) {
    $arrSec[] = $val;
}
$arResult['INITIAL_TREE'] = $arrSec;
use \Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.product.section.tree/templates/.default/style.css');
Asset::getInstance()->addJs('/bitrix/components/bitrix/crm.product.section.tree/templates/.default/script.js');