<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }


    public function put(string $path, array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }


    public function dispatch(): void
    {   

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


        //Handle Cors
        if ($method === 'OPTIONS'){
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            http_response_code(200);
            exit;
        }


        //Buscar la ruta exacta
        if (isset($this->routes[$method][$uri])) {
            $this->execute($this->routes[$method][$uri]);
            return;
        }


        //Buscar rutas con parametros ejemplo /api/empresas/1
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([a-zA-Z0-9_-]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Eliminar el primer elemento que es la cadena completa
                $this->execute($handler, $matches);
                return;
            }
        }


        //404 error
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'NOT FOUND', 'message' => 'Ruta no encontrada']);
    }

    private function execute(array $handler, array $params = []): void
    {
        [$class, $method] = $handler;
        $controller = new $class();
        call_user_func_array([$controller, $method], $params);
    }
}