<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<tr id="tr_time_type_selector_delay" style="display:none">
	<td align="right" width="40%"><?= GetMessage("CPAD_DP_TIME") ?>:</td>
	<td width="60%">
		<?=CBPDocument::ShowParameterField('int', 'delay_time', $arCurrentValues["delay_time"], array('size' => 20))?>
		<select name="delay_type">
			<option value="s" selected><?= GetMessage("CPAD_DP_TIME_S") ?></option>
		</select>
		<?
		$delayMinLimit = CBPSchedulerService::getDelayMinLimit();
		if ($delayMinLimit):
			?>
			<p style="color: red;">* <?= GetMessage("CPAD_PD_TIMEOUT_LIMIT") ?>: <?=CBPHelper::FormatTimePeriod($delayMinLimit)?></p>
			<?
		endif;
		?>
	</td>
</tr>