<div class="container_12">  
	<div class="grid_12" id="header_panel">
		<h1 class="head_face">{$app_name}</h1>	
	</div>
	<div class="clear"></div>  
	<div class="grid_12 head_face"  id="nav_panel">
		<ul class="grid_10" id="nav">
{foreach from=$menu_array key=title item=link}
			<li><a href="{$link}">{$title}&nbsp;&nbsp;</a></li>
{/foreach}
		</ul>
		<div id="logged_in" class="grid_1 grid_right">Logged in: {$user_full_name}</div>
	</div>
	<div class="clear"></div>  
