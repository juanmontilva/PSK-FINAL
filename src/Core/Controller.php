<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }


    protected function error(string $code, string $message, int $status = 400): void
    {
        $this->json(
            ['error' => ['code' => $code, 'message' => $message]], $status
        );
    }


    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            $this->error('VIEW_NOT_FOUND', "La vista {$view} solicitada no existe", 500);
        }
    }

    protected function getJsonInput(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

}