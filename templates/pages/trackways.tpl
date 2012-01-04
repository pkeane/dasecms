{extends file="labs_layout.tpl"}

{block name="content"}
<div id="trackways-menu">
	<ul>
		<li {if $node->alias == 'trackways/front'}class="active"{/if}>
		<a href="page/trackways/front">Lab Home</a>
		</li>
		<li {if $node->alias == 'trackways/instructions'}class="active"{/if}>
		<a href="page/trackways/instructions">Instructions</a>
		</li>
		<li {if $node->alias == 'trackways/add_data'}class="active"{/if}>
		<a href="page/trackways/add_data">My Data Sets</a>
		</li>
		<li {if $node->alias == 'trackways/visualize_data'}class="active"{/if}>
		<a href="page/trackways/visualize_data">Graph Results</a>
		</li>
		<li {if $node->alias == 'trackways/about_the_math'}class="active"{/if}>
		<a href="page/trackways/about_the_math">About the Math</a>
		</li>
		<li {if $node->alias == 'trackways/your_trackways'}class="active"{/if}>
		<a href="page/trackways/your_trackways">Your Trackways</a>
		</li>
	</ul>
<div class="clear"></div>
</div>
{block name="inner-header"}
<div class="content_header">
	<h1>Trackways Exercise <em>On the Track of Prehistoric Humans</em></h1>
</div>
{/block}

<div class="inner-content">
{block name="inner-content"}
<div class="text-content">
	{$node->body|markdown}
</div>
{/block}
</div>
<div class="clear"></div>
{/block}
