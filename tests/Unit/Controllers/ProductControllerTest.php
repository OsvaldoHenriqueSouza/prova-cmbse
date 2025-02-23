<?php

namespace Tests\Unit\Controller;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProductRepository */
    private $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = new ProductRepository();
    }

    /** @test */
    public function a_usuario_pode_ver_a_lista_de_produtos()
    {

        Product::factory()->count(10)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);

        $response->assertViewIs('products.index');

        $response->assertViewHas('products');
    }

    /** @test */
    public function a_usuario_pode_ver_o_formulario_de_criacao_de_produto()
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);

        $response->assertViewIs('products.create');

        $response->assertViewHas('categories');
    }

    /** @test */
    public function a_usuario_pode_ver_os_detalhes_de_um_produto()
    {

        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product->id));

        $response->assertStatus(200);

        $response->assertViewIs('products.show');

        $response->assertViewHas('product', $product);
    }

    /** @test */
    public function a_usuario_pode_ver_o_formulario_de_edicao_de_produto()
    {

        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product->id));

        $response->assertStatus(200);

        $response->assertViewIs('products.edit');

        $response->assertViewHas('product', $product);

        $response->assertViewHas('categories');
    }
}
