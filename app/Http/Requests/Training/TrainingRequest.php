<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
        $rules = [
            'title'=>'required'
        ];

        return $rules;
    }

    public function data(){
        
        
        $inputs=[
            'service_id'               => $this->get('service_id'),
            'title' => $this->get('title'),
            'training_date' => $this->get('training_date'),
            'trainer' => $this->get('trainer'),
            'content'   => $this->get('content'),
            'is_published' => ($this->get('is_published') ? $this->get('is_published') : '') == 'on' ? '1' : '0',
            'is_featured' => ($this->get('is_featured') ? $this->get('is_featured') : '') == 'on' ? '1' : '0'

        ];
      
        if ($this->has('publish')) {
            $inputs['is_published'] = 1;
        }

        return $inputs;
    }
}

