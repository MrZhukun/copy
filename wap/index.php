<?php
header("content-type:text/html;charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<body>
<script type="text/javascript" src="jquery-2.1.0.js"></script>
<script>
  $.ajax({
  cache:false,
  type:"GET",
  url:"ip.php",
  async:true,
  success:function(info){
    var msgloca=eval(info);
    var loca=msgloca[0].city;
    $("#dm").html(loca);
    }
  });
</script>
<script>
var x=document.getElementById("demo");
  if (navigator.geolocation)
    {
    navigator.geolocation.watchPosition(showPosition,showError);
    }else{
    x.innerHTML="该浏览器不支持地理定位";
    }
function showPosition(position)
  {
  $(document).ready(function(){
  $.ajax({
  cache:false,
  type:"POST",
  url:"location.php",
  data:"location="+position.coords.longitude+","+position.coords.latitude,
  async:true,
  success:function(msg){
    $("#demo").html(msg);
    }
  });
  });
  }
function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="用户不允许地理定位"
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="无法获取当前位置"
      break;
    case error.TIMEOUT:
      x.innerHTML="操作超时"
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="出现未知错误"
      break;
    }
  }
</script>
<p id="dm">网络定位ing...</p>
<p id="demo">GPS定位ing...</p>
</body>
</html>