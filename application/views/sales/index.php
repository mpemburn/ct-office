<div class="head_face" id="title">Sales Force Tool Kit</div>
<div id="container">
	<div id="vspace"></div>
	<div class="container_12">
		<div class="grid_5"></div>
		<br /><br /><br />
		<div class="container_12 grid_12" align="center"><a href="#"><button class="big" id="new_contract">New Contract</button></a></div>
		<div id="contract_links">
			<ul>
{foreach $contract_links as $value}
				<a href="{$value}"><li>{$value@key}</li></a>
{/foreach}
			</ul>
		</div>
	</div>
</div>
