<?php

namespace Tests\Unit\Controller;

use Tests\TestCase;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
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
    public function a_usuario_pode_ver_a_lista_de_categorias()
    {

        Category::factory()->count(10)->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);

        $response->assertViewIs('categories.index');

        $response->assertViewHas('categories');
    }

    /** @test */
    public function a_usuario_pode_ver_o_formulario_de_criacao_de_categoria()
    {

        $response = $this->get(route('categories.create'));

        $response->assertStatus(200);

        $response->assertViewIs('categories.create');
    }

    /** @test */
    public function a_usuario_pode_ver_os_detalhes_de_uma_categoria()
    {

        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category->id));

        $response->assertStatus(200);

        $response->assertViewIs('categories.show');

        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function a_usuario_pode_ver_o_formulario_de_edicao_de_categoria()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.edit', $category->id));

        $response->assertStatus(200);

        $response->assertViewIs('categories.edit');

        $response->assertViewHas('category', $category);
    }
}
