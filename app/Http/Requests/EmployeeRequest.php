<?php

namespace App\Http\Requests;

use App\Company;
use Illuminate\Foundation\Http\FormRequest;
use Laraplus\Form\Helpers\FormBuilder;

class EmployeeRequest extends FormRequest
{
    use FormBuilder;

    public function rules(): array
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company_id' => 'required|integer',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function form($route): \Laraplus\Form\Form
    {
        $form = $this->getFormBuilder();

        $form->open('create')->method('POST')
            ->action($route);
        $form->hidden('id');
        $form->text('first_name')->label('First Name');
        $form->text('last_name')->label('Last Name');
        $form->text('email')->label('Email');
        $form->text('phone')->label('Phone');
        $form->select('company_id')->label('Company');
        $form->submit('submit')->text('Save');
        $form->close();
        return $form;
    }
}
