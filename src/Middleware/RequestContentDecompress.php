<?php

namespace Softonic\RequestContentDecompress\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class RequestContentDecompress
{
    /**
     * @var App
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newRequest = $request;
        if ($request->header('Content-Encoding') === 'gzip') {
            $zippedContent = $request->getContent();
            $request->headers->remove('Content-Encoding');
            $content = @gzdecode($zippedContent);
            if ($content === false) {
                return new JsonResponse(['error' => 'Invalid data encoding.'], 415);
            }
            $baseRequest = new SymfonyRequest();
            $baseRequest->initialize(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                $content
            );
            $newRequest = Request::createFromBase($baseRequest);
            $this->app->instance(Request::class, $newRequest);
        }

        return $next($newRequest);
    }
}
