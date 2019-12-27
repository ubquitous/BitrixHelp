<?php
$this->__file = '/bitrix/components/bitrix/crm.product.search.dialog/templates/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.product.search.dialog/templates/.default';
//var_dump($arResult['CALLER']);
//var_dump($_REQUEST['JS_EVENTS_MANAGER_ID']);
use \insyte\HL_save;
$hl = new HL_save();
$id_arr = $hl->get_service();
global $USER;
//$user = \CUserOptions::getOption('catalog', self::TABLE_ID_PREFIX . '_' . $params['caller'], false, intval($USER->GetID()));
//var_dump($user);


