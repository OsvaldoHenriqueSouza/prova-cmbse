<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var CategoryRepository */
    private $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = new CategoryRepository();
    }

    /** @test */
    public function pode_criar_uma_categoria()
    {

        $categoryData = [
            'nome' => 'Categoria de Teste',
            'descricao' => 'Descrição da categoria de teste',
        ];

        $category = $this->categoryRepository->create($categoryData);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertDatabaseHas('categories', $categoryData);
    }

    /** @test */
    public function pode_atualizar_uma_categoria()
    {

        $category = Category::factory()->create();

        $updatedData = [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Descrição atualizada',
        ];

        $updatedCategory = $this->categoryRepository->update($updatedData, $category->id);

        $this->assertInstanceOf(Category::class, $updatedCategory);
        $this->assertDatabaseHas('categories', $updatedData);
    }

    /** @test */
    public function pode_excluir_uma_categoria()
    {

        $category = Category::factory()->create();

        $this->categoryRepository->delete($category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function pode_buscar_uma_categoria_por_id()
    {

        $category = Category::factory()->create();

        $foundCategory = $this->categoryRepository->find($category->id);

        $this->assertInstanceOf(Category::class, $foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
    }

    /** @test */
    public function pode_listar_categorias_com_paginacao()
    {
        Category::factory()->count(15)->create();

        $paginatedCategories = $this->categoryRepository->paginate(10);

        $this->assertCount(10, $paginatedCategories);
        $this->assertEquals(15, $paginatedCategories->total());
    }

}
