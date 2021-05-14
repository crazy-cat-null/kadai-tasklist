<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
        'content' => 'required|max:255',
        'status' => 'required|max:10',
        ];
    }
    
    public function messages()
    {
    return [
        'content.required' => 'コンテンツがないですよ',
        'status.required'  => 'ステータスがないですよ',
    ];
        
    }
}
