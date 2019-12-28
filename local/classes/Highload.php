<?php


namespace Custom;

use \Bitrix\Highloadblock as HL;
use \Bitrix\Main\Loader;


/*
 * класс для работы с HighLoadBlock
 */
class Highload
{
    public $block;
    public $entity;
    public $classes;
    public $id;
    public $name;
    function __construct($id)
    {
        if(!Loader::includeModule('highloadblock')){
            return false;
        }
        $this->set_block($id);

    }

    /*
     * @id - id highloadblock
     */
    public function set_block($id){
        if(intval($id) > 0){
            $this->block = HL\HighloadBlockTable::getById($id)->fetch();

        }else{
            $this->block = HL\HighloadBlockTable::getList(['filter'=>['NAME'=>$id]])->fetch();

        }
        if(!$this->block)
            return false;
        $this->id = $this->block['ID'];
        $this->entity = HL\HighloadBlockTable::compileEntity($this->block);
        $this->classes = $this->entity->getDataClass();
        return true;
    }

    /*
     * @filter
     * @select
     * @order
     */
    public function get_list($arg){
        if(!is_array($arg)) $arg = [];
        $res = $this->classes::getList($arg);
        $result = [];
        while($item = $res->fetch()){
            $result[] = $item;
        }
        return $result;
    }

    public function add_high($item){
        return $this->classes::add($item);
    }

    public function update_high($id, $item){
        return $this->classes::update($id, $item);
    }

    public function delete_high($id){
        return $this->classes::delete($id);
    }

    public function get_fields(){
        if(!$this->block) return false;
        $result = [];
        $prop = $GLOBALS["USER_FIELD_MANAGER"]->getUserFieldsWithReadyData('HLBLOCK_' . $this->block['id'],
            1, LANGUAGE_ID);
        foreach ($prop as $key => $val){
            $data = [];
            $data[$val['FIELD_NAME']]['FIELD_NAME']         = $val['FIELD_NAME'];
            $data[$val['FIELD_NAME']]['NAME']               = $val['LIST_FILTER_LABEL'];
            $data[$val['FIELD_NAME']]['XML_ID']             = $val['XML_ID'];
            $data[$val['FIELD_NAME']]['USER_TYPE']          = $val['USER_TYPE'];
            $data[$val['FIELD_NAME']]['ID']                 = $val['ID'];
            $data[$val['FIELD_NAME']]['USER_TYPE_ID']       = $val['USER_TYPE_ID'];
            if($val['USER_TYPE_ID'] == 'enumeration'){
                $fields = call_user_func_array(
                    array($val['USER_TYPE']['CLASS_NAME'], 'getlist'),
                    array($val)
                );
                while($field = $fields->fetch()){
                    $data[$val['CODE']]['ITEMS'] = $field;
                }
            }
        }

        return $result;
    }

    public function get_header(){
        $head = [];
        $fields = $this->getUserFields();
        foreach($fields as $key => $val){
            $head[] = [
                "id" => $key,
                "name" => $val["EDIT_FORM_LABEL"],
                "sort" => $key,
                "default" => false
            ];
        }
        $this->entity->getFields();
        return $head;
    }
    public function get_row(){
        $row = [];
        return $row;
    }

    private function getUserFields(){

        return $GLOBALS["USER_FIELD_MANAGER"]->getUserFieldsWithReadyData('HLBLOCK_' . $this->id,
            0, LANGUAGE_ID);
    }
}