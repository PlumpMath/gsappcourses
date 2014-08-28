<html>
<head>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	var querybefore = "'http://search.columbia.edu/search?&q=";
	var queryafter = "&site=Directory_of_Classes&num=20&sort=date%3AD%3AL%3Ad1&filter=0&entqr=0&ud=1&output=xml_no_dtd&client=DoC&proxystylesheet=DoC&oe=UTF-8&ie=UTF-8&proxyreload=1'";
	var ourDiv = $(".mytable tr").each(function() {
		var thiscoursename = $(this).find("td:nth-child(2)");
		thiscoursename.html("<b>" + thiscoursename.html() + "</b>");


		var thiscourse = $(this).find("td:nth-child(9)");
		thiscourse.html("<a href=" + querybefore + thiscourse.html() + queryafter + ">" + thiscourse.html() + "</a>");
		
		var thistime = $(this).find("td:nth-child(6)");
		thistime.parent("tr").append(processTime(thistime.html()));

		if($(this).find(".datetally").length == 0) {
			$(this).addClass("nodate");
		}
	});

//	$(".mytable tr").click(function() {
//		$(this).toggleClass("grayout");
//	});
	$("input").click(function() {
			var datename = $(this).attr("name");
			var waschecked = this.checked;

			if((datename == "grayouthide")) {
				// hack to change the css of grayout
				// so that if new elements have grayout added, this css style also affects them
				if(waschecked) {
					$("#stylediv").html('<style>.grayout, .nodate { display:none; }</style>');
				} else {
					$("#stylediv").html('');
				}	
			} else {
				if(!waschecked) {
					// for each that's checked				
					// iterate through each row
					// subtract 1 from $("td.datetally")
					// if cell is zero, hide
					$(".mytable tr").each(function() {
						if($(this).find("td." + datename).length != 0) {
							var newtally = parseInt($(this).find("td.datetally").html()) - 1;
							$(this).find("td.datetally").html(newtally);
							if(newtally == 0)  { $(this).addClass("grayout"); }
						}
					});
				} else  {
					// show all the rows that have this date
					$(".mytable tr").each(function() {
						if($(this).find("td." + datename).length != 0) {
							var newtally = parseInt($(this).find("td.datetally").html()) + 1;
							$(this).find("td.datetally").html(newtally);
							if(newtally > 0)  { $(this).removeClass("grayout"); }
						}
					});
				}
			}
	});


});

function processTime(inpstr) {
	if (inpstr == null)
		return "";
	inpstr = inpstr.replace(/&nbsp;/g, '');
	if ( $.trim(inpstr) == '' )
		return "";

	times = inpstr.match(/[0-9|:]+[ ]*[a|p]m/g);
	if (times == null)
		return "";
	var processedtimes = [];
	$.each(times, function() {
		thisnum = this.match(/[0-9|:]*/);
		thisampm = this.match(/[a|p]m/);

		thishour = thisnum[0].split(":")[0]
		thismin =  thisnum[0].split(":")[1]

		thistimenum = parseInt(thishour);

		if(thisampm == "pm" && thistimenum != 12)
			thistimenum += 12;

		if(thismin != null) 
			thistimenum += (parseInt(thismin) / 60.0);

		//console.log("thistimenum = " + thistimenum);
		//console.log("hour = " + thishour + " min = " + thismin);
		processedtimes.push(thistimenum);
	});
//	console.log(processedtimes);

	// too hard to process weird lengths
	if(processedtimes.length != 2)
		return ""

	dates = inpstr.split(/[0-9]/)[0];
	dates = dates.split(/[\s,\/]+/)

	// date lookup table: monday = 1, tuesday = 2, etc
	var datelookup = {
		'M' : 1,
		'TU' : 2,
		'W' : 3,
		'TH' : 4,
		'F' : 5
	}
	var processeddates = [];
	$.each(dates, function() {

		//console.log("=========");
		//console.log(this)	;
		//console.log($.trim(this));	
		//console.log($.trim(this).toLowerCase());	
		if($.trim(this).toUpperCase() in datelookup) {
			processeddates.push(datelookup[$.trim(this).toUpperCase()]);
		}

	});
//	console.log(processeddates);

	if ( processeddates == null)
		return "";

// append html

	var AppendHtml = "";

// append dates

	AppendHtml += "<td class='noborder'></td>";

	for(var i = 1; i <= 5; i++) {
		thisdate = datelookup.getKeyByValue(i);
		if($.inArray(i, processeddates) != -1)
			AppendHtml += "<td class='date-" + thisdate + " noborder highlightdate'>" + thisdate + "</td>";
		else
			AppendHtml += "<td class='noborder'>" + thisdate + "</td>";
	}

// append times

	AppendHtml += "<td class='noborder'></td>";
	AppendHtml += "<td>" + times.join("--") + "</td>";
	AppendHtml += "<td class='noborder'></td>";

// 9 to 23 o clock
//	console.log("proctimes = " + processedtimes)
	for(var i = 9; i <= 23; i++) {
		if(processedtimes[0] <= i  &&  i < processedtimes[1])
			AppendHtml += "<td class='noborder highlighttime'>" + formatTimeShow(i) + "</td>";
		else
			AppendHtml += "<td class='noborder'>" + formatTimeShow(i) + "</td>";
	}

	AppendHtml += "<td class='noborder'></td>";
	//console.log(processeddates);
//	console.log(processeddates.length);

	AppendHtml += "<td class='noborder datetally'>" + processeddates.length + "</td>";
	return AppendHtml;
}

