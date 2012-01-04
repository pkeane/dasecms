{extends file="layout.tpl"}

{block name="content"}

<h2>Nodeset {$node->name} ({$nodeset->ascii_id})</h2>
<h3>filters</h3>
<table id="filters" class="node_form">
	<tr class="headers">
		<th>Attribute</th>
		<td>Operator</td>
		<td>Value</td>
		<td></td>
	</tr>
	{foreach item=filter from=$nodeset->filters}
	<tr>
		<th>{$filter->att_ascii}</th>
		<td>{$filter->operator}</td>
		<td>{$filter->value}</td>
		<td><a href="filter/{$filter->id}" class="delete">[delete]</a></td>
	</tr>
	{/foreach}
	<tr>
		<form id="filters" action="nodeset/{$nodeset->id}/filters" method="post">
			<th>
				<select name="att_ascii">
					<option>select one:</option>
					<option value="_id">Node: id</option>
					<option value="_name">Node: name</option>
					<option value="_title">Node: title</option>
					<option value="_type">Node: type</option>
					<option value="_filesize">Node: filesize</option>
					<option value="_mime">Node: mime</option>
					<option value="_width">Node: width</option>
					<option value="_height">Node: height</option>
					<option value="_created">Node: created</option>
					<option value="_created_by">Node: created_by</option>
					<option value="_updated">Node: updated</option>
					<option value="_updated_by">Node: updated_by</option>
					{foreach item=att from=$atts}
					<option value="{$att->ascii_id}">NodeAttvals: {$att->name}</option>
					{/foreach}
				</select>
			</th>
			<td>
				<select name="operator">
					<option>select one:</option>
					<option value="exists">exists (ignores value)</option>
					<option value="=">equals</option>
					<option value="gt">is greater than</option>
					<option value="lt">is less than</option>
					<option value="like">like</option>
					<option value="omit_if">omit if equals</option>
				</select>
			</td>
			<td>
				<select class="hide" name="defined_value"></select>
				<input type="text" name="value">
				<input type="submit" value="add">
				{if $node->dynamic_alias}
				<p><strong>dynamic alias:</strong> {$node->dynamic_alias}</p>
				{/if}
			</td>
			<td></td>
		</form>
	</tr>
</table>
<h3>sorters</h3>
<table id="sorters" class="node_form">
	<tr class="headers">
		<th>Attribute</th>
		<td>Direction</td>
		<td></td>
		<td></td>
	</tr>
	{foreach item=sorter from=$nodeset->sorters}
	<tr>
		<th>{$sorter->att_ascii}</th>
		<td>
			{if $sorter->is_descending}
			descending
			{else}
			ascending
			{/if}
		</td>
		<td></td>
		<td><a href="sorter/{$sorter->id}" class="delete">[delete]</a></td>
	</tr>
	{/foreach}
	<tr>
		<form id="sorters" action="nodeset/{$nodeset->id}/sorters" method="post">
			<th>
				<select name="att_ascii">
					<option>select one:</option>
					<option value="name">Node: name</option>
					<option value="title">Node: title</option>
					<option value="type">Node: type</option>
					<option value="filesize">Node: filesize</option>
					<option value="mime">Node: mime</option>
					<option value="width">Node: width</option>
					<option value="height">Node: height</option>
					<option value="created">Node: created</option>
					<option value="created_by">Node: created_by</option>
					<option value="updated">Node: updated</option>
					<option value="updated_by">Node: updated_by</option>
					{foreach item=att from=$atts}
					<option value="{$att->ascii_id}">NodeAttvals: {$att->name}</option>
					{/foreach}
				</select>
			</th>
			<td>
				<select name="is_descending">
					<option value="0">ascending</option>
					<option value="1">descending</option>
				</select>
			</td>
			<td>
				<input type="submit" value="add">
			</td>
			<td></td>
		</form>
	</tr>
</table>

<p>
<form method="get" action="nodeset/{$nodeset->id}/nodes" id="preview_form">
	{foreach key=dv item=na  from=$nodeset->dynamic_values}
	<label for="{literal}{{/literal}{$dv}{literal}}{/literal}">sample value for: {literal}{{/literal}{$dv}{literal}}{/literal}</label>
	<input type="text" name="{literal}{{/literal}{$dv}{literal}}{/literal}">
	{/foreach}
	<input type="submit" value="preview set">
</form>
</p>

<div id="preview"></div>
{/block}
