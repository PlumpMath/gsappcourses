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
			AppendHtml += "<td class='datecell date-" + thisdate + " noborder highlightdate'><span>" + thisdate + "</span></td>";
		else
			AppendHtml += "<td class='datecell noborder'><span>" + thisdate + "</span></td>";
	}

// append times

	AppendHtml += "<td class='noborder'></td>";
	AppendHtml += "<td>" + times.join("--") + "</td>";
	AppendHtml += "<td class='noborder'></td>";

// 9 to 23 o clock
//	console.log("proctimes = " + processedtimes)
	for(var i = 9; i <= 23; i++) {
		if(processedtimes[0] <= i  &&  i < processedtimes[1])
			AppendHtml += "<td class='timecell noborder highlighttime'><span class=inner>" + formatTimeShow(i) + "</span></td>";
		else
			AppendHtml += "<td class='timecell noborder'><span class=inner>" + formatTimeShow(i) + "</span></td>";
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
    return "<span class=hour>" + h + "</span><span class=ampm>" + (h_24 < 12 ? 'am' : 'pm') + "</span>";
}

Object.prototype.getKeyByValue = function( value ) {
    for( var prop in this ) {
        if( this.hasOwnProperty( prop ) ) {
             if( this[ prop ] === value )
                 return prop;
        }
    }
}



