{extends file="layout.tpl"}

{block name="content"}
<h2>{$main_title}</h2>

<table id="home">
	<tr>

	{foreach key=i item=node from=$nodes}
	<td>
		<a href="node/{$node->id}"><img src="{$node->thumbnail_url}"></a>
		<p>{$node->name}</p>
	</td>

	{if $i is div by 5}
	</tr><tr>
	{/if}
	{/foreach}
</tr>
</table>

{/block}
