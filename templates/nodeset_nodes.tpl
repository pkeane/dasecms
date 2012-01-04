{block name="content"}
<h2>{$nodeset->sorted_nodes|@count} nodes</h2>
<table class="uploads">
	<tr>
		<th></th>
		<th>system url</th>
		<th>name</th>
		<th>title</th>
		<th>body</th>
		<th>mime type</th>
		<th>size</th>
		<th>W x H</th>
		<th>created</th>
		<th>created by</th>
		<th>edit</th>
	</tr>
	{foreach item=node from=$nodeset->sorted_nodes}
	<tr>
		<td class="thumb">
			<a href="node/{$node->id}/edit"><img src="{$node->thumbnail_url}"></a>
		</td>
		<td>
			<a href="node/{$node->id}">node/{$node->id}</a>
		</td>
		<td>
			<a href="node/{$node->name}">{$node->name}</a>
		</td>
		<td>
			{$node->title}
		</td>
		<td>
			{$node->body}
		</td>
		<td>
			{$node->mime}
		</td>
		<td>
			{$node->size}
		</td>
		<td>
			{if $node->width && $node->height}
			{$node->width}x{$node->height}
			{else}
			N/A
			{/if}
		</td>
		<td>
			{$node->created|date_format:'%Y-%m-%d %H:%M'}
		</td>
		<td>
			{$node->created_by}
		</td>
		<td>
			<a href="node/{$node->id}/edit">edit</a>
		</td>
	</tr>
	{/foreach}
</table>
{/block}
