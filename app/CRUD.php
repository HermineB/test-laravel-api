<?php


namespace App;


use Illuminate\Support\Facades\Validator;

class CRUD
{
    public static $product_update_rules = [
        'name' => 'string|max:200',
        'description' => 'string|max:1000',
        'price' => 'numeric',
        'quantity' => 'integer',
        'categories' => 'json',
        'external_id' => 'required|integer',
    ];

    public static $product_create_rules = [
        'name' => 'required|string|max:200',
        'description' => 'string|max:1000',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'categories' => 'required|json',
        'external_id' => 'required|unique:products|integer',
    ];

    public static $categories_update_rules = [
        'name' => 'string|unique:categories|max:200',
        'parent_id' => 'integer',
        'external_id' => 'integer|required',
    ];

    public static function updateProduct($data)
    {

        $result = [];
        $product = [];
        $validator = Validator::make($data, self::$product_update_rules);
        if (empty($validator->errors()->get('categories'))) {
            $categories = json_decode($data['categories'], true);
            $validator->after(function ($validator) use ($categories) {
                $invalid_categories = [];
                foreach ($categories as $key => $val) {
                    $res = Categories::find(intval($val));
                    if (empty($res)) {
                        $invalid_categories[] = $val;
                    }
                }
                if (!empty($invalid_categories)) {
                    $validator->errors()->add('categories', json_encode($invalid_categories) . ': invalid categories.');
                }
            });
        }
        if (empty($validator->errors()->get('external_id'))) {
            $product = Products::where('external_id', $data['external_id'])->first();
            $validator->after(function ($validator) use ($product, $data) {
                if (empty($product)) {
                    $validator->errors()->add('id', 'Product not found.');
                } else {
                    if (isset($data['name'])) {
                        $product->name = $data['name'];
                    }
                    if (isset($data['description'])) {
                        $product->description = $data['description'];
                    }
                    if (isset($data['price'])) {
                        $product->price = $data['price'];
                    }
                    if (isset($data['quantity'])) {
                        $product->quantity = $data['quantity'];
                    }
                    if (isset($data['categories'])) {
                        $product->categories = $data['categories'];
                    }
                }
            });
        }
        if ($validator->fails()) {
            $result['error'] = $validator->errors()->getMessages();
        } else {
            if ($product->save()) {
                $result['success'] = "Successfully updated.";
            } else {
                $result['error'] = "Something went wrong.";
            }
        }
        return $result;
    }

    public static function createProduct($data)
    {
        $result = [];
        $validator = Validator::make($data, self::$product_create_rules);
        if (empty($validator->errors()->get('categories'))) {
            $categories = json_decode($data['categories'], true);
            $validator->after(function ($validator) use ($categories) {
                $invalid_categories = [];
                foreach ($categories as $key => $val) {
                    $res = Categories::find(intval($val));
                    if (empty($res)) {
                        $invalid_categories[] = $val;
                    }
                }
                if (!empty($invalid_categories)) {
                    $validator->errors()->add('categories', json_encode($invalid_categories) . ': invalid categories.');
                }
            });
        }
        if ($validator->fails()) {
            $result['error'] = $validator->errors()->getMessages();
        } else {
            $product = new Products();
            $product->name = $data['name'];
            $product->description = isset($data['description'])? $data['description'] : '';
            $product->price = $data['price'];
            $product->quantity = $data['quantity'];
            $product->categories = $data['categories'];
            $product->external_id = $data['external_id'];
            if ($product->save()) {
                $result = [
                    "success" => "Successfully added",
                    "inserted_id" => $product->id,
                ];
            } else {
                $result["error"] = "Something went wrong.";
            }
        }
       return $result;
    }

    public static function deleteProduct($data)
    {
        $validator = Validator::make($data, [
            'external_id' => 'required|string',
        ]);
        if ($validator->fails()) {
            $result['errors'] = $validator->errors()->getMessages();
        } else {
            $product = Products::where('external_id', $data['external_id']);
            if (!empty($product)) {
                if ($product->delete()) {
                    $result['success'] = "Successfully deleted.";
                } else {
                    $result['errors'] = "Something went wrong.";
                }
            } else {
                $result['errors'] = "Product not found.";
            }
        }
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    public static function createCategory($data)
    {
        $result = [];
        $rules = [
            'name' => ['required', 'string', 'unique:categories', 'max:200'],
            'parent_id' => ['integer'],
            'external_id' => ['required', 'unique:categories', 'integer'],
        ];
        $validator = Validator::make($data, $rules);

        if (empty($validator->errors()->get('parent_id'))) {
            $parent_id = isset($data['parent_id']) ? intval($data['parent_id']) : 0;
            if ($parent_id !== 0) {
                $validator->after(function ($validator) use ($parent_id) {
                    $category = Categories::find($parent_id);
                    if (empty($category)) {
                        $validator->errors()->add('parent_id', 'Invalid parent id');
                    }
                });
            }
        }

        if ($validator->fails()) {
            $validateErrors = $validator->errors()->getMessages();
            $result['error'] = $validateErrors;
        } else {
            $category = new Categories();
            $category->name = $data['name'];
            $category->parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;
            $category->external_id = $data['external_id'];
            if ($category->save()) {
                $result = [
                    'success' => "Successfully added",
                    'inserted_id' => $category->id
                ];
            } else {
                $result['error'] = "Something went wrong";
            }
        }
        return $result;

    }

    public static function updateCategory($data)
    {
        $result = [];
        $category = [];
        $validator = Validator::make($data, self::$categories_update_rules);
        if (empty($validator->errors()->get('parent_id'))) {
            if (isset($data['parent_id']) && intval($data['parent_id']) !== 0) {
                $validator->after(function ($validator) use ($data) {
                    $category = Categories::find(intval($data['parent_id']));
                    if (empty($category)) {
                        $validator->errors()->add('parent_id', 'Invalid parent id');
                    }
                });
            }
        }

        if (empty($validator->errors()->get('external_id'))) {
            $category = Categories::where("external_id", $data['external_id'])->first();
            $validator->after(function ($validator) use ($category) {
                if (empty($category)) {
                    $validator->errors()->add('external_id', 'Category not found.');
                }
            });
        }

        if ($validator->fails()) {
            $result['error'] = $validator->errors()->getMessages();
        } else {
            if (isset($data['name']) && !empty($data['name'])) {
                $category->name = $data['name'];
            }
            if (isset($data['parent_id']) && !empty($data['parent_id'])) {
                $category->parent_id = $data['parent_id'];
            }
            if ($category->save()) {
                $result['success'] = "Successfully updated";
            } else {
                $result['error'] = "Something went wrong";
            }
        }
        return $result;
    }

    public static function deleteCategory($data)
    {

        $validator = Validator::make($data, [
            'external_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $result['errors'] = $validator->errors()->getMessages();
        } else {
            $category = Categories::where('external_id', intval($data['external_id']))->first();
            if (!empty($category)) {
                if ($category->delete()) {
                    $result['success'] = "Successfully deleted.";
                } else {
                    $result['errors'] = "Something went wrong.";
                }
            } else {
                $result['errors'] = "Category not found.";
            }
        }
        return $result;
    }
}
