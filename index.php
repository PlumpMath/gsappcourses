<html>
<head>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	var querybefore = "'http://search.columbia.edu/search?&q=";
	var queryafter = "&site=Directory_of_Classes&num=20&sort=date%3AD%3AL%3Ad1&filter=0&entqr=0&ud=1&output=xml_no_dtd&client=DoC&proxystylesheet=DoC&oe=UTF-8&ie=UTF-8&proxyreload=1'";
	var ourDiv = $("#mytable tr").each(function() {
	var thiscoursename = $(this).find("td:nth-child(2)");
	thiscoursename.html("<b>" + thiscoursename.html() + "</b>");

	var thiscourse = $(this).find("td:nth-child(9)");
	thiscourse.html("<a href=" + querybefore + thiscourse.html() + queryafter + ">" + thiscourse.html() + "</a>");
	
	var thistime = $(this).find("td:nth-child(6)");
	thistime.parent("tr").append(processTime(thistime.html()));


  
  });

	$("#mytable tr").click(function() {
		$(this).toggleClass("grayout");
	});
	$("input").click(function() {
			var datename = $(this).attr("name");
			var waschecked = this.checked;
			if(!waschecked)
				$("." + datename).parent("tr").hide();
			else 
				$("." + datename).parent("tr").show();
	});


});

function processTime(inpstr) {
	if (inpstr == null)
		return "";
	inpstr = inpstr.replace(/&nbsp;/g, '');
	if ( $.trim(inpstr) == '' )
		return "";

//	console.log(inpstr);
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
	dates = dates.split(/,/)

	// date lookup table: monday = 1, tuesday = 2, etc
	var datelookup = {
		'M' : 1,
		'Tu' : 2,
		'W' : 3,
		'Th' : 4,
		'F' : 5
	}
	var processeddates = [];
	$.each(dates, function() {
	
		processeddates.push(datelookup[$.trim(this)]);

	});
	if ( processeddates == null)
		return "";
//	console.log(processeddates);

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
#mytable {
    font: 10px Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    width: 100%;
    padding: 0;
    margin: 0;
    border-top: 1px solid #ebebeb;
	border-spacing:0;
  border-collapse:collapse;
}
#mytable td {
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
#mytable th {
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

#content {
	padding-left: 100px;
}

#sidebar {width:90px; padding:5px; position:fixed; left:0; top:0; background-color: white}

:checked + span {
	font-weight: bold;
	background-color: cyan;
}

#mytable tr {
	cursor: pointer;
}

.grayout {
	opacity: 0.15;
}

.grayout td {
	border-color: white;
}


</style>

</head>
<body>
<base target="_new">
<?php
$dataurl = "http://www.arch.columbia.edu/courses/course-schedule/spring";
//print $md5str;
include("include/simple_html_dom.php");
?>
<div id="wrapper">
<div id="sidebar" class=checkboxes>
	<b>Show courses with dates on:</b>
<form>
    <input type="checkbox" name="date-M" checked="checked" /><span> Monday</span><br>
    <input type="checkbox" name="date-Tu" checked="checked" /><span> Tuesday</span><br>
    <input type="checkbox" name="date-W" checked="checked" /><span> Wednesday</span><br>
    <input type="checkbox" name="date-Th" checked="checked" /><span> Thursday</span><br>
    <input type="checkbox" name="date-F" checked="checked" /><span> Friday</span><br>
</form>
</div>

<div id="content" class="alltables">
<h2>Dan's GSAPP COURSE SCHEDULE - SPRING 2013</h2>
<h3>Updated LIVE from http://www.arch.columbia.edu/courses/course-schedule/spring-2013</h3>
<h4>(The visualization may have a few errors, since the page is scraping/parsing/visualizing on-the-fly --- but the data in the main table is identical)</h4>

<?php 
$html = file_get_html($dataurl);

foreach($html->find('[id=mytable]') as $element) 
       echo $element . '<br>';


?>
</div>
</div>

</body>
</html>

