{extends file="pages/trackways.tpl"}

{block name="head-scripts"}
	<script src="www/js/cross.js"></script>
	<script src="www/js/front.js"></script>
{/block}


{block name="inner-header"}
<img class="default_banner" src="node/{$node->name}" style="background: url(node/{$node->alt_banner->name});"/>
{/block}
