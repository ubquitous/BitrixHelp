<?php


namespace Custom;

use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Loader;

class CustomComponents extends CBitrixComponent
{

    /**
     * @array $instruction - name, description, parameters - name, description
     * @param $params
     * @return mixed
     */
    public function onPrepareComponentParams($params)
    {
        global $APPLICATION;
        if(file_exists(__DIR__ . "/instruction.php")){
            include_once __DIR__ . "/instruction.php";
            CJSCore::Init(['custom']);
            if(!empty($instruction)){

                $html = "";
                ob_start();
                $grid = [];
                echo '<div class="container">
                          <h2>' . $instruction["name"] . '</h2>
                          <div class="description">' . $instruction["description"] . '</div>
                          <div class="table-container">
                                ' .
                    $APPLICATION->IncludeComponent('bitrix:main.ui.grid',
                        '',
                        $grid)
                    . '
                          </div>
                        </div>';


                $html = ob_get_contents();
                ob_end_clean();
                echo $html;
            }
        }
        return $params;
    }
}
