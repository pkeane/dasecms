{extends file="pages/trackways.tpl"}

{block name="head-scripts"}
<script src="www/js/instructions.js"></script>
{/block}


{block name="inner-content"}
<div class="generic_content">
	<p>
	{$node->body}
	</p>
	<div class="instructions_container clearfix">
		<div class="step_thumbnails">
			<ul>
				{foreach item=snode from=$node->steps_thumb.items}

				<li class="step{$snode->step} {if $snode->step == 1}selected{/if}"><img src="file/{$snode->id}"/></li>

				{/foreach}
			</ul>
		</div>
		<div class="step_viewer">
			{foreach item=snode from=$node->steps_full.items}
			<div class="step{$snode->step} {if $snode->step == 1}selected{/if}">
				<h1>{$snode->title}: </h1>
				<p>{$snode->body}</p>
				<img src="file/{$snode->id}"/>
			</div>
			{/foreach}
		</div> <!-- close step_viewer -->
	</div> <!-- close instructions -->
</div>
{/block}
