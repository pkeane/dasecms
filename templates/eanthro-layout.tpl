<!doctype html>
<html lang="en">
	<head>
		<base href="{$app_root}">
		<meta charset="utf-8">
		<title>eAnthro Community Lab</title>

		<link rel="stylesheet" type="text/css" href="www/css/eanthro/text.css" /> 
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.1/build/reset/reset-min.css">
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
			<div class="login">
				{if $user}
				<li id="logoff"><a href="login" class="delete">logoff {$user->eid}</a></li>
				{/if}
			</div>
			<div class="clear">&nbsp;</div>
			<a href="{$app_root}"><img title="eAnthro" src="node/logo_eanthro_header.png"/></a>
			<div class="nav">
				<ul>
					{if $user}
					<li><a href="exercise/footprints/data_sets">Contribute Data</a></li>
					{else}
					<li><a href="exercise/footprints/google_login">Contribute Data</a></li>
					{/if}
					<li><a href="exercise/footprints/graph">View Data Graph</a></li>
				</ul>
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
					<li><a href="http://www.utexas.edu/cola/depts/anthropology/"><img src="www/images/footer_anthropology_link.png"></a></li>
					<li><a href="http://www.utexas.edu/cola/information-technology/"><img src="www/images/footer_laits_link.png"></a></li>
					<li><a href="http://www.utexas.edu/"><img src="www/images/footer_utexas_link.png"></a></li>
				</ul>
			</div>
			<div>
				<!--
				<h2>Learn about the e-Fossils project</h2>
				-->
				<p>
				<strong>eAnthro Labs</strong> is
				an interactive environment in which
				participants can upload their own data
				to explore a hypothesis. If you have
				any problems using this site or have any
				questions, please feel free to contact
				us. Funding for eAnthro.org/Labs is
				provided by the Longhorn Innovation Fund
				for Technology (LIFT) Award from the
				Research &amp; Educational Technology
				Committee (R&amp;E) of the IT governance
				structure at The University of Texas
				at Austin.
				</p>
			</div>
			<div class="last_footer_section">
				<h2>e-Anthro Digital Libraries List</h2>
				<ul class="footer_images">
					<li><a href=""><img src="www/images/footer_eanthro_link.png"/></a></li>
					<li><a href=""><img src="www/images/footer_eforensics_link.png"/></a></li>
					<li><a href="http://www.efossils.org"><img src="www/images/footer_efossils_link.png"/></a></li>
					<li><a href="http://www.elucy.org"><img src="www/images/footer_elucy_link.png"/></a></li>
					<li><a href="http://www.eskeletons.org"><img src="www/images/footer_eskeletons_link.png"/></a></li>
				</ul>
			</div>
		</div> <!-- end footer -->

	</body>
</html>
