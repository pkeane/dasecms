<!doctype html>
<html lang="en">
	<head>
		<base href="{$app_root}">
		<meta charset="utf-8">
		<meta name="template" content="{$smarty.template}">
		<title>eAnthro Community Lab</title>

		<link rel="stylesheet" type="text/css" href="www/css/eanthro/base.css" /> 
		<link rel="stylesheet" type="text/css" href="www/css/eanthro/style.css" /> 
		{block name="head-links"}{/block}
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
		<!--
		<script src="www/js/jquery.js"></script>
		<script src="www/js/jquery-ui.js"></script>
		-->
		<script src="www/js/script.js"></script>
		{block name="head-scripts"}{/block}

	</head>
	<body>
		<div id="ajaxMsg" class="hide">Loading...</div>
		<div class="header">
			<a href="page/home"><img title="eAnthro" src="file/{$site->header_image->id}"/></a>
			<div id="login" class="login">
				{if $request->user}
				<a href="login" class="delete">logoff {$request->user->eid}</a>
				{if $request->user->is_admin} |
				<a href="nodes">eAnthro CMS</a> |
				<a href="node/{$node->id}">view node</a>
				{/if}
				{/if}
			</div>
		</div>
		<div id="container">
			<div id="content">
				{if $msg}<h3 class="msg">{$msg}</h3>{/if}
				{block name="content_header"}{/block}
				{block name="content"}default content{/block}
			</div> <!-- end content --> 
		</div>
		<div class="footer">
			<div class="first_footer_section">
				<ul>
					<li><h2><a href="faq">Frequently Asked Questions</a></h2></li>
					<li><h2><a href="credits">e-Fossils Production Credits</a></h2></li>
					{foreach item=subnode from=$site->left_footer_links.items}
					<li><a href="{$subnode->site_link}"><img src="file/{$subnode->id}"></a></li>
					{/foreach}
				</ul>
			</div>
			<div>
				<p>
				<h2>{$site->footer_text->title}</h2>
				{$site->footer_text->body}
				</p>
			</div>
			<div class="last_footer_section">
				<h2>e-Anthro Digital Libraries List</h2>
				<ul class="footer_images">

					{foreach item=subnode from=$site->footer_links.items}
					<li><a href="{$subnode->site_link}"><img src="file/{$subnode->id}"></a></li>
					{/foreach}
				</ul>
			</div>
		</div> <!-- end footer -->

	</body>
</html>
