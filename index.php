<!doctype html>
<html lang="zh-CN">

<head>
    <!-- 原始地址：//webapi.amap.com/ui/1.0/ui/misc/PathSimplifier/examples/expand-path.html -->
    <base href="http://webapi.amap.com/ui/1.0/ui/misc/PathSimplifier/examples/" />
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>GPS-NETWORK-Powered by UMVIEW.COM</title>
    <style>
    html,
    body,
    #container {
        width: 100%;
        height: 100%;
        margin: 0px;
    }
    </style>
</head>

<body>
    <div id="container"></div>
    <script type="text/javascript" src='//webapi.amap.com/maps?v=1.4.4&key=5eb66e06eb930948ee4a42c09054b8d3'></script>
    <!-- UI组件库 1.0 -->
	<script src="http://webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script type="text/javascript" src="http://map.umview.com/jquery.js"></script>

    <script type="text/javascript">
    //创建地图
    var map = new AMap.Map('container', {
        zoom: 4
    });


    AMapUI.load(['ui/misc/PathSimplifier', 'lib/$'], function(PathSimplifier, $) {

        if (!PathSimplifier.supportCanvas) {
            alert('当前环境不支持 Canvas！');
            return;
        }

        var pathSimplifierIns = new PathSimplifier({
            zIndex: 100,
            autoSetFitView: false,
            map: map, //所属的地图实例

            getPath: function(pathData, pathIndex) {

                return pathData.path;
            },
            getHoverTitle: function(pathData, pathIndex, pointIndex) {

                if (pointIndex >= 0) {
                    //point 
                    return pathData.name + '，点：' + pointIndex + '/' + pathData.path.length;
                }

                return pathData.name + '，点数量' + pathData.path.length;
            },
            renderOptions: {

                renderAllPointsIfNumberBelow: 100 //绘制路线节点，如不需要可设置为-1
            }
        });
/*******************************************************************************************/
        window.pathSimplifierIns = pathSimplifierIns;
        var pos = [
                [116.405289, 39.904987],
                //[113.964458, 40.54664],
                //[111.47836, 41.135964],
                //[108.949297, 41.670904]
                /*
                [106.380111, 42.149509],
                [103.774185, 42.56996],
                [101.135432, 42.930601],
                [98.46826, 43.229964],
                [95.777529, 43.466798],
                [93.068486, 43.64009],
                [90.34669, 43.749086],
                [87.61792, 43.793308]
                */
                
            ];
        var myPath = [
                [136.405289, 39.904987],
                [173.964458, 40.54664],
                [121.47836, 41.135964],
                [108.949297, 81.670904],
                [176.380111, 22.149509],
                [103.774185, 42.56996],
                [101.135432, 82.930601],
                [98.46826, 43.229964],
                [95.777529, 43.466798],
                [93.068486, 43.64009],
            ],
            endIdx = 0,
            data = [{
                name: '动态路线',
                path: myPath.slice(0, 1)
            }];
        var n=0;
        var res=[0.0,0.0];
/**************************************************************************************/
        pathSimplifierIns.setData(data);

        //对第一条线路（即索引 0）创建一个巡航器
        var navg1 = pathSimplifierIns.createPathNavigator(0, {
            loop: true, //循环播放
            speed: 1000 //巡航速度，单位千米/小时
        });
        function addMarker(pos) {
            marker = new AMap.Marker({
                icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                position: pos
            });
            marker.setMap(map);
        }

        function expandPath() {
            endIdx++;
            if(endIdx==11){
                clearInterval(flag);
                return;
			}
            /********************************************************/
            //select method of get gps data
		    pos.push(myPath[n]); 
			//pos.push(res);
            /********************************************************/
            if (endIdx >= pos.length) {
                clearInterval(flag);
                return false;
            }
            n++;
            addMarker(pos[endIdx]);
            data[0].path = pos.slice(0, endIdx + 1);
            pathSimplifierIns.setData(data); //延展路径
            return true;
		}
		function getdata(){
	      $.getJSON("http://map.umview.com/demo_ajax_json.php",function(result){
			  // pos.push([result.LNG,result.LAT]);
			  res[0]=result.LNG;
			  res[1]=result.LAT;
		  });
		}
		function plot(){//function for final
			getdata();//get gps data
			expandPath();//ployfix
		}
/***********************************************************/
        addMarker(pos[0]);//mark label
        var flag=setInterval(plot,1000);//set timer 1 sec


    });
    </script>
</body>

</html>
