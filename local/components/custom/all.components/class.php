<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Error;
use \Bitrix\Main\Type\DateTime;
use \Bitrix\Highloadblock as HL;


Loc::loadMessages(__FILE__);
class allComponents extends CBitrixComponent
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
        $this->prepareData();
        $this->includeComponentTemplate();
        return true;
    }

    function prepareData(){
        $nav = new Bitrix\Main\UI\PageNavigation($this->arResult['GRID']['GRID_ID']);
        $this->arResult['GRID'] = [
            'GRID_ID' => 'components_list',
            'COLUMNS' => [
                ['id' => 'NAME', 'name' => 'Наименование', 'sort' => 'NAME', 'default' => true],
                ['id' => 'LINK', 'name' => 'Ссылка', 'sort' => 'LINK', 'default' => true],
            ],
            'ROWS' => $this->GetAllAjax(),
            'SHOW_ROW_CHECKBOXES' => true,
            'NAV_OBJECT' => $nav,
            'AJAX_MODE' => 'Y',
            'AJAX_ID' => \CAjax::getComponentID('custom:all.components', '.default', ''),
            'PAGE_SIZES' => [
                ['NAME' => "5", 'VALUE' => '5'],
                ['NAME' => '10', 'VALUE' => '10'],
                ['NAME' => '20', 'VALUE' => '20'],
                ['NAME' => '50', 'VALUE' => '50'],
                ['NAME' => '100', 'VALUE' => '100']
            ],
            'AJAX_OPTION_JUMP'          => 'N',
            'SHOW_CHECK_ALL_CH  ECKBOXES' => true,
            'SHOW_ROW_ACTIONS_MENU'     => true,
            'SHOW_GRID_SETTINGS_MENU'   => true,
            'SHOW_NAVIGATION_PANEL'     => true,
            'SHOW_PAGINATION'           => true,
            'SHOW_SELECTED_COUNTER'     => true,
            'SHOW_TOTAL_COUNTER'        => true,
            'SHOW_PAGESIZE'             => true,
            'SHOW_ACTION_PANEL'         => true,
//            'ACTION_PANEL'              => [
//                'GROUPS' => [
//                    'TYPE' => [
//                        'ITEMS' => [
//                            [
//                                'ID'    => 'set-type',
//                                'TYPE'  => 'DROPDOWN',
//                                'ITEMS' => [
//                                    ['VALUE' => '', 'NAME' => '- Выбрать -'],
//                                    ['VALUE' => 'plus', 'NAME' => 'Поступление'],
//                                    ['VALUE' => 'minus', 'NAME' => 'Списание']
//                                ]
//                            ],
//                            [
//                                'ID'       => 'edit',
//                                'TYPE'     => 'BUTTON',
//                                'TEXT'        => 'Редактировать',
//                                'CLASS'        => 'icon edit',
//                                'ONCHANGE' => ''
//                            ],
//                            [
//                                'ID'       => 'delete',
//                                'TYPE'     => 'BUTTON',
//                                'TEXT'     => 'Удалить',
//                                'CLASS'    => 'icon remove',
//                                'ONCHANGE' => $onchange->toArray()
//                            ],
//                        ],
//                    ]
//                ],
//            ],
            'ALLOW_COLUMNS_SORT'        => true,
            'ALLOW_COLUMNS_RESIZE'      => true,
            'ALLOW_HORIZONTAL_SCROLL'   => true,
            'ALLOW_SORT'                => true,
            'ALLOW_PIN_HEADER'          => true,
            'AJAX_OPTION_HISTORY'       => 'N'
        ];
    }

    function GetAllAjax(){
        $relPath = '/local/components/custom';
        $path = $_SERVER['DOCUMENT_ROOT'] . $relPath;
        $arComp = scandir($path);
        foreach ($arComp as $comp){
            if($comp == '.' || $comp == '..') continue;
            $compPath = $path . '/' . $comp . '/ajax.php';
            if(file_exists($compPath)){
                $res[]['data']= ['LINK' => '<a href="' . $relPath . '/' . $comp . '/ajax.php' . '" target="_self">Ссылка</a>',
                        'NAME' => $comp];
            }
        }

        return $res;
    }
}