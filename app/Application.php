<?php

declare(strict_types = 1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use Exception;
use PDOException;

class Application
{
    public function __construct(
        private Router $router,
        private Config $config,
        private array $request,
    ) {
    }

    public function init(): void
    {
        defineRoutes($this->router);
        try {
            $this->router->resolve(
                requestUri: $this->request['uri'],
                requestMethod: $this->request['method']
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            die();
        } catch (PDOException $e) {
            dd($e->getMessage());
            http_response_code(503);
            require VIEW_PATH . '/errors/server-error.php';
            die();
        } catch (Exception $e) {
        }
    }
}
