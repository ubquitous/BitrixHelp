<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}
global $APPLICATION;
$APPLICATION->ShowHead();
$APPLICATION->SetTitle('Вывод highloadblock!');


$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', $arResult['GRID']);