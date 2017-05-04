<script type="text/javascript" src="{{ asset('Home\Jquery\jquery-1.7.2.js') }}"></script>
<!doctypehtml>
<html>
	<head>
		<title></title>
	</head>
	<body id='body'>
		<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:20px 20px 0px 0px;box-shadow:0 6px 12px #eee;">亲！小的们正在抢修中...</div>
		<script>
			$(function(){
			  	$.ajax({
					url:'/home/config',
					type:'GET',
					dataType:'json',
					success:function(responseText,status,xhl){
						// console.log(responseText);
						if(responseText[0] == 1){
							window.location.href='/'
						}
					},
					error:function(){
						// console.log(111);
					},
					timeout:60*1000,
				});
			});
		</script>
	</body>	
</html>