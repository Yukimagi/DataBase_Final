<!DOCTYPE html>
<html>
  <head>
<title>日日香DataBase-首頁</title>
   <meta charset="utf-8">
   <style>

A:link{text-decoration:underline;color:purple;font-family:標楷體}
A:visited{text-decoration:none;color:purple;font-family:標楷體}
A:hover{text-decoration:none;color:#cc3300;font-family:新細明體;font-style:italic;font-weight:900;}
a:active{color:#FF00FF;text-decoration:none;}
p{display:block;width:70%;white-space:pre-line;text-align:justify; text-justify:inter-ideograph; text-indent:2em;}

@media (max-width: 25%) {
google-maps {
  position: relative;
  padding-bottom: 75%; /* 此為地圖長寬比 */
  height: 0;
  overflow: hidden;
}
google-maps iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100% ;
  height: 100% ;
}
}
h1 {
     padding-top: 40px;
     text-align: center;
     font-size: 30pt;
     color: white;
     font-family: 微軟正黑體;}
h2{
font-size:28pt;
text-align:left;
color:gray;
}
h5{
font-size:40pt;
text-align:center;
color:gray;
}
h3{
font-size:20pt;
text-align:left;
color:black;
}
h4{font-size:30pt;color:black;font-weight: 900 }

body{
font-size:20pt;
padding-top:0px;
margin:0 auto;
width:100%;
}

*{margin:0;}

#header{/*要記得做結尾，不然會全包，在下面</header>*/
margin:0 auto;
width:100%;
height:100px;/*下面還會再追加10px給menu*/
background-color:#eb6c00;
}  

#header  a{/*做table中美觀的排版(block為不要有底線)*/
display:block;
text-align:center;
color:white;
text-decoration:none;
padding-top: 0px;
 font-size: 40pt;
font-family: 微軟正黑體;
}

#header  a:hover{/*移到超連結時改變顏色*/
color:white;
background-color:lightsalmon;
}

#menu{
padding:0;
margin:0 auto;
background-color:#eb6c00;
width:100%;
text-align:center;
color:gray;
}

#menu ul{/*就像是在做table*/
width:100%;
padding:0;
display:table;
border-spacing:2px;
}

#menu li{/*做table的表格*/
display:table-cell;
background-color:#eb6c00;
list-style-type:none;
font-size:28pt;
color:white;
}

#menu li a{/*做table中美觀的排版(block為不要有底線)*/
display:block;
text-align:center;
padding-bottom:20px;/*剛剛說要加的10px*/
color:white;
text-decoration:none;
}

#menu li a:hover{/*移到超連結時改變顏色*/
color:white;
background-color:lightsalmon;
}

main{
margin:0 auto;
width=100%;
}

section{
margin:0 auto;
padding:0;
text-align:center;
width:100%;
height:800px;
background-color:white;
}

article{
border-bottom-width:2px;border-bottom-color:brown;border-bottom-style:dotted;
background-color:white;
}



footer{
margin:0 auto;
padding:0;
clear:both;/*清掉前面的float*/
width:100%;
height:50px;
background-color:black;
color:gray;
font-size:20pt;
text-align:right;
}

   </style>
</head>

<body>

<header id="header">
 <a href="homepage.php">日日香🍚DATABASE</a>
</header>

<div id="menu">
<ul>
 <li><a href="homepage.php">主頁</a></li>
 <li><a href="database.php">資料庫</a></li>
 <li><a href="IO.php">匯入/出</a></li>
</ul>
</div>


<main>
<section>
<article>
<p>
<h5>日日香 DataBase</h5>
<p>
</article>
<article>
<table width=100% >
<tr>
<td><td align="center"valign=center"><a href="homepage.php"><img src="pic/homepage.png" height=250 weight=250 border=0 style="display:block; margin:0 auto;" /></a></td>
<td><td align="center"valign="center"><a href="database.php"><img src="pic/database.png"height=250 weight=250  border=0 style="display:block; margin:0 auto;" /></a></td>
</tr>
<tr>
<td><td align="center"valign="center"><a href="SQL.php"><img src="pic/SQL.png"height=200 border=0 style="display:block; margin:0 auto;" /></a></td>
<td><td align="center"valign="center"><a href="IO.php"><img src="pic/io.png"height=250 weight=250  border=0 style="display:block; margin:0 auto;"/></a></td>
</tr>
</table>
</article>
</section>
</main>



<footer>
<a href="user_in0.php">使用者登出</a>
</footer>


</body>
</html>