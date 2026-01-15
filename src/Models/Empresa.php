<?php
declare(strict_types=1);

namespace App\Models;

class Empresa
{
    public function __construct(
        public ?int $id_empresa = null,
        public string $rif = '',
        public string $razon_social = '',
        public string $direccion = '',
        public string $telefono = '',
        public ?string $fecha_creacion = null,
        public bool $activo = true
    ){}


    public static function fromArray(array $data): self
    {
        return new self(
            id_empresa: $data['id_empresa'] ?? null,
            rif: $data['rif'] ?? '',
            razon_social: $data['razon_social'] ?? '',
            direccion: $data['direccion'] ?? '',
            telefono: $data['telefono'] ?? '',
            fecha_creacion: $data['fecha_creacion'] ?? null,
            activo: (bool)($data['activo'] ?? true));
    }


    public function toArray(): array
    {
        return [
            'id_empresa' => $this->id_empresa,
            'rif' => $this->rif,
            'razon_social' => $this->razon_social,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'fecha_creacion' => $this->fecha_creacion,
            'activo' => $this->activo
        ];
    }



















}