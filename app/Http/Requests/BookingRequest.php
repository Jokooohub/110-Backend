<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
        if (request()->routeIs('booking.store')) {
            return [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'checkin' => 'required|date',
                'checkout' => 'required|date|after:checkin',
                'user_id' => 'required|integer',
                'room_id' => 'required|integer',
            ];
        }
    }
}