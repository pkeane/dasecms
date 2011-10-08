{extends file="layout.tpl"}

{block name="content"}
<div>
	<h1>Create Content</h1>
	<form action="admin/create" method="post">
		<label for="title">title</label>
		<input type="text" name="title"/>
		<label for="body">body</label>
		<textarea name="body"></textarea>
		<p>
		<input type="submit" value="create"/>
		</p>
	</form>

	<h3>Content</h3>
	<table class="uploads">
		<tr>
			<th></th>
			<th>system url</th>
			<th>name</th>
			<th>title</th>
			<th>created</th>
			<th>created by</th>
			<th>edit</th>
		</tr>
		{foreach item=node from=$nodes}
		<tr>
			<td class="thumb">
				<a href="node/{$node->id}/edit"><img src="{$node->thumbnail_url}"></a>
			</td>
			<td>
				<a href="node/{$node->id}">node/{$node->id}</a>
			</td>
			<td>
				<a href="node/{$node->name}">{$node->name|truncate:30:'..':true:true}</a>
			</td>
			<td>
				{$node->title}
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


</div>
{/block}
