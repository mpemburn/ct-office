<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		
		<title>jQuery.popover demo page</title>
		<link rel="stylesheet" href="../../css/_page.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../css/popover/popover.css" type="text/css" media="screen" />
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="../../js/jquery.popover-1.0.8.js"></script>
		<script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function($) {
				$("#ex1").popover({
					trigger: 'click'
				});
				$("#ex2").popover({
					title: "Hello",
					content: "Finally, I can speak!"
				});
				$("#ex3a").popover({
					title: "<_<",
					content: "Damn.",
					trigger: 'none'
				});
				$("#ex3b").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex3a").popover('show');
				});
				$("#bubble_expl").popover({
					title: "Bubble up",
					content: "When you click a link on a web page, not only do you click that link, you also click it's parent. You clicked this linked, but also it's parent &lt;p&gt;-tag, and it's parent the &lt;body&gt;-tag and, it's parent the &lt;html&gt;-tag. The popover('hide') event is bound to the &lt;html&gt;-element, so this will trigger as well, causing the popover to fade out immediately. By using the stopPropagation() method we prevent this.",
					classes: 'large'
				});
				$("#ex4a").popover({
					title: "Guess what this is...",
					content: "Pa's wijze lynx bezag vroom het fikse aquaduct.",
					trigger: 'none'
				});
				$("#ex4b").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex4a").popover('show');
				});
				$("#ex4c").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex4a").popover('hide');
				});
				$("#ex4d").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex4a").popover('fadeOut');
				});
				$("#ex4e").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex4a")
						.popover('destroy')
						.text("Nooo! What have you done?!");
				});
				$("#ex5a").popover({
					title: "Hmm...",
					content: "And programming is your friendship!"
				});
				$("#ex5b, #ex5c").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex5a").popover(
						'title',
						$(this).text()+" is your friend"
					).popover('show');
				});
				$("#ex6a").popover({
					title: "Dynamic content",
					content: "At least a popover that makes some sense..."
				});
				$("#ex6b").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex6a").popover(
						'content',
						"At least a popover that makes some sense... Don't get used to it."
					).popover('show');
				});
				$("#ex7a").popover({
					title: "What's this",
					content: "...",
					classes: "wider"
				});
				$("#ex7b").click(function(event) {
					event.preventDefault();
					event.stopPropagation();
					$("#ex7a").popover(
						'ajax',
						"ajax.html"
					).popover('title', "It's AJAX content!").popover('show');
				});
				
				/**
				 * Collapse code blocks
				 */
				var code_min_height = 150;
				$('pre').each(function() {
					$this = $(this);
					var org_height = $this.height();
					var toggld = false;
					if(org_height > code_min_height)
						$this.height(code_min_height);
					$this.bind('click', function() {
						$this = $(this);
						if(toggld) {
							$this.stop(true, true).animate({ height: code_min_height });
							toggld = false;
						} else {
							$this.stop(true, true).animate({ height: org_height });
							toggld = true;
						}
					})
				});
				
				/**
				 * Table of contents
				 */
				toc_paragraph = function(p) {
					var ret = $('<li><a href="'+p.href+'">'+p.title+'</a></li>');
					$.each(p.items, function(i, val) {
						if(ret.children('ul').length === 0)
							ret.append('<ul />');
						ret.children('ul').append(toc_paragraph(val));
					});
					return ret;
				}
				generate_toc = function() {
					var toc = {};
					var toc_el = $('#table_of_contents');
					$('a[name]').each(function() {
						$this = $(this);
						var item = {};
						var name = $this.attr('name');
						var href = "#" + name;
						var title = $this.attr('title');
						if(typeof title === "undefined")
							title = $this.next().text();
						item.href = href;
						item.title = title;
						item.items = {};
						
						var split = $this.attr('name').split('_');
						if(split.length > 1)
							toc[split[0]].items[name] = item;
						else
							toc[name] = item;
					});
					toc_el.empty();
					
					$.each(toc, function(i, val) {
						toc_el.append(toc_paragraph(val));
					});
				}
				generate_toc();
			});
		/* ]]> */
		</script>
	</head>
	<body>
		<h1>jQuery.popover</h1>
		<p>Easy to use and customizable popover plugin for jQuery.</p>
		<p>Take a look at <a href="http://wp.me/p12l3P-gT">this blog post</a> for more details.</p>
		
		<a name="toc"></a>
		<h2>Table of Contents</h2>
		<ul id="table_of_contents"></ul>
		
		<a name="usage"></a>
		<h2>Usage</h2>
		
		<a name="usage_initialization"></a>
		<h3>Initialization</h3>
		<p>With default settings, calling $(element).popover(); will initalize an empty popover on the element.</p>
		
		<div class="sandbox">
			<a href="#" id="ex1">I have a popover, but you can't see me. Yet.</a>
		</div>
		
		<p>When you click the link above, the popover is shown. This is achieved by using <code>{ trigger: 'click' }</code> in the parameters. <em>You can hide the popover by clicking anywhere there's not a popover.</em> The source code for the above example is:</p>
		<pre><code>$("#ex1").popover({
	trigger: 'click'
});</code></pre>
		<p>When this code was executed, the popover was created but not shown. A <code>click</code> event was bound to the <code>a</code>-tag with which the popover is &#147;connected&#148;. When that element is clicked, the popover is shown.
			
		<p>But hows an empty popover any fun? Let's try this:</p>
		
		<div class="sandbox">
			<a href="#" id="ex2">Please, let me speak!</a>
		</div>
		
		<p>Now we've put some content in our popover using the parameters <code>{ title: &quot;Hello&quot;, content: &quot;Finally, I can speak!&quot; }</code>, like so:</p>
		
		<pre><code>$(&quot;#ex2&quot;).popover({
	title: &quot;Hello&quot;,
	content: &quot;Finally, I can speak!&quot;
});</code></pre>
		
		<p>Note that I've ommited <code>{ trigger: 'click' }</code> in this example. It's the default setting for popovers.</p>
		
		<a name="usage_manual"></a>
		<h3>Pulling the trigger manually</h3>
		<p>You can show, hide and fade out an initialized popover manually by calling <code>popover('show')</code>, <code>popover('hide')</code> and <code>popover('fadeOut')</code> on the element the popover was initialized over.</p>
		
		<div class="sandbox">
			<span id="ex3a">Nope, can't be triggered, bro.</span>
			<a href="#" id="ex3b">Oh yes you can!</a>
		</div>
		
		<p>The code for this example is as follows. <em>Click a code box to expand it.</em></p>
		
		<pre><code>$(&quot;#ex3a&quot;).popover({
	title: &quot;&amp;lt;_&amp;lt;&quot;,
	content: &quot;Damn.&quot;,
	trigger: 'none'
});
$(&quot;#ex3b&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex3a&quot;).popover('show');
});</code></pre>
		
		<p>You must must call <code>event.preventDefault()</code> and <code>event. stopPropagation()</code> on the triggeree (?) / element that triggers the popover, otherwise <code>click</code>-event will <a href="#" id="bubble_expl">bubble up</a> to the document and the popover will immediately be hidden.</p>
		<p>You can call <code>popover('fadeOut')</code> and <code>popover('hide')</code> to hide popovers with and without a fade animation.</p>
		
		<a name="usage_hiding"></a>
		<h3>Hide and destroy</h3>
		<p>Use <code>popover('hide')</code>, <code>popover('fadeOut')</code> and <code>popover('destory')</code> to hide, fade out and destroy popovers. Call these methods on the element where the popover was initialized over.</p>
		
		<div class="sandbox">
			<span id="ex4a">I have a popover.</span><br />
			<a href="#" id="ex4b">Show</a> | <a href="#" id="ex4c">Hide</a> | <a href="#" id="ex4d">Fade out</a> | <a href="#" id="ex4e">Destroy</a> 
		</div>
		
		<p>These methods can be seen as the <abbr title="Application Programming Interface">API</abbr> for jQuery.popover. Here the code for this example:</p>
		
		<pre><code>$(&quot;#ex4a&quot;).popover({
	title: &quot;Guess what this is...&quot;,
	content: &quot;Pa's wijze lynx bezag vroom het fikse aquaduct.&quot;,
	trigger: 'none'
});
$(&quot;#ex4b&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex4a&quot;).popover('show');
});
$(&quot;#ex4c&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex4a&quot;).popover('hide');
});
$(&quot;#ex4d&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex4a&quot;).popover('fadeOut');
});
$(&quot;#ex4e&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex4a&quot;)
		.popover('destroy')
		.text(&quot;Nooo! What have you done?!&quot;);
});</code></pre>
		
		<p>It could probably be a bit shorter, but I'll let you figure that out.</p>
		
		<a name="usage_modifying"></a>
		<h3>Modifying on the fly</h3>
		
		<a name="usage_modifying_title"></a>
		<h4>Title</h4>
		<p>You can change the title on the fly with by using <code>popover('title', "Text")</code>.</p>
		
		<div class="sandbox">
			<span id="ex5a">PHP or Ruby?</span>
			<a href="#" id="ex5b">PHP</a> | <a href="#" id="ex5c">Ruby</a>
		</div>
		
		<pre><code>$("#ex5a").popover({
	title: "Hmm...",
});
$("#ex5b, #ex5c").click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$("#ex5a").popover(
		'title',
		$(this).text()+" is your friend"
	).popover('show');
});</code></pre>

		<a name="usage_modifying_content"></a>
		<h4>Content</h4>
		<p>You can change the title on the fly with by using <code>popover('content', "Text")</code>.</p>
		
		<div class="sandbox">
			<span id="ex6a">Click here first | </span>
			<a href="#" id="ex6b">change content</a>
		</div>
		
		<pre><code>$(&quot;#ex6a&quot;).popover({
	title: &quot;Dynamic content&quot;,
	content: &quot;At least a popover that makes some sense...&quot;
});
$(&quot;#ex6b&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex6a&quot;).popover(
		'content',
		&quot;At least a popover that makes some sense... Don't get used to it.&quot;
	).popover('show');
});</code></pre>

		<a name="usage_modifying_ajax"></a>
		<h4>Loading AJAX content</h4>
		<p>You can load a webpage as content via AJAX by using <code>popover('ajax', "http://example.com/" [, options])</code>.</p>
		
		<div class="sandbox">
			<span id="ex7a">Click here first | </span>
			<a href="#" id="ex7b">load ajax content</a>
		</div>
		
		<p>Please note this only works when running on a webserver.</p>
		
		<pre><code>$(&quot;#ex7a&quot;).popover({
	title: &quot;What's this&quot;,
	content: &quot;...&quot;,
	classes: &quot;wider&quot;
&quot;);
$(&quot;#ex7b&quot;).click(function(event) {
	event.preventDefault();
	event.stopPropagation();
	$(&quot;#ex7a&quot;).popover(
		'ajax',
		&quot;ajax.html&quot;
	).popover('title', &quot;It's AJAX content!&quot;).popover('show');
&quot;);</code></pre>
		
		<p>Alternatively, you can set an URL in the initialization parameters to load an URL immediately on setup, like so:</p>
		
		<pre><code>$(&quot;#selector&quot;).popover({
	url: &quot;test.html&quot;
	);</code></pre>
		
		<a name="parameters"></a>
		<h3>Parameters</h3>
		<p>You may've noticed the <code>{ classes: "wider" }</code> parameter in the previous example. The value of the <code>classes</code>-parameter is applied to the popover by jQuery's <code>addClass()</code> method. You can use this to add classes for different sizes of popovers.</p>
		
		<p>There are other parameters you can pass to the <code>popover()</code> method. Following is a list of them.</p>
		
		<table>
			<thead>
				<tr>
					<th>Option</th>
					<th>Preffered type</th>
					<th>Description</th>
					<th>Default</th>
					<th>Since</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>verticalOffset</td>
					<td>int</td>
					<td><a name="parameters_verticalOffset" title="verticalOffset"></a>Offset the popover by y px vertically (movement depends on position of popover. If <code>position == 'bottom'</code>, positive numbers are down)</td>
					<td><code>10</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>horizontalOffset</td>
					<td>int</td>
					<td><a name="parameters_horizontalOffset" title="horizontalOffset"></a>Offset the popover by x px horizontally (movement depends on position of popover. If <code>position == 'right'</code>, positive numbers are right)</td>
					<td><code>10</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>title</td>
					<td>bool|string</td>
					<td><a name="parameters_title" title="title"></a>Contents of the heading. Set to false for no title.</td>
					<td><code>false</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>content</td>
					<td>bool|string</td>
					<td><a name="parameters_content" title="content"></a>Contents of the body of the popover. Set to false for no body.</td>
					<td><code>false</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>url</td>
					<td>bool|string</td>
					<td><a name="parameters_url" title="url"></a>Automatically load an URL into the content field on initialization, if set to an url.</td>
					<td><code>false</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>classes</td>
					<td>string</td>
					<td><a name="parameters_classes" title="classes"></a>Add stylesheet classes to the popover box on initalization, for example "large".</td>
					<td><code>&quot;&quot;</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>position</td>
					<td>string</td>
					<td><a name="parameters_position" title="position"></a>Determine place of the popover. Set to &quot;auto&quot; for automatic placement. <em>Yet to be implemented</em></td>
					<td><code>&quot;auto&quot;</code></td>
					<td>-</td>
				</tr>
				<tr>
					<td>fadeSpeed</td>
					<td>int</td>
					<td><a name="parameters_fadeSpeed" title="fadeSpeed"></a>How fast to fade this popover out when fading out.</td>
					<td><code>160</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>trigger</td>
					<td>string</td>
					<td><a name="parameters_trigger" title="trigger"></a>How to trigger the popover. &quot;click&quot; activates the popover when the linked-to element is clicked, &quot;hover&quot; when it's hovered on, &quot;focus&quot; shows it when focused and hides the popover when unfocused/blurred, and everything else sets it to manual.</td>
					<td><code>&quot;click&quot;</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>preventDefault</td>
					<td>bool</td>
					<td><a name="parameters_preventDefault" title="preventDefault"></a>Execute <code>event.preventDefault()</code> method on the element the popover is called on. Set this to false if you want the element (for example an <code>a</code>-element) to still execute code already bound with <code>.click()</code>.</td>
					<td><code>true</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>stopChildrenPropagation</td>
					<td>bool</td>
					<td><a name="parameters_stopChildrenPropagation" title="stopChildrenPropagation"></a>Execute <code>event.preventPropagation()</code> method on all children of the popover, so <code>click</code> events won't bubble up and hide the popover.</td>
					<td><code>true</code></td>
					<td>v1.0.5</td>
				</tr>
				<tr>
					<td>hideOnHTMLClick</td>
					<td>bool</td>
					<td><a name="parameters_hideOnHTMLClick" title="hideOnHTMLClick"></a>Hide all popovers when clicked outside of them.</td>
					<td><code>true</code></td>
					<td>v1.0.0</td>
				</tr>
				<tr>
					<td>animateChange</td>
					<td>bool</td>
					<td><a name="parameters_animateChange" title="animateChange"></a>Animate a popover reposition. <em>Yet to be implemented.</em></td>
					<td><code>true</code></td>
					<td>v1.0.8</td>
				</tr>
				<tr>
					<td>autoReposition</td>
					<td>bool</td>
					<td><a name="parameters_autoReposition" title="autoReposition"></a>Automatically reposition popover on popover change and window resize.</td>
					<td><code>true</code></td>
					<td>v1.0.8</td>
				</tr>
				<tr>
					<td>anchor</td>
					<td>bool|string|jQuery</td>
					<td><a name="parameters_anchor" title="anchor"></a>Use this parameter to anchor the popover to a different element than it's invoked on. This is useful when using <code>{ trigger: 'hover' }</code>.</td>
					<td><code>false</code></td>
					<td>v1.0.2</td>
				</tr>
			</tbody>
		</table>
		
		<a name="parameters_prototype" title="Default prototype"></a>
		<p>For convienience, here is this plugin's defaults prototype.</p>
		
		<pre><code>var defaults = {
	verticalOffset: 10,
		horizontalOffset: 10,
		title: false,
		content: false,
		url: false,
		classes: '',
		position: 'auto',
		fadeSpeed: 160,
		trigger: 'click',
		preventDefault: true,
		stopChildrenPropagation: true,
		hideOnHTMLClick: true,
		animateChange: true,
		autoReposition: true,
		anchor: false
}</code></pre>
		
		<a name="methods"></a>
		<h3>Methods</h3>
		
		<p>Following is a reference of all methods you can call. Every method returns a jQuery result set, to maintain chainability.</p>
		
		<table>
			<thead>
				<tr>
					<th>Method</th>
					<th>Returns</th>
					<th>Description</th>
					<th>Usage</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>init</td>
					<td>jQuery</td>
					<td><a name="methods_init" title="init"></a>(default method) Initializes a popover on elements. Reads defaults (see above), combines them with parameters and makes and links the popover.</td>
					<td><code>$("#selector").popover(["init", ] { title: "Test" });</code></td>
				</tr>
				<tr>
					<td>destroy</td>
					<td>jQuery</td>
					<td><a name="methods_destroy" title="destroy"></a>Removes the linked popover(s) from the DOM, as well as it's data/settings.</td>
					<td><code>$("#selector").popover('destroy');</code></td>
				</tr>
				<tr>
					<td>show</td>
					<td>jQuery</td>
					<td><a name="methods_show" title="show"></a>Show a linked popover, if it exists.</td>
					<td><code>$("#selector").popover('show');</code></td>
				</tr>
				<tr>
					<td>hide</td>
					<td>jQuery</td>
					<td><a name="methods_hide" title="hide"></a>Hide a linked popover, if it exists.</td>
					<td><code>$("#selector").popover('hide');</code></td>
				</tr>
				<tr>
					<td>fadeOut</td>
					<td>jQuery</td>
					<td><a name="methods_fadeOut" title="fadeOut"></a>Fade out a linked popover, if it exists, in as many milliseconds you set the fadeSpeed parameter to on initialization, or how many as you passed to the method.</td>
					<td><code>$("#selector").popover('fadeOut' [, 1000]);</code></td>
				</tr>
				<tr>
					<td>hideAll</td>
					<td>jQuery</td>
					<td><a name="methods_hideAll" title="hideAll"></a>Hide all initialized popovers.</td>
					<td><code>$("#selector").popover('hideAll');</code></td>
				</tr>
				<tr>
					<td>fadeOutAll</td>
					<td>jQuery</td>
					<td><a name="methods_fadeOutAll" title="fadeOutAll"></a>Fade out all initialized popovers. The duration is set by using the parameter <code>fadeSpeed</code> when initiaizing, or passing this to the method.</td>
					<td><code>$("#selector").popover('fadeOutAll' [, 1000]);</code></td>
				</tr>
				<tr>
					<td>setTrigger</td>
					<td>jQuery</td>
					<td><a name="methods_setTrigger" title="setTrigger"></a>Sets a popover's trigger method (see <a href="#parameters_trigger">this</a> for information on triggers). Also unbinds the previous trigger(s).</td>
					<td><code>$("#selector").popover('setTrigger', 'hover');</code></td>
				</tr>
				<tr>
					<td>setOption</td>
					<td>jQuery</td>
					<td><a name="methods_setOption" title="setOption"></a>Sets an option to the specified value.</td>
					<td><code>$("#selector").popover('setOption', 'fadeSpeed', 500);</code></td>
				</tr>
				<tr>
					<td>getOption</td>
					<td>mixed</td>
					<td><a name="methods_getData" title="getData"></a>Get a popover's data. If multiple elements are targeted, the function returns an array of objects.</td>
					<td><code>$("#selector").popover('getData');</code></td>
				</tr>
			</tbody>
		</table>
		
		<a name="download"></a>
		<h3>Download</h3>
		
		<p>You can download jQuery.popover by cloning it from Github:</p>
		
		<p><code>git clone git@github.com:klaas4/jQuery.popover.git</code></p>
		
		<p>Or simply download the <a href="https://github.com/klaas4/jQuery.popover/zipball/master">zip-package</a>.</p>
		
		<p>Please also check out my blog at <a href="http://daveyyzermans.nl/">http://daveyyzermans.nl/</a>, and if you want, shoot me an e-mail.</p>
	</body>
</html>