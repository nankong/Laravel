<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
	<h3>文件上传</h3>
	<form action="/doupload" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
		文件：<input type="file" name="mypic[]">
		<input type="file" name="mypic[]">
		<input type="file" name="mypic[]">
		<input type="submit" name="上传">
	</form>
</body>
</html>