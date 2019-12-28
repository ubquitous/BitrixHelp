<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Error;
use \Bitrix\Main\Type\DateTime;
use \Custom;


Loc::loadMessages(__FILE__);
class ShowLogCompanents extends CBitrixComponent
{
    /**
     * Преодопределение параметров
     * @param $params
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        return $params;
    }


    function executeComponent()
    {
        $this->arResult = $this->arParams;
        $this->includeComponentTemplate();
        return true;
    }


}