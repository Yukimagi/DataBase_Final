<!DOCTYPE html>
<html>
  <head>
<title>日日香DataBase-使用者登入</title>
   <meta charset="utf-8">
  <style>

A:link{text-decoration:underline;color:purple;font-family:標楷體}
A:visited{text-decoration:none;color:purple;font-family:標楷體}
A:hover{text-decoration:none;color:#cc3300;font-family:新細明體;font-style:italic;font-weight:900;}
a:active{color:#FF00FF;text-decoration:none;}
p{display:block;width:70%;white-space:pre-line;text-align:justify; text-justify:inter-ideograph; text-indent:2em;}//使用9-25
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
           font-family: 微軟正黑體;
       }
h2{
font-size:28pt;
text-align:left;
color:gray;
}
h3{
font-size:20pt;
text-align:left;
color:black;
}
h4{font-size:15pt;color:black;font-weight: 900 }
       body {
           font-size: 20pt;
           padding-top: 0px;
           margin: 0 auto;
           width: 100%;
       }
*{margin:0;}
  

#header{/*要記得做結尾，不然會全包，在下面</header>*/
margin:0 auto;
width:100%;
height:100px;/*下面還會再追加10px給menu*/
background-color:#eb6c00;
}

       #header a { /*做table中美觀的排版(block為不要有底線)*/
           display: block;
           text-align: center;
           color: white;
           text-decoration: none;
           padding-top: 0px;
           font-size: 40pt;
           font-family: 微軟正黑體;
       }

           #header a:hover { /*移到超連結時改變顏色*/
               color: white;
               background-color: lightsalmon;
           }

ul{
margin:0 auto;
padding:0;
list-style-type:none/*不顯示項目符號*/
}
.menu{
padding:0;
margin:0 auto;
background-color:#eb6c00;
width:100%;
height:35px;
text-align:center;
color:WHITE;
font-family:'微軟正黑體';/*menu到第一層的配置:第一層橫置*/
font-size:30px;
}
.menu>li{
float:left;
}
.menu li{/*第一層排版*/
width:25%;
position:relative;
padding:0px;
display:table;
border:0;
min-width:250px;
}
       .menu ul {
           background-color: rgba(235,108,0,0.6);
           width: 100%;
           position: absolute;
           top: 100%; /*第二層，不重疊，離第一層的頂點100%*/
           display: none; /*預設ul不顯示*/
       }
.menu a{/*對超連結做排版*/
display:block;
padding:5px 20px;
text-decoration:none;/*底線*/
color:antiquewhite;
}
       .menu a:hover { /*移到超連結時改變顏色*/
           background-color: lightsalmon;
           color: white;
       }
.menu li:hover>ul{/*子選擇器*/
display:block;/*移動到li，li下一層的ul才顯示*/
}
.menu ul li>ul{/*定義第二層與下一層ul的距離*/
top:5%;/*第三層，重疊，離上一層頂點5%*/
left:100%;/*第三層靠第二層右邊多少*/
} 


main{
margin:0 auto;
width=100%;
}

section{
margin:0 auto;
padding-left:2em;padding-right:2em;
float:left;
width:55%;
height:500px;
text-align:left;
border-left-width:2px;border-left-color:brown;border-left-style:dotted;
background-color:white;
}

article{
border-bottom-width:2px;border-bottom-color:brown;border-bottom-style:dotted;
background-color:white;
}

aside{
margin:0 auto;
float:right;
width:25%;
height:500px;
background-color:white;
padding-left:2em;padding-right:2em;
border-left-width:2px;border-left-color:brown;border-left-style:dotted;
border-right-width:2px;border-right-color:brown;border-right-style:dotted;
/*background-image:url(下載.jpg);*//*可以用圖片當背景*/
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
text-align:left;
}
   </style>
</head>

<body>

<header id="header">
<a href="">日日香🍚DATABASE</a>
</header>




<main>
<section>
<article>
<p>
<h2>日日香 DataBase-使用者登入</h2>
<p>
<h3>請輸入帳號&密碼</h3>
</article>
<article>

<form method="get" action="welcome.php">
<p><h2>請輸入帳號:<input type="text" value="user" name="account" size="20"></h2></p>
<p><h2>請輸入密碼:<input type="text" value="123456" name="passwd" size="20"></h2></p>
<p><h2><input type="submit" value="送出" name="B1"><input type="reset" value="重新設定" name="B2"></h2></p>
</form>

</article>
</section>
<aside>
<p>
<h3>如若忘記帳號與密碼，請洽詢系統開發人員以進行查詢!</h3>

</aside>
</main>



<footer>
</footer>


</body>
</html>