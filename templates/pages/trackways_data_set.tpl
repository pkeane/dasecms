{extends file="pages/trackways.tpl"}

{block name="inner-content"}
<div class="section">
<h1>{$node->title}: {$data_set->name}</h1>
<!--
<p>
{$node->body|markdown}
</p>
-->
	<h1>Enter Data</h1>
	<form id="data_form" action="dataset/{$data_set->id}" method="post">
		<table class="data_form">
			<tr>
				<th>Gender</th>
				<th class="age">Age</th>
				<th>Foot Length (cm)</th>
				<th>Height (cm)</th>
				<th>Stride Length (cm)</th>
				<th></th>
			</tr>
			<tr>
				<th class="gender">
					<input type="radio" name="gender" value="female"><span class="radiolabel">F</span> 
					<input type="radio" name="gender" value="male"><span class="radiolabel">M </span>
				</th>
				<th class="age">
					<input type="text" name="age"> 
				</th>
				<th>
					<input type="text" name="foot_length"> 
				</th>
				<th>
					<input type="text" name="height"> 
				</th>
				<th>
					<input type="text" name="stride_length"> 
				</th>
				<th>
					<input type="submit" value="submit!"> 
				</th>
			</tr>
			{foreach item=pd from=$data_set->person_datas name=pk}
			<tr {if 0 == $smarty.foreach.pk.iteration%2}class="even"{/if}>
			<td>{$pd->gender}</td>
			<td>{$pd->age}</td>
			<td>{$pd->foot_length} cm</td>
			<td>{$pd->height} cm</td>
			<td>{$pd->stride_length} cm</td>
			<td></td>
		</tr>
			{/foreach}
		</table>
	</form>
	<!--
	<div id="data_table"></div>
	-->
</div>
{/block}
