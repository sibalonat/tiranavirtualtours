<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => 'uuid',
            'slug' => 'string|max:255',
            'lat' => 'required|between:-90,90',
            'lng' => 'required|between:-180,180',
            'tour_id' => 'required|exists:tours,id',
            'teaser_en' => 'required',
            'teaser_al' => 'required',
            'title_en' => 'required',
            'title_al' => 'required',
            'author_en' => 'required',
            'author_al' => 'required',
        ];
    }
}
