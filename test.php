<html>
<head>
<script type="text/javascript" src="http://map.umview.com/jquery.js"></script>
<script type="text/javascript">
         function getdata(){
           $.getJSON("http://map.umview.com/demo_ajax_json.php",function(result){
               // pos.push([result.LNG,result.LAT]);
           res[0]=result.LNG;
           res[1]=result.LAT;
           });
		 } 
alert(res[0]);
</script>
</head>
<body>
<!--<button>获得 JSON 数据</button>-->
<p></p> </body>
</html>
