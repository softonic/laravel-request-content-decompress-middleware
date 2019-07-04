<?php

namespace Softonic\RequestContentDecompress\Tests\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;
use Softonic\RequestContentDecompress\Middleware\RequestContentDecompress;

class RequestContentDecompressTest extends TestCase
{
    const CONTENT = '{"abc": "def"}';

    public function testHandleCompressedRequest()
    {
        $mockRequest = $this->getCompressedRequest();
        $app         = Mockery::mock(Application::class);
        $app->shouldReceive('instance');
        $middleware = new RequestContentDecompress($app);

        $result = $middleware->handle(
            $mockRequest,
            function ($request) {
                return $request;
            }
        );
        $this->assertSame(self::CONTENT, $result->getContent());
        $this->assertSame(null, $result->header('Content-Encoding'));
    }

    public function testHandleUncompressedRequest()
    {
        $mockRequest = $this->getUncompressedRequest();
        $app         = Mockery::mock(Application::class);
        $app->shouldNotReceive('instance');

        $middleware = new RequestContentDecompress($app);
        $result     = $middleware->handle(
            $mockRequest,
            function ($request) {
                return $request;
            }
        );
        $this->assertSame(self::CONTENT, $result->getContent());
        $this->assertSame(null, $result->header('Content-Encoding'));
    }

    public function testHandleInvalidEncoding()
    {
        $mockRequest = $this->getUncompressedRequest();
        $mockRequest->headers->add(['Content-Encoding' => 'gzip']);
        $app = Mockery::mock(Application::class);
        $app->shouldNotReceive('instance');

        $middleware = new RequestContentDecompress($app);
        $result     = $middleware->handle(
            $mockRequest,
            function ($request) {
                return $request;
            }
        );
        $this->assertSame('{"error":"Invalid data encoding."}', $result->getContent());
        $this->assertSame(415, $result->getStatusCode());
    }

    private function getCompressedRequest()
    {
        $request = new Request([], [], [], [], [], [], gzencode(self::CONTENT));
        $request->headers->add(['Content-Encoding' => 'gzip']);

        return $request;
    }

    private function getUncompressedRequest()
    {
        $request = new Request([], [], [], [], [], [], self::CONTENT);

        return $request;
    }
}
