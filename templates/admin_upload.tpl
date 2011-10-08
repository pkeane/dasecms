{extends file="layout.tpl"}

{block name="main"}
<div>
	<h1>Admin Uploader</h1>
	<form action="admin/upload/files" method="post" enctype="multipart/form-data">
		<p>
		<label for="uploaded_file">select a file</label>
		<input type="file" name="uploaded_file"/>
		<input type="submit" value="upload"/>
		</p>
	</form>

	<h3>Uploaded Files:</h3>
	<table class="uploads">
		<tr>
			<th></th>
			<th>system url</th>
			<th>name</th>
			<th>mime type</th>
			<th>size</th>
			<th>W x H</th>
			<th>created</th>
			<th>created by</th>
			<th>edit</th>
		</tr>
		{foreach item=file from=$files}
		<tr>
			<td class="thumb">
				<a href="node/{$file->id}/edit"><img src="{$file->thumbnail_url}"></a>
			</td>
			<td>
				<a href="node/{$file->id}">node/{$file->id}</a>
			</td>
			<td>
				<a href="node/{$file->name}">{$file->name}</a>
			</td>
			<td>
				{$file->mime}
			</td>
			<td>
				{$file->size}
			</td>
			<td>
				{if $file->width && $file->height}
				{$file->width}x{$file->height}
				{else}
				N/A
				{/if}
			</td>
			<td>
				{$file->created|date_format:'%Y-%m-%d %H:%M'}
			</td>
			<td>
				{$file->created_by}
			</td>
			<td>
				<a href="node/{$file->id}/edit">edit</a>
			</td>
		</tr>
		{/foreach}
	</table>


</div>
{/block}
