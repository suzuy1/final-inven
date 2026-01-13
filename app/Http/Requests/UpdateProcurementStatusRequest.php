<?php

namespace App\Http\Requests;

use App\Enums\ProcurementStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProcurementStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admin can update procurement status
        return $this->user()?->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(['approved', 'rejected', 'completed']),
            ],
            'admin_note' => ['nullable', 'string', 'max:1000'],
            'consumable_id' => ['nullable', 'exists:consumables,id'],
            'batch_code' => ['required_if:status,completed', 'nullable', 'string', 'max:50'],
            'unit_price' => ['required_if:status,completed', 'nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'admin_note.max' => 'Catatan admin maksimal 1000 karakter.',
            'consumable_id.exists' => 'Barang consumable tidak ditemukan.',
            'batch_code.required_if' => 'Kode batch wajib diisi untuk status selesai.',
            'batch_code.max' => 'Kode batch maksimal 50 karakter.',
            'unit_price.required_if' => 'Harga satuan wajib diisi untuk status selesai.',
            'unit_price.numeric' => 'Harga satuan harus berupa angka.',
            'unit_price.min' => 'Harga satuan tidak boleh negatif.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $procurement = $this->route('procurement');
            $status = $this->input('status');

            // Validate state transition
            if ($procurement && $procurement->status instanceof ProcurementStatus) {
                $newStatus = ProcurementStatus::tryFrom($status);
                if ($newStatus && !$procurement->status->canTransitionTo($newStatus)) {
                    $validator->errors()->add(
                        'status',
                        "Status tidak bisa diubah dari '{$procurement->status->label()}' ke '{$newStatus->label()}'."
                    );
                }
            }
        });
    }
}

