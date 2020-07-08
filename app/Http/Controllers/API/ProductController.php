<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Validator;
use GuzzleHttp\Client;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $client = new Client(['base_uri' => 'https://store.steampowered.com/api/']);
        $response = $client->request('GET', 'appdetails?appids=' . $input['appId']);
        $body = json_decode($response->getBody(), true);
        /*        echo '<pre>';
        var_dump($body[$input['appId']]);exit;
                echo '</pre>';*/
        $save = [
            'name' => $body[$input['appId']]['data']['name'],
            'appId' => (int)$input['appId'],
            'detail' => $body[$input['appId']]['data']['detailed_description']
        ];

        $validator = Validator::make($save, [
            'name' => 'required',
            'appId' => 'required',
            'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::create($save);
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        return $this->sendResponse($product->toArray(), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
    }
}
