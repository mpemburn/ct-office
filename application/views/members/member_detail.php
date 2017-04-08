<div id="detail_title">{$member_info.member_name}</div>

<div id="member_tabs">
	<!-- the tabs -->
	<ul class="tabs">
		<li id="tab_general"><a href="#general">General</a></li>
		<li id="tab_purchases"><a href="#notes">Notes</a></li>
		<li id="tab_purchases"><a href="#purchases">Purchases</a></li>
		<li id="tab_history"><a href="#history">History</a></li>
	</ul>
	
	<!-- tab "panes" -->
	<div class="panes">
		<div class="pane" id="general">
			<iframe class="tab_frame" src="{$member_display_url}" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="notes">
			<iframe class="tab_frame" src="{$member_notes_url}" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="purchases">
			<iframe class="tab_frame" src="{$member_purchasing_url}" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="history">
			<iframe class="tab_frame" src="{$member_history_url}" frameBorder="0"></iframe>
		</div>
	</div>	
</div>
