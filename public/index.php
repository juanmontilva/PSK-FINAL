<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Controllers\EmpresaController;

//cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeload();

//configuracion segun entorno (desarrollo/produccion)
if (($_ENV['APP_DEBUG'] ?? 'false') === 'true'){
    //DESARROLLO:MUESTRA ERRORES OJO
    ini_set('display_errors', '1');
    ini_set('display_startup_errors','1');
    error_reporting(E_ALL);
} else {
    //PRODUCCION: OCULTA ERRORES
    ini_set('display_errors', '0');
    ini_set('display_startup_errors','0');
    error_reporting(0);
}


//crear un router
$router = new Router();
//RUTAS DE LA APLICACION

//vista principal
$router->get('/', [EmpresaController::class, 'index']);

//API LO QUE ES CRUD DE EMPRESA
$router->get('/api/empresas', [EmpresaController::class, 'list']);

//API EXPORTACION PDF-JSON (deben ir ANTES de {id})
$router->get('/api/empresas/export.json', [EmpresaController::class, 'exportJson']);
$router->get('/api/empresas/report.pdf', [EmpresaController::class, 'reportPdf']);

//Rutas con parámetro {id} al final
$router->get('/api/empresas/{id}', [EmpresaController::class, 'show']);
$router->post('/api/empresas', [EmpresaController::class, 'store']);
$router->put('/api/empresas/{id}', [EmpresaController::class, 'update']);
$router->delete('/api/empresas/{id}', [EmpresaController::class, 'destroy']);

//despachar la ruta o solicitud
$router->dispatch();
