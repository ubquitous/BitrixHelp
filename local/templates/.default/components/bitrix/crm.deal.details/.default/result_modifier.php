<?php
/** @var CBitrixComponentTemplate $this */

use Bitrix\Main\EventManager;

/** @var array $arParams */
/** @var array $arResult * */

$this->__file = '/bitrix/components/bitrix/crm.deal.details/templates/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.deal.details/templates/.default';

//\CJSCore::init("sidepanel");

    //foreach ($arResult ['TABS'] as $key => $vkladka)
    //{
    //    if (in_array($vkladka['id'], ['tab_products', 'tab_automation', 'tab_additional'])){
    //        unset($arResult ['TABS'][$key]);
    //    }
    //}

$arResult['TABS'][] = array(
    'id' => 'tab_result_calc',
    'name' => 'Расчет',
    'loader' => array(
        'serviceUrl' => '/local/components/insyte/crm.additional.agreement.list/lazyload.ajax.php?&site'.SITE_ID.'&'.bitrix_sessid_get(),
        'componentData' => array(
            'template' => '',
            'params' => array(
                "DEAL_ID" => $arResult['ENTITY_ID'],            //ID сделки
                "ENTITY_TYPE_NAME_WITH_ID" => "DEAL_ID",        //имя поля с ID сделки
                "ENTITY_TYPE_NAME" => "DEAL",
                "ENTITY_ID" => 1,                               //ID highload-block
                "POST_FORM_URI" => $arResult["/crm/deal/show/#company_id#"],
                "ACTION_URI" => $arResult["/crm/deal/show/#company_id#"],
                "PATH_TO_USER_PROFILE" => $arResult["/company/personal/user/#user_id#/"],
                "FORM_ID" => $arResult["CRM_DEAL_SHOW_V12"],
                "TAB_ID" => "tab_result_calc",
                "PATH_TO_ADDITIONAL_AGREEMENT" => '/local/components/insyte/crm.additional.agreement.edit/lazyload.ajax.php?&site'.SITE_ID.'&'.bitrix_sessid_get()
            )
        )
    )
);



