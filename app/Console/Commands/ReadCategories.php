<?php

namespace App\Console\Commands;

use App\Categories;
use App\CRUD;
use Illuminate\Console\Command;

class ReadCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for reading and processing data from the file categories.json';
    /**
     * The products file name from needs to read data.
     *
     * @var string
     */
    protected $categoriesFile = __DIR__ . '/files/categories.json';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private function readCategories()
    {
        $categories = json_decode(file_get_contents($this->categoriesFile), true);
        $result = [];
        foreach ($categories as $key => $category) {
            $category_in_model = Categories::where('external_id',$category['external_id'])->get();
            if (count($category_in_model) === 0) {
                $result[$category['external_id']] = CRUD::createCategory($category);
            } else {
                $result[$category['external_id']] =  CRUD::updateCategory($category);
            }
        }
        echo response()->json($result);
    }

    public function handle()
    {
        return $this->readCategories();
    }
}
