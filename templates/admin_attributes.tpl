{extends file="layout.tpl"}

{block name="content"}
<div id="attributes">
	<h1>Attributes</h1>
	<a href="#" class="toggle" id="toggleAttForm">show/hide form</a>
	<form class="hide" id="targetAttForm" action="admin/attributes" method="post">
		<label for="name">name</label>
		<input type="text" name="name">
		<label for="defined">defined values</label>
		<textarea name="defined"></textarea>
		<p>
		<input type="submit" value="add attribute">
		</p>
	</form>
	<ul>
		{foreach item=att from=$atts}
		<li>
		{$att->name} ({$att->ascii_id})
		{if $att->defined_values}
		<ul class="defined_values">
			{foreach item=v from=$att->defined}
			<li>{$v}</li>
			{/foreach}
		</ul>
		{/if}
		</li>
		{/foreach}
	</ul>
</div>
{/block}
