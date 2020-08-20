<?php

namespace App\Console\Commands;

use App\CRUD;
use App\Products;
use Illuminate\Console\Command;
use mysql_xdevapi\Result;

class ReadProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:products';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for reading and processing data from the file products.json';

    /**
     * The products file name from needs to read data.
     *
     * @var string
     */
    protected $productsFile = __DIR__ . '/files/products.json';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function readProducts()
    {
        $products = json_decode(file_get_contents($this->productsFile), true);
        $result = [];
        foreach ($products as $key => $product) {
            $product_in_model = Products::where('external_id',$product['external_id'])->get();
            $product['categories'] = json_encode($product['category_id']);
            if (count($product_in_model) === 0) {
                $result[$product['external_id']] = CRUD::createProduct($product);
            } else {
                $result[$product['external_id']] =  CRUD::updateProduct($product);
            }
        }
        return response()->json($result);
    }

    public function handle()
    {
        return $this->readProducts();
    }
}
