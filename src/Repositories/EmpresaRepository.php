<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Empresa;
use PDO;



class EmpresaRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }


    public function findAll(?string $search = null): array
    {
        $sql = "SELECT * FROM empresa WHERE activo = 1";
        $params = [];


        if ($search !== null && $search !== ''){
            if(is_numeric($search)){
                $sql .= " AND id_empresa = :id";
                $params[':id'] = $search;
            } else {
                $sql .= " AND LOWER(razon_social) LIKE LOWER(:razon)";
                $params[':razon'] = '%' . $search . '%';
            }
        }

        $sql .= " ORDER BY fecha_creacion DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }



    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE id_empresa = :id AND activo = 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO empresa (rif, razon_social, direccion, telefono)
            VALUES (:rif, :razon_social, :direccion, :telefono)"
        );
        $stmt->execute([
            'rif' => strtoupper($data['rif']),
            'razon_social' => $data['razon_social'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono']
        ]);
        return (int)$this->pdo->lastInsertId();
    }




    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("UPDATE empresa SET rif = :rif, razon_social = :razon_social, direccion = :direccion, telefono = :telefono WHERE id_empresa = :id AND activo = 1");


        return $stmt->execute([
        'id' => $id,
        'rif' => strtoupper($data['rif']),
        'razon_social' => $data['razon_social'],    
        'direccion' => $data['direccion'],
        'telefono' => $data['telefono']
        ]);
    }



    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE empresa SET activo = 0 WHERE id_empresa = :id");
        return $stmt->execute(['id' => $id]);
    }


    public function rifExists(string $rif, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM empresa WHERE rif = :rif AND activo = 1";
        $params = [':rif' => strtoupper($rif)];
        if ($excludeId !== null) {
            $sql .= " AND id_empresa != :id";
            $params[':id'] = $excludeId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function count(?string $search = null): int
    {
        $sql = "SELECT COUNT(*) FROM empresa WHERE activo = 1";
        $params = [];

        if ($search !== null && $search !== '') {
            if(is_numeric($search)){
                $sql .= " AND id_empresa = :id";
                $params['id'] = $search;
            } else {
                $sql .= " AND LOWER(razon_social) LIKE LOWER(:razon)";
                $params['razon'] = '%' . $search . '%';
            }
        }


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();


    }



}   