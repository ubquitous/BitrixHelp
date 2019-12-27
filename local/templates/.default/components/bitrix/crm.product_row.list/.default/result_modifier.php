<?php
$this->__file = '/bitrix/components/bitrix/crm.product_row.list/templates/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.product_row.list/templates/.default';
if(isset($arParams['CUSTOM_PRODUCT_TYPE'])){
    $arResult['COMPONENT_ID'] .= '_'.$arParams['CUSTOM_PRODUCT_TYPE'];
}
use \Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.product_row.list/templates/.default/style.css');
Asset::getInstance()->addJs('/bitrix/components/bitrix/crm.product_row.list/templates/.default/script.js');
//Asset::getInstance()->addCss('/bitrix/js/intranet/theme_picker/theme_picker.css');
//Asset::getInstance()->addCss('/bitrix/js/calendar/core_planner_handler.css');
//Asset::getInstance()->addCss('/bitrix/js/ui/actionpanel/css/style.css');
//Asset::getInstance()->addCss('/bitrix/js/im/css/common.css');
//Asset::getInstance()->addCss('/bitrix/js/im/css/window.css');
//Asset::getInstance()->addCss('/bitrix/js/im/css/im.css');
//Asset::getInstance()->addCss('/bitrix/js/im/css/call/view.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/main.interface.buttons/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.utm.entity.view/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.tracking.entity.details/templates/view/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.entity.progressbar/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.timeline/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.tracking.entity.details/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/tasks.iframe.popup/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/templates/bitrix24/components/bitrix/search.title/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/templates/bitrix24/components/bitrix/menu/left_vertical/map.css');
//Asset::getInstance()->addCss('/bitrix/templates/bitrix24/components/bitrix/menu/left_vertical/groups.css');
//Asset::getInstance()->addCss('/bitrix/templates/bitrix24/components/bitrix/menu/left_vertical/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.card.show/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/templates/bitrix24/components/bitrix/im.messenger/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/main.interface.buttons/templates/.default/style.css');
//Asset::getInstance()->addCss('/bitrix/components/bitrix/crm.button.webform/templates/.default/style.css');