<?php


namespace App\Http\Controllers;


use App\Categories;
use App\Products;
use App\CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{

    public $item_count = 50;

    public function getProducts(Request $request)
    {
        $data = $request->input();
        $result_sorting = $this->sorting($data);
        if (isset($result_sorting['errors'])) {
            $result = $result_sorting;
        } else {
            $result = Products::orderBy($result_sorting['sort_column'], $result_sorting['sort_value'])
                ->paginate($this->item_count)->getCollection();
        }
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    public function sorting($data)
    {
        $sort_value = 'desc';
        $sort_column = 'id';
        $validate_errors = [];
        if (isset($data['sort'])) {
            $sort_columns = ['price', 'created_at'];
            $sort_values = ['asc', 'desc'];
            $parts = explode(',', $data['sort']);
            if (!empty($parts)) {
                if (in_array($parts[0], $sort_columns)) {
                    $sort_column = $parts[0];
                } else {
                    $validate_errors['errors'][] = 'Invalid sort column';
                }
                if (isset($parts[1]) && in_array(strtolower($parts[1]), $sort_values)) {
                    $sort_value = strtolower($parts[1]);
                } else {
                    $validate_errors['errors'][] = 'Invalid sort type';
                }
            }
        }
        if (empty($validate_errors)) {
            $result = [
                'sort_value' => $sort_value,
                'sort_column' => $sort_column,
            ];
        } else {
            $result = $validate_errors;
        }
        return $result;
    }

    public function getByCategory(Request $request)
    {
        $data = $request->input();
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
        ]);

        if (empty($validator->errors()->get('category'))) {
            $validator->after(function ($validator) use ($data) {
                $category = Categories::find(intval($data['category']));
                if (empty($category)) {
                    $validator->errors()->add('category', 'invalid category.');
                }
            });
        }

        if ($validator->fails()) {
            $result['errors'] = $validator->errors();
        } else {
            $result_sorting = $this->sorting($data);
            if (isset($result_sorting['errors'])) {
                $result = $result_sorting;
            } else {
                $result = Products::whereJsonContains('categories', $data['category'])
                    ->orderBy($result_sorting['sort_column'], $result_sorting['sort_value'])
                    ->paginate($this->item_count)->getCollection();
            }
        }
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    public function getById(Request $request)
    {
        $data = $request->input();

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $result['errors'] = $validator->errors();
        } else {
            $result = Products::find(intval($data['id']));
        }
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    /**
     * Store a new product post.
     *
     * @param Request $request
     * @return Response
     */
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $result = CRUD::createProduct($request->input());
        return response()
            ->json($result)
            ->header('Content-Type', 'application/json');
    }

    public function update(Request $request)
    {
        $result = CRUD::updateProduct($request->input());
        return response()
            ->json($result)
            ->header('Content-Type', 'application/json');
    }

    public function delete(Request $request)
    {
        return CRUD::deleteProduct($request->input());
    }
}
