<html>
<head>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script src="http://dan.taeyounglee.com/sites/gsappcourses/jquery.floatheader.min.js" type="text/javascript"></script>
			<script src="http://dan.taeyounglee.com/sites/gsappcourses/jquery.tablesorter.min.js" type="text/javascript"></script>
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

</style>
<script>
	$(function() {
/*        $("input").click(function() {
//        alert($(this).attr("name"));
             //  if($('td:nth-child()').length > 0) $hide();
             $("tr").each(function(i) {
//                 alert($(this).children("td:nth-child(17)").html());
                 if($(this).children("td:nth-child(17)").html() != "\u25a8") $(this).hide();
//                 alert($(this).children("td:nth-child(17)").length);
 //                if($(this).children("td:nth-child(14)
                 
             });
        }); */
	$("#mytable").floatHeader();
	$("#mytable").tablesorter(); 
        
        $("input").click(function() {
       //         alert(colnum);
                var colnum = parseInt($(this).attr("name")) + 15;
                var waschecked = this.checked;
                $("tr").each(function(i) {
                    if($(this).children("td:eq(" + colnum + ")").html() == "\u25a8") {
                        if(waschecked) { $(this).show(); }
                            else { $(this).hide(); }
                    }
                });
        });


  });
        

             
	</script>


</head>
<body>
<base target="_new">

<h2>GSAPP COURSES - SPRING 2012</h2>
as of Jan 17<br />
Thesis courses, independent researches, etc. courses without physical locations have been removed<br />
<br />
<br />

<form>
    <input type="checkbox" name="1" checked="checked" /> Monday<br>
    <input type="checkbox" name="2" checked="checked" /> Tuesday<br>
    <input type="checkbox" name="3" checked="checked" /> Wednesday<br>
    <input type="checkbox" name="4" checked="checked" /> Thursday<br>
    <input type="checkbox" name="5" checked="checked" /> Friday<br>
</form>


Scroll all the way up and click on headers to sort 
<?php include "data.html"?></body>
</html>
