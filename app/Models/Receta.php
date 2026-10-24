<?php

namespace App\Models;

use InvalidArgumentException;

class Receta
{
    private string $titulo;
    private int $porciones;
    private string $instrucciones;

    /** @var RecetaIngrediente[] */
    private array $ingredientes = [];

    public function __construct(string $titulo, int $porciones, string $instrucciones)
    {
        $this->titulo = $titulo;
        $this->setPorciones($porciones);
        $this->instrucciones = $instrucciones;
    }

    public function agregarIngrediente(Ingrediente $ingrediente, float $cantidad, string $unidadMedida): RecetaIngrediente
    {
        $detalle = new RecetaIngrediente($this, $ingrediente, $cantidad, $unidadMedida);
        $this->ingredientes[] = $detalle;
        return $detalle;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getPorciones(): int
    {
        return $this->porciones;
    }

    public function setPorciones(int $porciones): void
    {
        if ($porciones < 1) {
            throw new InvalidArgumentException('Las porciones deben ser al menos 1.');
        }
        $this->porciones = $porciones;
    }

    public function getInstrucciones(): string
    {
        return $this->instrucciones;
    }

    public function setInstrucciones(string $instrucciones): void
    {
        $this->instrucciones = $instrucciones;
    }

    /** @return RecetaIngrediente[] */
    public function getIngredientes(): array
    {
        return $this->ingredientes;
    }

    public function esValida(): bool
    {
        return count($this->ingredientes) >= 1;
    }
}