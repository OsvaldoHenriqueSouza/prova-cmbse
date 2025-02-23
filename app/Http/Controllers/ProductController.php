<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Flash;

class ProductController extends AppBaseController
{
    /** @var ProductRepository $productRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = $this->productRepository->paginate(10, with: ['category'], search: $search);

        return view('products.index')
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new Product.
     */
    public function create()
    {
        $categories = Category::query()->select('id', 'nome')->get()->pluck('nome', 'id');
        return view('products.create')->with('categories', $categories);
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $this->productRepository->create($input);

        Flash::success('Produto salvo com sucesso.');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Produto não existe.');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $Categories = Category::query()->select('id', 'nome')->get()->pluck('nome', 'id');

        if (empty($product)) {
            Flash::error('Produto não existe.');

            return redirect(route('products.index'));
        }

        return view('products.edit')->with('product', $product)->with('categories', $Categories);
    }

    /**
     * Update the specified Product in storage.
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Produto não existe.');

            return redirect(route('products.index'));
        }

        $this->productRepository->update($request->all(), $id);

        Flash::success('Produto atualizado com sucesso.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Produto não existe.');

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Produto deletedo com successo.');

        return redirect(route('products.index'));
    }
}
