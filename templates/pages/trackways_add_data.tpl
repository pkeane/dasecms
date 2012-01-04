{extends file="pages/trackways.tpl"}

{block name="inner-content"}
<div class="section">
<h1>{$node->title}</h1>
<p>
{$node->body|markdown}
<h3>{$request->user->eid} data sets</h3>
<ul>
	{foreach item=set from=$data_sets}
	<li><a href="page/trackways/data_set/{$set->id}">{$set->name}</a></li>
	{/foreach}
</ul>
<form method="post" action="datasets/{$request->user->eid}">
	<input type="text" name="name">
	<input type="submit" value="add data set">
</form>
</p>
</div>
{/block}
