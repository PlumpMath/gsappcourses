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

<h2>GSAPP COURSES - FALL 2012</h2>
-- As of August 14<br />
<h2 style="color:red;position:fixed;top:50%; width: 75%; padding:10px; background-color:white;left:12%">currently outdated - check back at 2pm; in the meantime check <a href="http://www.arch.columbia.edu/school/registration">http://www.arch.columbia.edu/school/registration</a></h2>
<?php include "data.html" ?>
</body>
</html>

