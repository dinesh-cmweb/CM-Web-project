<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'director' => 'required',
            'producer' => 'required',
            'release_date' => 'required',
            'verdict' => 'required',
            'movie_genre' => 'required',
        ];
    }
    public function messages() {
        return [
            'name.required' => 'movie name is required',
            'director.required' => 'director is required',
            'producer.required' => 'producer is required',
            'release_date' => 'release_date is required',
            'verdict' => 'Please select the hit or flop',
            'movie_genre' => 'Please select the Movie Genres',
        ];
    }
}
