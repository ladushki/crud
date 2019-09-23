<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laraplus\Form\Helpers\FormBuilder;

class CompanyRequest extends FormRequest
{
    use FormBuilder;

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100|max:2048',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function form($route)
    {
        $form = $this->getFormBuilder();

        $form->open('create')->method('POST')
            ->action($route)
            ->multipart();
        $form->hidden('id');
        $form->text('name')->label('Name');
        $form->text('email')->label('Email');
        $form->text('website')->label('Website');
        $form->file('logo')->label('Logo');
        $form->submit('submit')->text('Save');
        $form->close();
        return $form;
    }
}
