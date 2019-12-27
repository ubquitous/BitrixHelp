<?php


function serializeArray($arr){
    $result = "";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $result .= "{<br><label class='hide-log-item'>" . $key . "</label><div class='log-test'>";
            $result .= serializeArray($val);
            $result .= "</div><br>}";
        } elseif(is_object($val)) {
            $result .= '<div class="log-test">["' . $key . '"] => ' . json_encode($val, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE) . '</div>';
        }else{
            $result .= '<div class="log-test">["' . $key . '"] => ' . $val . '</div>';

        }
    }
    return $result;
}
echo serializeArray($arResult);

//$read = json_encode($arResult['PROGRESS_SEMANTICS'], JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
//$read = str_replace(["\n", "{", "}"], ["<br>", "{<label class='hide'>=</label><div class='log-test'>", "</div>}"], $read);
//
//echo $read;

//$APPLICATION->IncludeComponent(
//    'bitrix:show.log.components',
//    '',
//    $arResult,
//    "",
//    array('HIDE_ICONS' => 'Y')
//);

?>
<script>
    BX.ready(function(){
        var elements = document.querySelectorAll(".hide-log-item");
        for (var elem of elements) {
            elem.onclick = function(){
                this.nextSibling.style.display = (this.nextSibling.style.display == 'none') ? '' : 'none';
            }
        }
    })
</script>
