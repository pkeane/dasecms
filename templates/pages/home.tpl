{extends file="labs_layout.tpl"}

{block name="content"}
<div id="home-content">
	<div id="banners">
		<img id="front" src="file/{$node->front_banner->id}">
		<img class="hide" id="tw" src="file/{$node->trackways_banner->id}">
		<img class="hide" id="tm" src="file/{$node->tempmigrations_banner->id}">
		<img class="hide" id="id" src="file/{$node->idea_banner->id}">
	</div>

	<ul id="lab_selector">
		<li class="tw" >
		<h4>{$node->trackways_thumb->title}</h4>
		<a href="page/trackways/front"><img src="file/{$node->trackways_thumb->id}"></a>
		</li>
		<li class="tm" >
		<h4>{$node->tempmigrations_thumb->title}</h4>
		<a href="page/tempmigrations"><img src="file/{$node->tempmigrations_thumb->id}"></a>
		</li>
		<li class="id" >
		<h4>{$node->idea_thumb->title}</h4>
		<a href="page/idea"><img src="file/{$node->idea_thumb->id}"></a>
		</li>
	</ul>
</div>
{/block}
