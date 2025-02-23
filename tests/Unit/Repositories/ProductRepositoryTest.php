<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRepositoryTest extends TestCase
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
    public function pode_criar_um_produto()
    {
        // Cria uma categoria para associar ao produto
        $category = Category::factory()->create();

        // Dados do produto a ser criado
        $productData = [
            'nome' => 'Produto de Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 100.50,
            'quantidade' => 10,
            'category_id' => $category->id,
        ];

        // Cria o produto usando o repositório
        $product = $this->productRepository->create($productData);

        // Verifica se o produto foi criado corretamente
        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function pode_atualizar_um_produto()
    {
        // Cria um produto no banco de dados
        $product = Product::factory()->create();

        // Dados atualizados do produto
        $updatedData = [
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição atualizada',
            'preco' => 200.75,
            'quantidade' => 20,
            'category_id' => $product->category_id,
        ];

        // Atualiza o produto usando o repositório
        $updatedProduct = $this->productRepository->update($updatedData, $product->id);

        // Verifica se o produto foi atualizado corretamente
        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function pode_excluir_um_produto()
    {
        // Cria um produto no banco de dados
        $product = Product::factory()->create();

        // Exclui o produto usando o repositório
        $this->productRepository->delete($product->id);

        // Verifica se o produto foi excluído corretamente
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function pode_buscar_um_produto_por_id()
    {
        // Cria um produto no banco de dados
        $product = Product::factory()->create();

        // Busca o produto usando o repositório
        $foundProduct = $this->productRepository->find($product->id);

        // Verifica se o produto foi encontrado corretamente
        $this->assertInstanceOf(Product::class, $foundProduct);
        $this->assertEquals($product->id, $foundProduct->id);
    }

    /** @test */
    public function pode_listar_produtos_com_paginacao()
    {
        // Cria 15 produtos no banco de dados
        Product::factory()->count(15)->create();

        // Busca os produtos paginados usando o repositório
        $paginatedProducts = $this->productRepository->paginate(10);

        // Verifica se a paginação está funcionando corretamente
        $this->assertCount(10, $paginatedProducts);
        $this->assertEquals(15, $paginatedProducts->total());
    }

}
