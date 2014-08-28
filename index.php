<html>
<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="gsappcourses.js" type="text/javascript"></script>
	<link href="gsappcourses.css" type="text/css" rel="stylesheet" media="all" />
</head>

<?php $thisurl = $_SERVER['REQUEST_URI']; ?>
<?php
include("include/simple_html_dom.php");
if(!isset($_GET["url"]))  {
	$dataurl = null;
} else {
	$dataurl = $_GET["url"];
}
?>

	<body>
		<base target="_new">
		<?php if($dataurl) {
			?>
			<div id="sidebar" class=checkboxes>
				<b>Show courses with any dates on:</b>
				<form>
					<input type="checkbox" name="date-M" id="date-M" checked="checked" /><label for="date-M"> Monday</label><br>
					<input type="checkbox" name="date-Tu" id="date-Tu" checked="checked" /><label for="date-Tu"> Tuesday</label><br>
					<input type="checkbox" name="date-W" id="date-W" checked="checked" /><label for="date-W"> Wednesday</label><br>
					<input type="checkbox" name="date-Th" id="date-Th" checked="checked" /><label for="date-Th"> Thursday</label><br>
					<input type="checkbox" name="date-F" id="date-F" checked="checked" /><label for="date-F"> Friday</label><br>
				</form>
				<br>
				<form>
					<span>Hide rows instead of graying out</span><br>
					<input type="checkbox" name="grayouthide" checked="checked"/>
				</form>
			</div>
		<?php } ?>

		<div id="wrapper">
			<div id="header">
				<h2>Dan's GSAPP COURSE SCHEDULE PARSER - v0.0.4 (version "wow, this still works!") </h2>
				<h4><a href="https://github.com/provolot/gsappcourses">Github</a></h4>
				<form action="index.php" method="get">
					GSAPP course URL to scrape from (example: <a href="<?php print $thisurl; ?>?url=http://www.arch.columbia.edu/courses/course-schedule/spring">http://www.arch.columbia.edu/courses/course-schedule/spring)</a><br>
					<input class="dataurl" size=100 type="text" name="url" <?php if($dataurl) print "value='$dataurl'"; ?>>
					<input type="submit" value="Submit">
				</form>
			</div>
			<?php if($dataurl) {
//				print "<div class='dataurl'>" . $dataurl . "</div>";
			?>

			<div id="content" class="alltables">

				<?php 
				$html = file_get_html($dataurl);

				foreach($html->find('[class=mytable]') as $element)  
					echo $element . '<br>';
				?>
			</div>
		</div>
		<?php } ?>
		<div id="stylediv"></div>
	</body>
</html>

