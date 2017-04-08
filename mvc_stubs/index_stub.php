<div class="head_face" id="title">{ClassName}</div>
<div class="container_16">
	<div class="grid_1 alpha">&nbsp;</div>
	<div class="grid_14">
		<div id="search_container">
			<div class="grid_3 grid_left alpha" id="control_area">
				<input type="text" id="search" class="search" title="Enter search terms" autocomplete="off">
			</div>
			<div class="grid_1"></div>
			<div class="grid_3"><button class="wide_button" id="button_add_member">Add New {ClassName}</button></div>
			<div class="grid_3 grid_right found"><input type="checkbox" id="show_all"> Show All &nbsp;&nbsp;&nbsp;<span id="found"></span></div>
		</div>
		<div class="clear"></div>
		<!-- List loads into list_container via AJAX -->
		<div class="grid_14 alpha" id="list_container"></div>
	</div>
	<div class="grid_1">&nbsp;</div>
</div>
<iframe id="{ClassNameToLower}_detail_frame" src="" scrolling="auto"></iframe> 