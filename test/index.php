<?php
// ************ MULTIPLE IMAGE INDEX PAGE *****************
// This will generate the list of pages.
// You add a line for each page that corresponds to the single
// image pages already created.
// So create all your single image pages first, then add them all here.

// enter in the project name: (example: ecomyths, estv, etc)
$project = "Marquis Energy";

// enter in each page as a name/link pair.
// $pages[] = array('January 1. 2014', 'Revision 1', 'r1'); in that example, the name is Home Page, the the actual file is home.php
$pages   = array();
$pages[] = array('August 18, 2015', '"Our Advantage" Image Direction, v1', 'our-advantage/r1');
$pages[] = array('August 18, 2015', 'Interior Pages, v1', 'interior-pages/r1');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $project; ?></title>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<link href="css/reset.css" rel="stylesheet" type="text/css">
		<link href="css/cj-styles.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="navigation">
			<div class="container">
				<a href="http://colorjar.com" data-rel="#header">
					<div class="logo"></div>
				</a>
			</div>
		</div>

		<div id="content">

			<div class="section_header">
				<div id="designs_header">
					<h2>Check it Out</h2>
					<p>Our work. With love. From us to you.</p>
				</div>
			</div>

			<div class="container">
				<h2><?php echo "PROJECT NAME: " . $project; ?></h2>
<?php /*
        <div class="project-meta">
          <h3><?php echo "Revision: " . $revision; ?></h3>
          <h3><?php echo "Date: " . $date; ?></h3>
        </div>
*/ ?>
				<ul>
					<?php
					foreach ($pages as $page) {
					    echo "\t\t\t<li><a href=\"" . $page[2] . "/index.php\">" . $page[1] . " - " . $page[0] . "</a></li>\r";
					} ?>
				</ul>
      </div>

		</div>
	</body>
</html>
