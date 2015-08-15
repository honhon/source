<h1 id="subtitle"><span class="subtitle">■</span> 環境変数</h1>
<br clear="all" />
<table class="env">
<?
foreach($list as $k => $v){
?>
	<tr><th class="left"><?=htmlspecialchars($k, ENT_QUOTES)?></th><td class="left"><?=htmlspecialchars($v, ENT_QUOTES)?></td></tr>
<?
}
?>
</table>
