<?php

namespace App\Models;

use InvalidArgumentException;

class RecetaIngrediente
{
    private Receta $receta;
    private Ingrediente $ingrediente;
    private float $cantidad;
    private string $unidadMedida;

    public function __construct(Receta $receta, Ingrediente $ingrediente, float $cantidad, string $unidadMedida)
    {
        $this->receta = $receta;
        $this->ingrediente = $ingrediente;
        $this->setCantidad($cantidad);
        $this->unidadMedida = $unidadMedida;
    }

    public function getReceta(): Receta
    {
        return $this->receta;
    }

    public function getIngrediente(): Ingrediente
    {
        return $this->ingrediente;
    }

    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException('La cantidad debe ser mayor que 0.');
        }
        $this->cantidad = $cantidad;
    }

    public function getUnidadMedida(): string
    {
        return $this->unidadMedida;
    }

    public function setUnidadMedida(string $unidadMedida): void
    {
        $this->unidadMedida = $unidadMedida;
    }
}