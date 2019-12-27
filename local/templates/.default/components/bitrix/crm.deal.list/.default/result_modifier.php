<?php
/** @var CBitrixComponentTemplate $this */

use Bitrix\Main\EventManager;

/** @var array $arParams */
/** @var array $arResult * */

$this->__file = '/bitrix/components/bitrix/crm.deal.list/templates/.default/template.php';
$this->__folder = '/bitrix/components/bitrix/crm.deal.list/templates/.default';

?>
<script>
    BX.addCustomEvent("SidePanel.Slider:onCloseComplete", function(event) {
        var arr = document.getElementsByClassName('side-panel-iframe');
        for(var i = 0; i < arr.length; i++){
            if(window.frames[arr[i].name].SidePanelOnClose !== undefined){
                window.frames[arr[i].name].SidePanelOnClose('');
            }
        }
    });
</script>


