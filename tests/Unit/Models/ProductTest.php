<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_um_produto()
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Produto de Teste', $product->nome);
        $this->assertEquals('Descrição do produto de teste', $product->descricao);
        $this->assertEquals(100.50, $product->preco);
        $this->assertEquals(10, $product->quantidade);
        $this->assertEquals($category->id, $product->category_id);
    }

    /** @test */
    public function campos_obrigatorios_devem_ser_preenchidos()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            // 'nome' => 'Produto de Teste', // Campo obrigatório faltando
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => 1,
        ]);
    }


    /** @test */
    public function preco_deve_ser_numerico_e_estar_no_intervalo_correto()
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => $category->id,
        ]);

        $this->assertTrue(is_numeric($product->preco));
        $this->assertGreaterThanOrEqual(0, $product->preco);
        $this->assertLessThanOrEqual(999999.99, $product->preco);
    }

    /** @test */
    public function quantidade_e_um_campo_obrigatorio()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'category_id' => 1,
        ]);
    }

    /** @test */
    public function valor_preco_negativo()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => -100.50,
            'quantidade' => 10,
            'category_id' => 1,
        ]);
    }

    /** @test */
    public function quantidade_negativo()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => -10,
            'category_id' => 1,
        ]);
    }

    /** @test */
    public function verifica_categoria_existente()
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => $category->id,
        ]);

        $this->assertEquals($category->id, $product->category_id);
    }

    /** @test */
    public function verifica_categoria_nao_existente()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => 9999999,
        ]);


    }

    /** @test */
    public function verifica_categoria_null()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => null,
        ]);


    }
}
