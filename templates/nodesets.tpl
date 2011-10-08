{extends file="layout.tpl"}

{block name="content"}
<h1>Nodesets</h1>
<table id="node_meta" class="node_form">
	<tr class="headers">
		<th>Ascii ID</th>
		<td>Name</td>
		<td>Description</td>
		<td>Max</td>
	</tr>
	{foreach item=nodeset from=$nodesets}
	<tr>
		<th><a href="nodeset/{$nodeset->id}">{$nodeset->ascii_id}</a></th>
		<td>{$nodeset->name}</td>
		<td>{$nodeset->description}</td>
		<td>{$nodeset->max}</td>
	</tr>
	{/foreach}
	<tr>
		<form method="post">
			<th>
			</th>
			<td>
				<input type="text" name="name">
			</td>
			<td>
				<textarea name="description"></textarea>
			</td>
			<td>
				<input type="text" name="max">
				<input type="submit" value="add">
			</td>
		</form>
	</tr>
</table>
</div>
{/block}
