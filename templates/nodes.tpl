{extends file="layout.tpl"}

{block name="content"}
<div class="controls">
	<form method="get" action="jump_to_page">
		<select name="page">
			<option>jump to page:</option>
			{foreach item=page_url from=$pages}
			<option>{$page_url}</option>
			{/foreach}
		</select>
		<input type="submit" value="go">
	</form>
</div>
<h2>Nodes</h2>
<div class="clear"></div>
<table id="home">
	<tr>

	{foreach name=xyz item=node from=$nodes}
	<td>
		<a href="node/{$node->id}"><img src="{$node->thumbnail_url}"></a>
		<p>{$node->name|truncate:20}</p>
	</td>

	{if $smarty.foreach.xyz.iteration is div by 5}
	</tr><tr>
	{/if}
	{/foreach}
</tr>
</table>

{/block}
