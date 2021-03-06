<?php

namespace App\Exceptions;

use App\Category;
use App\Http\Controllers\SiteController;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
    public function render($request, Exception $exception)
    {
        if($this->isHttpException($exception)){
            $statusCode=$exception->getStatusCode();

            switch ($statusCode){
                case '404' :

                    $obj = new SiteController(new CategoryRepository(new Category()));
                    $obj->title='Страница не найдена';
                    $obj->template='404';
                    \Log::alert('Страница не найдена - '. $request->url());

                  return  response( $obj->renderOutput());

                case '403':
                    return response('У вас нет прав доступа до админпанели ');


            }
        }
        return parent::render($request, $exception);
    }
}
