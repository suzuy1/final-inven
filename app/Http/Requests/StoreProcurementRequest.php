<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // All authenticated users can create procurement requests
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'item_name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:asset,consumable'],
            'quantity' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'unit_price_estimation' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'item_name.required' => 'Nama barang wajib diisi.',
            'item_name.max' => 'Nama barang maksimal 255 karakter.',
            'type.required' => 'Tipe barang wajib dipilih.',
            'type.in' => 'Tipe barang harus asset atau consumable.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka bulat.',
            'quantity.min' => 'Jumlah minimal 1.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'unit_price_estimation.numeric' => 'Estimasi harga harus berupa angka.',
            'unit_price_estimation.min' => 'Estimasi harga tidak boleh negatif.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'item_name' => 'nama barang',
            'type' => 'tipe barang',
            'quantity' => 'jumlah',
            'category_id' => 'kategori',
            'description' => 'deskripsi',
            'unit_price_estimation' => 'estimasi harga satuan',
        ];
    }
}

