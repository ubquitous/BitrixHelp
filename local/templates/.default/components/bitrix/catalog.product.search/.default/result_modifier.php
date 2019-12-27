<?php
$this->__file = '/bitrix/components/bitrix/crm.product.search.dialog/templates/.default/bitrix/catalog.product.search/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.product.search.dialog/templates/.default/bitrix/catalog.product.search/.default';
//var_dump($arResult['CALLER']);
//var_dump($_REQUEST['JS_EVENTS_MANAGER_ID']);

use \insyte\HL_save;
$hl = new HL_save();
$id_arr = $hl->get_service();
if(strpos(strtolower($_REQUEST['JS_EVENTS_MANAGER_ID']), 'product') !== false){
    foreach ($arResult['SECTIONS'] as $key => $val) {
        if(in_array($val['id'], $id_arr)){
            unset($arResult['SECTIONS'][$key]);
        }
    }
    if(in_array($arResult['SECTION_ID'], $id_arr)){
        $arResult['SECTION_ID'] = $arResult['SECTIONS'][key($arResult['SECTIONS'])]['id'];
    }
    foreach ($arResult['BREADCRUMBS'] as $key => $val) {
        if(in_array($key, $id_arr)){
            unset($arResult['BREADCRUMBS'][$key]);
        }
    }
    if(isset($arResult['PRODUCTS'])){
        foreach ($arResult['PRODUCTS'] as $key => $val){
            if($val['TYPE'] == 'S' && in_array($val['ID'], $id_arr)){
                unset($arResult['PRODUCTS'][$key]);
            }else if(in_array($val['IBLOCK_SECTION_ID'], $id_arr)){
                unset($arResult['PRODUCTS'][$key]);
            }
        }
    }
}
if(strpos(strtolower($_REQUEST['JS_EVENTS_MANAGER_ID']), 'service') !== false){
    foreach ($arResult['SECTIONS'] as $key => $val) {
        if(!in_array($val['id'], $id_arr)){
            unset($arResult['SECTIONS'][$key]);
        }
    }
    if(in_array($arResult['SECTION_ID'], $id_arr)){
        $arResult['SECTION_ID'] = $arResult['SECTIONS'][key($arResult['SECTIONS'])]['id'];
    }
    foreach ($arResult['BREADCRUMBS'] as $key => $val) {

        if(!in_array($key, $id_arr)){
            unset($arResult['BREADCRUMBS'][$key]);
        }
    }
    if(isset($arResult['PRODUCTS'])){
        foreach ($arResult['PRODUCTS'] as $key => $val){
            if($val['TYPE'] == 'S' && !in_array($val['ID'], $id_arr)){
                unset($arResult['PRODUCTS'][$key]);
            }else if(!in_array($val['IBLOCK_SECTION_ID'], $id_arr)){
                unset($arResult['PRODUCTS'][$key]);
            }
        }
    }
}
foreach ($arResult['SECTIONS'] as $key => $val) {
        $arrSec[] = $val;
}
$arResult['SECTIONS'] = $arrSec;
if(count($arResult['BREADCRUMBS']) > 0){
    $arResult['SECTION_LABEL'] = $arResult['BREADCRUMBS'][key($arResult['BREADCRUMBS'])]['NAME'];
}else{
    $arResult['SECTION_LABEL'] = NULL;
}
$arResult['FILTER']['SECTION_ID'] = $arResult['SECTION_ID'];


use \Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs('/bitrix/components/bitrix/crm.product.search.dialog/templates/.default/bitrix/catalog.product.search/.default/script.js');