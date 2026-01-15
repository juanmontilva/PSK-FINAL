<?php
declare(strict_types=1);

namespace App\Validators;


class EmpresaValidator
{
    private array $errors = [];

    public function validate(array $data): bool
    {

        //RIF REQUERIDO, PATRON J-V-G-E-P + 8 DIGITOS + - + 1 DIGITO
        $this->errors = [];
        if (empty($data['rif'])) {
            $this->errors['rif'] = 'El rif es requerido';

        } elseif (!preg_match('/^[JGVEP]-\d{8}-\d$/', $data['rif'])) {
            $this->errors['rif'] = 'El formato del rif es inválido';
        }


        //Razon social
        if (empty($data['razon_social'])) {
            $this->errors['razon_social'] = 'La razón social es requerida';
        } elseif (strlen($data['razon_social']) < 3 || strlen($data['razon_social']) > 100) {
            $this->errors['razon_social'] = 'La razón social debe tener entre 3 y 100 caracteres';
        }

        //Direccion
        if(empty($data['direccion'])){
            $this->errors['direccion'] = 'La dirección es requerida';
        }

        //Direccion
        if(empty($data['telefono'])){
            $this->errors['telefono'] = 'El teléfono es requerido';
        } elseif (!preg_match('/^[\d\-\+\s\(\)]{7,20}$/', $data['telefono'])) {
            $this->errors['telefono'] = 'El formato del teléfono es inválido';
        }

        return empty($this->errors);
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): string
    {
        return reset($this->errors) ?: 'Error de validacion desconocido';
    }
}