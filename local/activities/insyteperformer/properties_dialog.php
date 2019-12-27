<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<tr>
    <td align="right"><?= GetMessage("BPSG_MANAGER") ?>:</td>
    <td valign="top">
        <input type="text" name="manager" id="manager" value="<?= htmlspecialcharsbx($arCurrentValues["manager"]) ?>" size="20" />
        <input type="button" value="..." onclick="BPAShowSelector('manager', 'string');" />
    </td>

</tr>



<tr>
    <td align="right"><?= GetMessage("BPSG_GROUP") ?>:</td>
    <td valign="top">
        <input type="text" name="group" id="group" value="<?= htmlspecialcharsbx($arCurrentValues["group"]) ?>" size="20" />
        <input type="button" value="..." onclick="BPAShowSelector('group', 'string');" />
    </td>

</tr>