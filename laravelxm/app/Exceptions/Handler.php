<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
	 
    public function render($request, Exception $e)
    {
		/* switch($e){
        //使用类型运算符 instanceof 判断异常(实例)是否为 ModelNotFoundException
        case ($e instanceof ModelNotFoundException):
            //进行异常处理
            return $this->renderException($e);
            break;

        default: */
        return parent::render($request, $e);
    }
	
	//处理异常
	/* protected function renderException($e)
	{
		switch ($e){
			case ($e instanceof ModelNotFoundException):
			//自定义处理异常，此处我们返回一个404页面
			return view('Home.errors');
			break;
			default:
			//如果异常非ModelNotFoundException，我们返回laravel默认的错误页面
			return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
	   }
	} */
                
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
