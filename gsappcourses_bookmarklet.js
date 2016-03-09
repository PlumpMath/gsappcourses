/*$("tr.ng-scope").each(function() {
console.log($(this).find("[abbr='Time']").html());
}); */

var myString = "TU 11 AM - 1 PM	";
var weekparser = /(?:^|\s)format_(.*?)(?:\s|$)/g;
var match = myRegexp.exec(myString);
alert(match[1]);  // abc


