<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <form action="test" method="post">
        {{csrf_field()}}
            <input type="submit" name="">
        </form>
         <form action="test2" method="post">
        {{csrf_field()}}
            <input type="submit" name="">
        </form>
        <form action='/hello' method='get'>
            <input type='submit' value='helloget提交'>
        </form>
        <form action='/hello' method='post'>
                    {{ csrf_field() }}
             <input type='submit' value='hellopost提交'>
        </form>
         <ul>
                    <li><a href='/stu'>1.学生信息管理</a></li>
                    <li><a href='/demo1?name=zhang3&age=18&sex=2&num[]=10&num[]=20'>2.laravel中的请求</li>
                    <li><a href='/demo2'>3.laravel中的响应</li>
                    <li><a href='/admin/demo3'>4.laravel中的模板继承</li>
                    <li><a href='/admin/demo4'>5.laravel中的用户管理（模板继承）</a></li>
                    <li><a href='/upload'>6.laravel中的文件上传</a></li>
                    <li><img src="{{ url('admin/c') }}" ></li>
        </ul>
    </body>
</html>
