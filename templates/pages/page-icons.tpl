{extends file="eanthro-layout.tpl"}

{block name="content"}
<h1>{$node->title}</h1>
<ul>
	{foreach item=subnode from=$node->attachments.icons.items}
	<li><img src="{$subnode->thumbnail_url}"></li>
	{/foreach}
</ul>
{if $is_image}
<img src="node/{$node->name}">
{/if}
{/block}
