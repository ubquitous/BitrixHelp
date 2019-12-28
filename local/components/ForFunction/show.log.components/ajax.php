<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $APPLICATION;
$componentParams = $_REQUEST;

$APPLICATION->IncludeComponent('ForFunction:show.log.components',
    isset($componentParams['template']) ? $componentParams['template'] : '',
    $componentParams,
    false,
    array('HIDE_ICONS' => 'Y', 'ACTIVE_COMPONENT' => 'Y')
);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');