<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required'
        ];
    }

    public function data()
    {
        $data = [
            'title'    => $this->get('title'),
            'category_id'  => $this->get('category_id'),
            'subcategory_id'  => $this->get('subcategory_id'),
            'brand_id'  => $this->get('brand_id'),
            'description'  => $this->get('description'),
            'specification'  => $this->get('specification'),
            'price'  => $this->get('price'),
            'is_featured' => ($this->get('is_featured') ? $this->get('is_featured') : '') == 'on' ? '1' : '0',
            'is_trending' => ($this->get('is_trending') ? $this->get('is_trending') : '') == 'on' ? '1' : '0',
            'status' => ($this->get('status') ? $this->get('status') : '') == 'on' ? '1' : '0',
            'best_seller' => ($this->get('best_seller') ? $this->get('best_seller') : '') == 'on' ? '1' : '0',
        ];

        return $data;
    }
}
