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
<a href="node/{$node->id}/prev">prev</a> | <a href="node/{$node->id}/next">next</a>
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
		<tr>
			<th>system url</th>
			<td>
				<a href="node/{$node->id}">node/{$node->id}</a>
			</td>
		</tr>

		<tr>
			<th>file url</th>
			<td>
				<a href="file/{$node->id}">file/{$node->id}</a>
			</td>
		</tr>

		<tr>
			<th>name (linked)</th>
			<td>
				<a href="node/{$node->name}">{$node->name}</a>
			</td>
		</tr>

	{foreach item=v key=k from=$node}
	<tr>
		<th>{$k}</th>
		<td>{$v}</td>
	</tr>
	{/foreach}
		<tr>
			<th>page url</th>
			<td>
				{if $node->alias}
				<a href="page/{$node->alias}">page/{$node->alias}</a>
				{/if}
			</td>
		</tr>
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
