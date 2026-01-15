<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\EmpresaRepository;
use App\Validators\EmpresaValidator;
use App\Services\PdfService;

class EmpresaController extends Controller
{
    private EmpresaRepository $repository;
    private EmpresaValidator $validator;

    public function __construct()
    {
        $this->repository = new EmpresaRepository();
        $this->validator = new EmpresaValidator();
    }



    //GET /api/empresas - Listar empresas
    public function list(): void
    {
        $search = $_GET['search'] ?? null;
        $empresas = $this->repository->findAll($search);
        
        $this->json([
            'status' => 'success',
            'data' => $empresas,
            'total' => count($empresas)
        ]);
    }


    //GET /api/empresas/{id} - Obtener una empresa por ID
    public function show(int $id): void
    {
        $empresa = $this->repository->findById($id);
        if ($empresa === null) {
            $this->json(['status' => 'error', 'message' => 'Empresa no encontrada'], 404);
            return;
        }

        $this->json(['status' => 'success', 'data' => $empresa]);
    }


    //POST /api/empresas - Crear una nueva empresa

    public function store(): void
    {
        $data = $this->getJsonInput();

        //validar
        if(!$this->validator->validate($data)){
            $this->json([
                'error' =>[
                    'code' => 'VALIDATION_ERROR',
                    'messages' => $this->validator->getFirstError(),
                    'details' => $this->validator->getErrors()
                ]
            ], 400);
        }


        //Verificar inicidad del rif
        if ($this->repository->rifExists($data['rif'])){
        $this->error('DUPLICATE_RIF', 'El RIF ya está registrado', 400);
        }

        //Crear empresa
        $id = $this->repository->create($data);
        $empresa = $this->repository->findById($id);

        $this->json([
            'status' => 'success',
            'message' => 'Empresa creada exitosamente',
            'data' => $empresa
        ], 201);
    }

    
    //PUT /api/empresas/{id} - Actualizar empresa
    
    public function update(int $id): void
    {
        // Verificar que existe
        if ($this->repository->findById($id) === null) {
            $this->error('NOT_FOUND', 'Empresa no encontrada', 404);
        }
        
        $data = $this->getJsonInput();
        
        // Validar
        if (!$this->validator->validate($data)) {
            $this->json([
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => $this->validator->getFirstError(),
                    'details' => $this->validator->getErrors()
                ]
            ], 400);
        }
        
        // Verificar unicidad de RIF (excluyendo el actual)
        if ($this->repository->rifExists($data['rif'], $id)) {
            $this->error('DUPLICATE_RIF', 'El RIF ya está registrado', 400);
        }
        
        // Actualizar
        $this->repository->update($id, $data);
        $empresa = $this->repository->findById($id);
        
        $this->json([
            'status' => 'success',
            'message' => 'Empresa actualizada exitosamente',
            'data' => $empresa
        ]);
    }

    
    //DELETE /api/empresas/{id} - Eliminar empresa (borrado lógico)
    public function destroy(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            $this->error('NOT_FOUND', 'Empresa no encontrada', 404);
        }
        
        $this->repository->delete($id);
        
        $this->json([
            'status' => 'success',
            'message' => 'Empresa eliminada exitosamente'
        ]);
    }

    /**
     * GET /api/empresas/export.json - Exportar JSON
     */
    public function exportJson(): void
    {
        $search = $_GET['search'] ?? null;
        $empresas = $this->repository->findAll($search);
        
        header('Content-Disposition: attachment; filename="empresas_export.json"');
        
        $this->json([
            'export_date' => date('Y-m-d H:i:s'),
            'total' => count($empresas),
            'filter' => $search,
            'data' => $empresas
        ]);
    }

    //GENERAR PDF GET /api/empresas/report.pdf

    public function reportPdf(): void
    {
        $search = $_GET['search'] ?? null;
        $empresas = $this->repository->findAll($search);
        PdfService::generateEmpresasReport($empresas, $search);
    }
}