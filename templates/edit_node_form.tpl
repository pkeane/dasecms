{extends file="layout.tpl"}

{block name="content"}
<div id="content">
	<div class="controls">
		<a href="node/{$node->id}">node</a> |
		<a href="node/{$node->id}/edit" class="active">edit</a> |
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
	<table id="node_form" class="node_form">
		<tr>
			<th>thumbnail</th>
			<td>
				<img src="{$node->thumbnail_url}">
			</td>
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
			<th>name</th>
			<td>
				<a href="node/{$node->name}">{$node->name}</a>
			</td>
		</tr>

		<tr>
			<th>title</th>
			<td>
				{$node->title} 
				<a href="#" class="toggle" id="toggleNodeTitle">[update]</a>
				<div class="hide" id="targetNodeTitle">
					<form action="node/{$node->id}/title" method="put">
						<input type="text" name="title" value="{$node->title}">
						<input type="submit" value="update">
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th>type</th>
			<td>
				{$node->type} 
				<a href="#" class="toggle" id="toggleNodeType">[update]</a>
				<div class="hide" id="targetNodeType">
					<form action="node/{$node->id}/type" method="put">
						<input type="text" name="type" value="{$node->type}">
						<input type="submit" value="update">
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th>alias</th>
			<td>
				<a href="file/{$node->alias}">{$node->alias}</a>
				<a href="#" class="toggle" id="toggleNodeAlias">[update]</a>
				<div class="hide" id="targetNodeAlias">
					<form action="node/{$node->id}/alias" method="put">
						<input type="text" name="alias" value="{$node->alias}">
						<input type="submit" value="update">
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th>page url</th>
			<td>
				{if $node->alias}
				<a href="page/{$node->alias}">page/{$node->alias}</a>
				{/if}
			</td>
		</tr>

		<tr>
			<th>dynamic alias</th>
			<td>
				{$node->dynamic_alias}
				<a href="#" class="toggle" id="toggleNodeDynAlias">[update]</a>
				<div class="hide" id="targetNodeDynAlias">
					<form action="node/{$node->id}/dynamic_alias" method="put">
						<input type="text" name="dynamic_alias" value="{$node->dynamic_alias}">
						<input type="submit" value="update">
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th>mime type</th>
			<td>
				{$node->mime}
			</td>
		</tr>

		<tr>
			<th>filesize</th>
			<td>
				{$node->filesize}
			</td>
		</tr>

		<tr>
			<th>width</th>
			<td>
				{$node->width}
			</td>
		</tr>

		<tr>
			<th>height</th>
			<td>
				{$node->height}
			</td>
		</tr>

		<tr>
			<th>created</th>
			<td>
				{$node->created|date_format:'%Y-%m-%d %H:%M'}
			</td>
		</tr>

		<tr>
			<th>created by</th>
			<td>
				{$node->created_by}
			</td>
		</tr>

		<tr>
			<th>updated</th>
			<td>
				{$node->updated|date_format:'%Y-%m-%d %H:%M'}
			</td>
		</tr>

		<tr>
			<th>updated by</th>
			<td>
				{$node->updated_by}
			</td>
		</tr>

		<tr>
			<th>body</th>
			<td>
				{$node->body|markdown}
				<a href="#" class="toggle" id="toggleNodeBody">[update]</a>
				<div class="hide" id="targetNodeBody">
					<form action="node/{$node->id}/body" method="put">
						<textarea name="body">{$node->body}</textarea>
						<input type="submit" value="update">
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th>image</th>
			<td>
				{if $is_image}
				<img src="node/{$node->name}">
				{/if}
			</td>
		</tr>

		<tr>
			<th>replace file</th>
			<td>
				<form action="node/{$node->id}/swap" method="post" enctype="multipart/form-data">
					<p>
					<label for="uploaded_file">select a file</label>
					<input type="file" name="uploaded_file"/>
					<input type="submit" value="swap in file"/>
					</p>
				</form>
			</td>
		</tr>
	</table>
</div>
{/block}