function formatTimeShow(h_24) {
    var h = h_24 % 12;
    if (h === 0) h = 12;
    return h + (h_24 < 12 ? 'am' : 'pm');
}

Object.prototype.getKeyByValue = function( value ) {
    for( var prop in this ) {
        if( this.hasOwnProperty( prop ) ) {
             if( this[ prop ] === value )
                 return prop;
        }
    }
}


</script>
<style type=text/css>
body * { font-family: Helvetica Neue, Helvetica, Arial, sans-serif; }
body table { font-size: 11px; }
.yes {background-color: #4DD7FA; }
.yesday {background-color: #D4F7AF; }
table, th, td
{
border: 1px solid #DDD;
}
table thead {
    background-color:#eee;
    color:#666;
    font-weight: bold;
    cursor: pointer;
}
.noborder {
	border-left: none !important;
	border-right: none !important;
}
.highlightdate {
	background-color: cyan !important;
}
.highlighttime {
	background-color: pink !important;
}
.mytable {
    font: 10px Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    width: 100%;
    padding: 0;
    margin: 0;
    border-top: 1px solid #ebebeb;
	border-spacing:0;
  border-collapse:collapse;
}
.mytable td {
	font: 10px "arial", helvetica, snas-serif;
    border-right: 2px solid #000;
    border-bottom: 2px solid #000;
    border-top: 2px solid #000;
    border-left: 2px solid #000;
    background: #fff;
    padding: 6px 3px 6px 3px;
    color: #000;
    text-transform: none;
    text-align: center;
  /*  word-break: break-all !important; */
}
.mytable th {
    font: bold 11px "arial", helvetica, sans-serif;
    color: #000000;
    border-top: 2px solid #000;
    border-right: 2px solid #000;
    border-bottom: 2px solid #000;
    border-left: 2px solid #000;
    text-transform: none;
    text-align: left;
    padding: 6px 3px 6px 6px;
    background: #f3f3f3;
}
.alltables {
	width: 500px;
}
.checkboxes {
	font: 10px helvetica, "arial", sans-srif;
}
caption {
	font-size: 20px;
	font-weight: bold;
	padding: 5px;
	color: white;
	background-color: black;
	margin-bottom: 10px;
}

#content, #header {
	margin-left: 100px;
}

#sidebar {width:90px; padding:5px; position:fixed; left:0; top:150; background-color: white}

:checked + label {
	font-weight: bold;
	background-color: cyan;
}

form label {
	cursor: pointer;
}

.mytable tr {
/*	cursor: pointer; */
}

.grayout {
	opacity: 0.10;
}

.grayout td {
	border-color: white;
} 

.datetally {
	opacity:0.1;
{


</style>

</head>
<?php $thisurl = $_SERVER['REQUEST_URI']; ?>
<?php
//print $md5str;
include("include/simple_html_dom.php");
if(!isset($_GET["url"]))  {
	$dataurl = null;
} else {
	$dataurl = $_GET["url"];
}
?>

<body>
<base target="_new">
<div id="header">
	<h2>Dan's GSAPP COURSE SCHEDULE PARSER - v0.0.4 (version "wow, this still works!") </h2>
	<h4><a href="https://github.com/provolot/gsappcourses">Github</a></h4>
	<form action="index.php" method="get">
	GSAPP course URL (example: <a href="<?php print $thisurl; ?>?url=http://www.arch.columbia.edu/courses/course-schedule/spring">http://www.arch.columbia.edu/courses/course-schedule/spring)</a><br>
	<input size=100 type="text" name="url" <?php if($dataurl) print "value='$dataurl'"; ?>>
	<input type="submit" value="Submit">
	</form>
	<?php
	//print $md5str;
	if($dataurl) {
	print $dataurl;
?>
</div>
<div id="wrapper">
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

<div id="content" class="alltables">

<?php 
$html = file_get_html($dataurl);

foreach($html->find('[class=mytable]') as $element) 
       echo $element . '<br>';
}

?>
</div>
</div>
<div id="stylediv"></div>
</body>
</html>

