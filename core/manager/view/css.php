<?php
print <<<EOT
*{ margin: 0; padding: 0; list-style: none; }
html, body { font: 13px "Verdana", Tahoma, sans-serif; line-height: 15px; color: black; background-color: #FFFFFF; }
#main   { width: 1024px; margin: 0px auto; }
form    { margin: 0; padding: 0; border: 0; }
select  { background-color: #fff; color: #333; }
a       { color: #333399; text-decoration: none; }
a:hover { color: #A0A4C1; text-decoration: none; }
input, textarea, select { font: 12px Verdana, Tahoma, sans-serif; }

.header    { color: #333; font-size: 15px; font-weight: bold; background-color: linen; text-align: center; height: 25px;}
.header a  { color: blue;  display: block; padding: 5px 10px; float: left;}
.header li { display: inline; }
.header a:hover { color: #FFFFFF; background-color: #2BB411; }

.navmenu    { text-align: center; font-size: 15px; height: 25px; background-color: darkgrey; }
.navmenu a  { display: block; padding: 5px; float: left; }
.navmenu li { display: inline; }
.navmenu a:hover  { background-color: darkblue; color: #FFF; }
.navmenu a:active { background-color: #28C247; color: #FFF; }
.navmenu .select  { background-color: #876; padding-right: 15px; }

.mainbody { width: 100%; line-height: 18px; }
.l       { float: left; clear: left; width: 100px; text-align: center; background-color: gainsboro; }
.lmenu   { font-weight: bold; white-space: nowrap; color: #FFFFFF; background-color: indigo; padding: 1px 0px; }
.litem a { display: block; padding: 3px 0; }
.litem a:hover   { background-color: #333; color: #FFFFFF; }
.litem a:active  { background-color:#28C247; color:#FFF; }

.r        { float: none; width: auto; background-color: #A3FFFF; margin-left: 100px; }
.rmenu    { float: left; width: 100%; background-color: powderblue; color: darkblue; font-weight: bold; padding: 1px 0px; }
.rmenu ul { padding: 0px; }
.rmenu li, .ritem dd { display: inline; }
.ritem a  { text-decoration: none; }
.ritem a:hover { text-decoration: none; color: #424457; }
.ritem , .ritemenu { float: left; width: 100%; background-color: floralwhite; height:auto; display:table; border-bottom: 1px solid indigo; border-top: 1px solid #FFF; }
.ritemenu { font-weight: bold; border-bottom: 2px solid black; }

.toleft  { float: left; }
.toright { float: right; }
.lhalf { float: left; width: 50%; clear: left; }
.rhalf { float: right; width: 50%; clear: right; }
.i15 { width: 15px; float: left; }
.i30 { width: 30px; float: left; }
.i35 { width: 35px; float: left; }
.i50 { width: 50px; float: left; }
.i60 { width: 60px; float: left; }
.i70 { width: 70px; float: left; }
.i80 { width: 80px; float: left; }
.i90 { width: 90px; float: left; }
.i100 { width: 100px; float: left; }
.i110 { width: 110px; float: left; }
.i120 { width: 120px; float: left; }
.i130 { width: 130px; float: left; }
.i150 { width: 150px; float: left; }
.i160 { width: 160px; float: left; }
.i200 { width: 200px; float: left; }
.i220 { width: 220px; float: left; }
.i230 { width: 230px; float: left; }
.i335 { width: 335px; float: left; }
.i380 { width: 380px; float: left; }
.i400 { width: 400px; float: left; }

.yes { color:#009933; }
.no  { color:#990000; }
.p_nav    { font-weight: bold; text-align: right; }
.errormsg { font: 12px Verdana; background-color: cyan; color: black; }
.footer   { width: 100%; clear: both; background-color: cadetblue; padding: 5px 0; text-align: center; font-weight: bold; }

.formarea  { line-height: 160%;}
.formfield, .formarea { padding: 3px; margin: 0; color: #333; border: 1px solid #979AC2; }

.formbutton { margin: 0; background-color: #3F4471; color: #fff; cursor: pointer; padding: 4px 3px 0px 5px; 
 border-top: 1px solid #9EA3D5;
 border-left: 1px solid #9EA3D5;
 border-right: 1px solid #000;
 border-bottom: 1px solid #000;
}

.desc  { color: #990000; }
.box   { padding: 10px; margin-bottom: 15px; background-color: #F7F8FA; border: #B1B6D2 1px solid; }
.smbox { padding: 10px; margin: 10px; background-color: #F7F8FA; border: #B1B6D2 1px solid; }
.smbox img { vertical-align: middle; border: none; cursor:pointer; }
.smbox td  { border: none; background-color: none; text-align: center; }
.multipage { float:right; font-weight: bold; line-height:22px; }
.records   { float:left; font-weight: bold; line-height:22px; }
.alert     { margin: 5px 0; color: #990000; font-weight: bold; font-size:14px; }
.alertmsg  { padding: 5px 0 2px 0; background-color: transparent; line-height: 20px; }

.templateinfo    { margin: 0px;  padding: 0px; list-style-type: none; }
.templateinfo li { line-height: 32px; font-size: 16px; font-weight: bold; }
.templateinfo2   { margin: 20px 0; line-height:20px; }

.currenttheme, .availabletheme { overflow: hidden; }
.availabletheme { width: 300px; }
.screenshot { overflow: hidden; width: 300px; background-color: #f1f1f1; border: 1px solid #ccc; }

/*
.availabletheme a.screenshot {
 width: 300px; height: 250px; display: block; margin: auto; margin-bottom: 10px; overflow: hidden; border: 1px solid #aaa; background-color: #f1f1f1; }
*/
EOT;
