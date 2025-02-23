<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_uma_categoria()
    {
        // Cria uma categoria
        $category = Category::create([
            'nome' => 'Categoria de Teste',
            'descricao' => 'Descrição da categoria de teste',
        ]);

        // Verifica se a categoria foi criada corretamente
        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Categoria de Teste', $category->nome);
        $this->assertEquals('Descrição da categoria de teste', $category->descricao);
    }

    /** @test */
    public function nome_e_um_campo_obrigatorio()
    {
        // Tenta criar uma categoria sem o campo 'nome'
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create([
            // 'nome' => 'Categoria de Teste', // Campo obrigatório faltando
            'descricao' => 'Descrição da categoria de teste',
        ]);
    }

    /** @test */
    public function descricao_pode_ser_nulo()
    {
        // Cria uma categoria sem o campo 'descricao'
        $category = Category::create([
            'nome' => 'Categoria de Teste',
            // 'descricao' => null, // Campo opcional
        ]);

        // Verifica se a categoria foi criada corretamente
        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Categoria de Teste', $category->nome);
        $this->assertNull($category->descricao);
    }


    /** @test */
    public function categoria_pode_ser_atualizada()
    {
        // Cria uma categoria
        $category = Category::factory()->create();

        // Atualiza os dados da categoria
        $category->update([
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição atualizada',
        ]);

        // Verifica se a categoria foi atualizada corretamente
        $this->assertEquals('Categoria Atualizada', $category->nome);
        $this->assertEquals('Descrição atualizada', $category->descricao);
    }

    /** @test */
    public function categoria_pode_ser_excluida()
    {
        // Cria uma categoria
        $category = Category::factory()->create();

        // Exclui a categoria
        $category->delete();

        // Verifica se a categoria foi excluída do banco de dados
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function nao_pode_excluir_categoria_com_produtos_relacionados()
    {
        // Tenta excluir a categoria
        $this->expectException(\Exception::class);
        $category = Category::factory()->create();

        // Cria um produto relacionado a categoria
        Product::factory()->create(['category_id' => $category->id]);


        $category->delete();
    }

}
