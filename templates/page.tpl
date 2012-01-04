{extends file="labs_layout.tpl"}

{block name="content"}
<h1>{$node->title}</h1>
<p>
{$node->body|markdown}
</p>
{if $is_image}
<img src="node/{$node->name}">
{/if}
{/block}
