<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Crm;

class CBPInsytePerformer extends CBPActivity
{

    public function __construct($name)
    {
        parent::__construct($name);

        $this->arProperties = array(
            "manager"				=> "",
            "group" => '',
        );
    }
    protected function ReInitialize()
    {
        parent::ReInitialize();

    }

    public function Execute()
    {
        $rootActivity = $this->GetRootActivity();

        \CModule::IncludeModule("iblock");
        \CModule::IncludeModule("crm");

        $arDepIds		= [];

        if( strlen( trim($this->manager) ) > 0 && strlen( trim($this->group) ) > 0) {
            preg_match('!\d+!', $this->manager, $matches);
            preg_match_all('|\[[^\d](\d+)\]|U', $this->group, $id_group);
            $id_group = $id_group[1];


            if( sizeof($matches) ){

                $arFilter   = array(
                    "ID"=>$matches[0]
                );
                $userParams = array(
                    'SELECT' => array(
                        'UF_DEPARTMENT',
                        'WORK_DEPARTMENT'
                    )
                );
                $DEPARTMENT_ID      = 0;
                $IBLOCK_STRUCTURE = 5;
                $IBLOCK_ANOTHER = 43;

                //ID группы пользователей "Юристы":
                $trafDepartmentId 		= 15;



                $rsUsers = \CUser::GetList(($by="personal_country"), ($order="desc"), $arFilter, $userParams);
                if($res = $rsUsers->Fetch()){

                    if(sizeof($res["UF_DEPARTMENT"])){

                        if(is_array($res["UF_DEPARTMENT"])){
                            $arDepartments[]    = $res["UF_DEPARTMENT"][0];
                        }else{
                            $arDepartments[]    = $res["UF_DEPARTMENT"];
                        }

                        $arFilter = Array('IBLOCK_ID' => $IBLOCK_STRUCTURE, 'ID'=>$arDepartments);
                        $db_list = \CIBlockSection::GetList(Array($by=>$order), $arFilter, true);

                        if($ar_result = $db_list->GetNext()) {

                            $regionDepartment = $ar_result["IBLOCK_SECTION_ID"];


                            $arSubFilter = Array('IBLOCK_ID' => $IBLOCK_STRUCTURE, 'SECTION_ID'=>$regionDepartment);
                            $db_sub_list = \CIBlockSection::GetList(Array($by=>$order), $arSubFilter, false);

                            while($ar_sub_result = $db_sub_list->GetNext()) {

                                $arDepIds[] = $ar_sub_result["ID"];
                            }
                        }
                    }
                }

                if(sizeof($arDepIds)) {
                    $rsUserListOfDepartment = \CUser::GetList($by = "ID", $order = "asc", ["UF_DEPARTMENT" => $arDepIds, 'GROUPS_ID' => $id_group], []);
                    while ($arUserList = $rsUserListOfDepartment->fetch()) {
                        if(!in_array($arUserList['ID'], $arFilter['ID'])) {
                            $arTraf[] = "user_" . $arUserList["ID"];
                            $rootActivity->SetVariable("DEPARTAMENT_TRAFF", "user_" . $arUserList["ID"]);
                        }
                    }
                    $rootActivity->SetVariable("DEPARTAMENT_PERF_USERS_COUNT", count($arTraf));
                    $rootActivity->SetVariable("DEPARTAMENT_PERF_USERS", $arTraf[rand(0, count($arTraf) - 1)]);
                }
                return \CBPActivityExecutionStatus::Closed;
            }
        }
    }

    public static function ValidateProperties($arTestProperties = array(), CBPWorkflowTemplateUser $user = null)
    {
        $arErrors = array();

        return array_merge($arErrors, parent::ValidateProperties($arTestProperties, $user));
    }

    /**
     * @param $documentType
     * @param $activityName
     * @param $arWorkflowTemplate
     * @param $arWorkflowParameters
     * @param $arWorkflowVariables
     * @param null $arCurrentValues
     * @param string $formName
     * @return mixed
     */
    public static function GetPropertiesDialog($documentType, $activityName,
                                               $arWorkflowTemplate,$arWorkflowParameters, $arWorkflowVariables,
                                               $arCurrentValues = null, $formName = "")
    {
        $runtime = CBPRuntime::GetRuntime();

        if (!is_array($arWorkflowParameters))
            $arWorkflowParameters = array();
        if (!is_array($arWorkflowVariables))
            $arWorkflowVariables = array();

        if (!is_array($arCurrentValues))
        {
            $arCurrentValues = array("manager" => "", 'group' => '');

            $arCurrentActivity= &CBPWorkflowTemplateLoader::FindActivityByName(
                $arWorkflowTemplate,
                $activityName
            );
            if (is_array($arCurrentActivity["Properties"])) {
                $arCurrentValues["manager"] =
                    $arCurrentActivity["Properties"]["manager"];
                $arCurrentValues["group"] =
                    $arCurrentActivity["Properties"]["group"];
            }
        }

        return $runtime->ExecuteResourceFile(
            __FILE__,
            "properties_dialog.php",
            array(
                "arCurrentValues" => $arCurrentValues,
                "formName" => $formName,
            )
        );
    }

    /**
     * @param $documentType
     * @param $activityName
     * @param $arWorkflowTemplate
     * @param $arWorkflowParameters
     * @param $arWorkflowVariables
     * @param $arCurrentValues
     * @param $arErrors
     * @return bool
     */
    public static function GetPropertiesDialogValues($documentType, $activityName,
                                                     &$arWorkflowTemplate, &$arWorkflowParameters, &$arWorkflowVariables,
                                                     $arCurrentValues, &$arErrors)
    {
        $arErrors = array();

        $runtime = CBPRuntime::GetRuntime();

        if (strlen($arCurrentValues["manager"]) <= 0 || strlen($arCurrentValues['group']) <= 0)
        {
            $arErrors[] = array(
                "code" => "emptyCode",
                "message" => "error text",
            );
            return false;
        }

        $arProperties = array("manager" => $arCurrentValues["manager"], "group" => $arCurrentValues["group"]);

        $arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName(
            $arWorkflowTemplate,
            $activityName
        );
        $arCurrentActivity["Properties"] = $arProperties;

        return true;
    }


}