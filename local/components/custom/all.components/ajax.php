<?php


define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('PUBLIC_AJAX_MODE', true);
define('DisableEventsCheck', true);
    require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    {
        die();
    }
    global $APPLICATION;
    $componentParams = isset($_REQUEST['PARAMS']['params']) && is_array($_REQUEST['PARAMS']['params']) ? $_REQUEST['PARAMS']['params'] : array();

    $APPLICATION->IncludeComponent('custom:all.components',
        isset($componentParams['template']) ? $componentParams['template'] : '',
        $componentParams,
        false,
        array('HIDE_ICONS' => 'Y', 'ACTIVE_COMPONENT' => 'Y')
    );
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');