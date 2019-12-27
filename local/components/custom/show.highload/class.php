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
        if(!isset($this->arParams['ENTITY_ID']) || empty($this->arParams['ENTITY_ID'])){
            $this->arParams['ENTITY_ID'] = 1;
        }
        $this->entity = new Custom\Highload($this->arParams['ENTITY_ID']);
        if(!$this->entity->block){
            $this->includeComponentTemplate();
            return false;
        }
        $this->prepareData();
        $this->includeComponentTemplate();
        return true;
    }

    function prepareData(){
        $this->GetHighLoad();
        $this->getData();
        $nav = new Bitrix\Main\UI\PageNavigation($this->arResult['GRID']['GRID_ID']);
        $this->arResult['GRID'] = [
            'GRID_ID' => 'highload_list',
            'COLUMNS' => $this->arResult['HEADERS'],
            'ROWS' => $this->arResult['ROW'],
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
            'SHOW_CHECK_ALL_CHECKBOXES' => true,
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

    function listProperty()
    {
        return $GLOBALS["USER_FIELD_MANAGER"]->getUserFieldsWithReadyData('HLBLOCK_'.$this->entity->id,
            $this->arParams['ELEMENT_ID'] ?? 1, LANGUAGE_ID);
    }

    function GetHighLoad(){
        global $APPLICATION, $USER, $USER_FIELD_MANAGER;

        $this->arResult['ENABLE_TOOLBAR'] = true;

//        $this->arResult['FORM_ID'] = 'CRM_ADDITIONAL_AGREEMENT_SHOW_V12';
//        $this->arResult['TACTILE_FORM_ID'] = $this->arResult['FORM_ID'];
        $this->arResult['GRID_ID'] = 'CRM_ADDITIONAL_AGREEMENT_LIST_V12';
        $this->arResult['TAB_ID'] = isset($this->arParams['TAB_ID']) ? $this->arParams['TAB_ID'] : 'tabs_agreement_additional_'.$this->arParams[$this->arParams["ENTITY_TYPE_NAME_WITH_ID"]];

        $this->arResult['IS_AJAX_CALL'] = isset($_REQUEST['AJAX_CALL']) || isset($_REQUEST['ajax_request']) || !!CAjax::GetSession();

        $this->arResult['PREFIX'] = 'form_agreement_additional';
        $this->arResult['AJAX_MODE'] = isset($this->arParams['AJAX_MODE']) ? $this->arParams['AJAX_MODE'] : ($this->arParams['INTERNAL'] ? 'N' : 'Y');
        $this->arResult['AJAX_ID'] = isset($this->arParams['AJAX_ID']) ? $this->arParams['AJAX_ID'] : '';
        $this->arResult['AJAX_OPTION_JUMP'] = isset($this->arParams['AJAX_OPTION_JUMP']) ? $this->arParams['AJAX_OPTION_JUMP'] : 'N';
        $this->arResult['AJAX_OPTION_HISTORY'] = isset($this->arParams['AJAX_OPTION_HISTORY']) ? $this->arParams['AJAX_OPTION_HISTORY'] : 'N';
        $this->arResult['DEAL_ID'] = $this->arParams['DEAL_ID'];


        $this->arResult['PATH_TO_ADDITIONAL_AGREEMENT_ADD'] = CComponentEngine::MakePathFromTemplate($this->arParams['PATH_TO_ADDITIONAL_AGREEMENT'],
            array(
                mb_strtolower($this->arParams["ENTITY_TYPE_NAME_WITH_ID"]) => $this->arParams[$this->arParams["ENTITY_TYPE_NAME_WITH_ID"]],
                'agreement_additional_id' => 0,
                'mode' => 'edit'
            )
        );

        $this->arResult['HEADERS'] = array();
        $this->arResult['FILTER_PRESETS'] = array();

        $this->arResult['SELECTED_HEADERS'] = array_keys($this->arResult['PROPERTIES']);
        $this->arResult['SESSION_ID'] = bitrix_sessid();



        // получаем все поля HL-блока
        $this->arResult['PROPERTIES'] = $this->listProperty();
        unset($this->arResult['PROPERTIES']['UF_'.$this->arParams["ENTITY_TYPE_NAME"]]);
        $this->arResult['CUSTOM_PROPERTIES'] = array();


//        $this->arResult['PROPERTIES']['ID'] = [
//            'FIELD_NAME' => 'ID',
//            'EDIT_FORM_LABEL' => 'Номер расчета',
//            'USER_TYPE_ID' => 'string',
//        ];
        foreach ($this->arResult['PROPERTIES'] as $key => $prop) {
            $type = 'custom';

            $items = array('' => '');

            switch ($prop['USER_TYPE_ID']) {
                case 'string':
                    $type = 'text';
                    if ($prop['SETTINGS']['ROWS'] > 1) {
                        $params = array('rows' => $prop['SETTINGS']['ROWS']);
                    }
                    break;
                case 'date':
                case 'datetime':
                    $type = 'date';
                    break;
                case 'double':
                    $type = 'text';
                    break;
                case 'boolean':
                    $type = 'checkbox';
                    break;
                case 'enumeration':
                    if ($prop['MULTIPLE'] != "Y") {
                        $type = 'list';
                        if (is_callable(array($prop["USER_TYPE"]['CLASS_NAME'], 'getlist'))) {
                            $rsEnum = call_user_func_array(
                                array($prop['USER_TYPE']['CLASS_NAME'], 'getlist'),
                                array($prop)
                            );
                            while ($arEnum = $rsEnum->GetNext()) {
                                $items[$arEnum['ID']] = $arEnum['VALUE'];
                            }
                        }
                    }
                    break;
            }
            $header = array(
                'id' => $key,
                'name' => ('' != $prop['EDIT_FORM_LABEL'] ? $prop['EDIT_FORM_LABEL'] : $prop['FIELD_NAME']),
                'sort' => $prop['FIELD_NAME'], 'default' => true, 'editable' => true, 'type' => $type
            );

            if ($type == 'list') {
                $header['editable'] = array('items' => $items);
            }

            $this->arResult['HEADERS'][] = $header;

            if ($type == 'custom') {
                $this->arResult['CUSTOM_PROPERTIES'][$key] = $prop;
            }
        }
    }

    protected function getFilter(){
        return [];
    }

    protected function getData()
    {
        global $APPLICATION, $USER, $USER_FIELD_MANAGER;


        $isInExportMode = false;

        $arNavParams = array(
            'nPageSize' => $this->arParams['DEAL_COUNT']
        );

        $gridOptions = new \Bitrix\Main\Grid\Options($this->arResult['GRID_ID'], $this->arResult['FILTER_PRESETS']);
        $filterOptions = new \Bitrix\Main\UI\Filter\Options($this->arResult['GRID_ID'],
            $this->arResult['FILTER_PRESETS']);
        $arNavParams = $gridOptions->GetNavParams($arNavParams);
        $arNavParams['bShowAll'] = false;


        //
        //region Navigation data initialization
        //

        $pageNum = 0;
        $pageSize = !$isInExportMode
            ? (int) (isset($arNavParams['nPageSize']) ? $arNavParams['nPageSize'] : $this->arParams['COUNT']) : 0;
        $enableNextPage = false;
        $rsCount = $this->entity->classes::getList(array(
            'filter' => $this->getFilter(),
            'select' => array('CNT'),
            'runtime' => array(
                new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')
            )
        ));
        $total = 0;
        if ($arCount = $rsCount->Fetch()) {
            $total = $arCount['CNT'];
        }

        if (isset($_REQUEST['apply_filter']) && $_REQUEST['apply_filter'] === 'Y') {
            $pageNum = 1;
        } elseif ($pageSize > 0 && isset($_REQUEST['page'])) {
            $pageNum = (int) $_REQUEST['page'];
            if ($pageNum < 0) {
                //Backward mode
                $offset = -($pageNum + 1);
                $pageNum = (int) (ceil($total / $pageSize)) - $offset;
                if ($pageNum <= 0) {
                    $pageNum = 1;
                }
            }
        }

        if ($pageNum > 0) {
            if (!isset($_SESSION['CRM_PAGINATION_DATA'])) {
                $_SESSION['CRM_PAGINATION_DATA'] = array();
            }
            $_SESSION['CRM_PAGINATION_DATA'][$this->arResult['GRID_ID']] = array('PAGE_NUM' => $pageNum);
        } else {
            if ($pageNum <= 0) {
                $pageNum = 1;
            }
        }

        if ($pageSize * $pageNum < $total) {
            $enableNextPage = true;
        }

        $this->arResult['PAGINATION'] = array('PAGE_NUM' => $pageNum, 'ENABLE_NEXT_PAGE' => $enableNextPage);



        //
        //end region
        //

        //
        //region items
        //
        $arSort['ID'] = 'desc';
        if ($_REQUEST['grid_action'] == 'sort') {
            $arSort[$_REQUEST['by']] = $_REQUEST['order'];
        }
        $row = [];
        $items = $this->entity->get_list([
            'filter' => $this->getFilter(),
            'limit' => $pageSize,
            'offset' => $pageSize * ($pageNum - 1),
            'order' => $arSort
        ]);
        foreach ($items as $item){
            $item['columns'] = array();
            foreach ($this->arResult['HEADERS'] as $header) {
                if ($header['type'] == 'list') {
                    if (is_array($item[$header['id']])) {
                        $values = array();
                        foreach ($item[$header['id']] as $val) {
                            $values[] = $header['editable']['items'][$val];
                        }

                        $item['columns'][$header['id']] = implode(' / ', $values);
                    } else {
                        $item['columns'][$header['id']] = $header['editable']['items'][$item[$header['id']]];
                    }
                } elseif ($header['type'] == 'checkbox') {
                    $ChekLabel = $this->arResult["PROPERTIES"][$header['id']]["SETTINGS"]["LABEL"];
                    $ChekLabel[0] = strlen($ChekLabel[0]) == 0 ? "нет" : $ChekLabel[0];
                    $ChekLabel[1] = strlen($ChekLabel[1]) == 0 ? "да" : $ChekLabel[1];
                    if ($item[$header['id']]) {
                        $item['columns'][$header['id']] = $ChekLabel[1];
                    } else {
                        $item['columns'][$header['id']] = $ChekLabel[0];
                    }
                }
            }
            $row[] = [
                'id' => $item,
                'actions' => [],
                'data' => $item,
                'editable' => 'N',
                'column' => $item['column']
            ];
        }


        $this->arResult['ROW'] = $row;


//        $resultItem = array(
//            'id' => $arItem['ID'],
//            'actions' => $arActions,
//            'data' => $arItem,
//            'editable' => !$arItem['EDIT'] ? ($arResult['INTERNAL'] ? 'N' : $arColumns) : 'Y',
//            'columns' => $arItem['columns']
//        );


    }

}