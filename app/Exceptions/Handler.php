<?php

namespace LibrosJB\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
    HttpException::class,
    ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);

            if ($request->ajax()) {
                return response()
                    ->json(['error' =>  'Resource not found'], 404);
            }
        }

        if (config('app.debug') && app()->environment() != 'testing') {
            return $this->renderExceptionWithWhoops($request, $e);
        }


        if ($e instanceof  \ErrorException) {
             return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }

    /**
 * Render an exception using Whoops.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  \Exception $e
 * @return Response
 */
    protected function renderExceptionWithWhoops($request, Exception $e)
    {
        $whoops = new \Whoops\Run;

        if ($request->ajax()) {
            $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
        } else {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        }


        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
            );
    }
}
