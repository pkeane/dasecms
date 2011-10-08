{extends file="layout.tpl"}

{block name="main"}

<div class="controls">
	<a href="node/{$node->id}" class="active">node</a> |
	<a href="node/{$node->id}/edit">edit</a> |
	<a href="node/{$node->id}/attvals">attvals</a> |
	<a href="node/{$node->id}/attachments">attachments</a>
</div>
<h2>
	{if $node->title}
	{$node->title}
	{else}
	{$node->name}
	{/if}
	(<a href="node/{$node->id}">node/{$node->id}</a>)
</h2>
<p>
{$node->body}
</p>
{if $node->is_image}
<img src="node/{$node->name}">
{/if}

<table id="node_meta" class="node_form">
	<tr class="headers">
		<th>Field</th>
		<td>Value</td>
	</tr>
	{foreach item=v key=k from=$node}
	<tr>
		<th>{$k}</th>
		<td>{$v}</td>
	</tr>
	{/foreach}
	<tr class="headers">
		<th>Attribute</th>
		<td>Value</td>
	</tr>
	{foreach item=attval from=$node->attvals}
	<tr>
		<th>{$attval->att_ascii}</th>
		<td>{$attval->value}</td>
	</tr>
	{/foreach}
</table>
{/block}
