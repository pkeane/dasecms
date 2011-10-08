{extends file="layout.tpl"}

{block name="content"}
<div id="content">
	<div class="controls">
		<a href="node/{$node->id}">node</a> |
		<a href="node/{$node->id}/edit">edit</a> |
		<a href="node/{$node->id}/attvals">attvals</a> |
		<a href="node/{$node->id}/attachments" class="active">attachments</a>
	</div>
	<h2>
		{if $node->title}
		{$node->title}
		{else}
		{$node->name}
		{/if}
		(<a href="node/{$node->id}">node/{$node->id}</a>)
	</h2>
	<table id="node_meta" class="node_form">
		<tr class="headers">
			<th>Name</th>
			<td>Type</td>
			<td>Name of Attached (Node | Nodeset | URL)</td>
			<td></td>
		</tr>
		{foreach item=attachment from=$node->attachments}
		<tr>
			<th>{$attachment->name}</th>
			<td>{$attachment->child_type}</td>
			<td>
				{if 'url' == $attachment->child_type}
				<a href="{$attachment->child_name}">{$attachment->child_name}</a>
				{else}
				<a href="{$attachment->child_type}/{$attachment->child_id}">{$attachment->child_name}</a>
				{/if}
			</td>
			<td>
				<a href="attachment/{$attachment->id}" class="delete">[delete]</a>
			</td>
		</tr>
		{/foreach}
		<tr>
			<form action="node/{$node->id}/attachments" method="post">
				<th>
					<input type="text" name="name">
				</th>
				<td>
					<select name="child_type">
						<option value="">select one:</option>
						<option value="node">node</option>
						<option value="nodeset">nodeset</option>
						<option value="url">url</option>
					</select>
				</td>
				<td>
					<select name="child_id" class="hide">
					</select>
					<input class="hide" type="text" name="child_name">
					<input class="hide" type="submit" value="add" id="attachment_submit">
				</td>
				<td>
				</td>
			</form>
		</tr>
	</table>
</div>
{/block}
