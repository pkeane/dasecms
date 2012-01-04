{extends file="layout.tpl"}

{block name="content"}
<div id="content">
	<div class="controls">
		<a href="node/{$node->id}">node</a> |
		<a href="node/{$node->id}/edit">edit</a> |
		<a href="node/{$node->id}/attvals" class="active">attvals</a> |
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
<a href="node/{$node->id}/attvals/prev">prev</a> | <a href="node/{$node->id}/attvals/next">next</a>

<p>
{$node->body}
</p>
{if $node->is_image}
<img src="node/{$node->name}">
{/if}

	<table id="node_meta" class="node_form">
		<tr class="headers">
			<th>Attribute</th>
			<td>Value</td>
			<td></td>
		</tr>
		{foreach item=attval from=$node->attvals}
		<tr>
			<th>{$attval->att_ascii}</th>
			<td>{$attval->value}</td>
			<td class="delete">
				<a href="attval/{$attval->id}" class="delete">[delete]</a>
			</td>
		</tr>
		{/foreach}
		<tr>
			<form action="node/{$node->id}/attvals" method="post">
				<th>
					<select name="att_ascii">
						<option value="">select an attribute:</option>
						{foreach item=att from=$atts}
						<option value="{$att->ascii_id}">{$att->name}</option>
						{/foreach}
					</select>
				</th>
				<td>
					<select name="defined_value" class="hide">
					</select>
					<input type="text" name="value" class="hide">
					<input type="submit" value="add">
				</td>
				<td></td>
			</form>
		</tr>
	<tr class="headers">
		<th>Field</th>
		<td>Value</td>
		<td></td>
	</tr>
	{foreach item=v key=k from=$node}
	<tr>
		<th>{$k}</th>
		<td>{$v}</td>
		<td></td>
	</tr>
	{/foreach}

	</table>
</div>
{/block}
