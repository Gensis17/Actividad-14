<?php

namespace Tests\Unit;

use App\Models\Ingrediente;
use App\Models\Receta;
use App\Models\RecetaIngrediente;
use PHPUnit\Framework\TestCase;

class RecetaTest extends TestCase
{
    public function test_instanciar_receta_con_sus_ingredientes(): void
    {
        $receta = new Receta(
            'Gallo pinto',
            4,
            'Sofreír cebolla y chile, agregar el arroz y los frijoles, sazonar con salsa Lizano y mezclar.'
        );

        $arroz   = new Ingrediente('Arroz cocido');
        $frijol  = new Ingrediente('Frijoles negros');
        $cebolla = new Ingrediente('Cebolla');
        $salsa   = new Ingrediente('Salsa Lizano');

        $receta->agregarIngrediente($arroz, 2, 'tazas');
        $receta->agregarIngrediente($frijol, 1.5, 'tazas');
        $receta->agregarIngrediente($cebolla, 1, 'unidad');
        $receta->agregarIngrediente($salsa, 3, 'cucharadas');

        $this->assertSame('Gallo pinto', $receta->getTitulo());
        $this->assertSame(4, $receta->getPorciones());
        $this->assertTrue($receta->esValida());

        $this->assertCount(4, $receta->getIngredientes());

        $primero = $receta->getIngredientes()[0];
        $this->assertInstanceOf(RecetaIngrediente::class, $primero);
        $this->assertSame('Arroz cocido', $primero->getIngrediente()->getNombre());
        $this->assertSame(2.0, $primero->getCantidad());
        $this->assertSame('tazas', $primero->getUnidadMedida());
        $this->assertSame($receta, $primero->getReceta());
    }

    public function test_un_ingrediente_puede_estar_en_varias_recetas(): void
    {
        $huevo = new Ingrediente('Huevo');

        $tortilla = new Receta('Tortilla española', 2, 'Batir huevos, freír papas y cuajar.');
        $queque   = new Receta('Queque de vainilla', 8, 'Mezclar, verter en molde y hornear 40 min.');

        $tortilla->agregarIngrediente($huevo, 4, 'unidades');
        $queque->agregarIngrediente($huevo, 3, 'unidades');

        $this->assertSame(4.0, $tortilla->getIngredientes()[0]->getCantidad());
        $this->assertSame(3.0, $queque->getIngredientes()[0]->getCantidad());
        $this->assertSame($huevo, $tortilla->getIngredientes()[0]->getIngrediente());
    }

    public function test_receta_sin_ingredientes_no_es_valida(): void
    {
        $receta = new Receta('Vacía', 1, 'Nada');
        $this->assertFalse($receta->esValida());
    }

    public function test_cantidad_debe_ser_positiva(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $receta = new Receta('Café', 1, 'Colar.');
        $receta->agregarIngrediente(new Ingrediente('Café molido'), 0, 'cucharadas');
    }
}