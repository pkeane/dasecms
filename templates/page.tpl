{extends file="layout.tpl"}

{block name="main"}
<h1>{$node->title}</h1>
<p>
{$node->body}
</p>
{if $is_image}
<img src="node/{$node->name}">
{/if}
{/block}
