<?php

declare(strict_types = 1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use Exception;

class Application
{
    public function __construct(
        protected Router $router,
        protected Config $config,
        protected array $request,
    ) {
    }

    public function init(): void
    {
        try {
            $this->router->resolve(
                requestUri: $this->request['uri'],
                requestMethod: $this->request['method']
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            die();
        } catch (Exception $e) {
            dd($e);
        }
    }
}