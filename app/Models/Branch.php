<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    public $fillable = ['name', 'email', 'address', 'state', 'city', 'branch_code', 'mobile', 'contact_person_name', 'contact_person_mobile','phone', 'contact_person_email'];

    public $rules = [
        'name' => 'required|unique:branches|max:125',
        'email' => 'required|email',
        'mobile' => 'required|digits:10',
        'phone' => 'nullable|numeric',
        'address' => 'required',
        'city' => 'required',
        'branch_code' => 'required',
        'state' => 'required',
        'contact_person_name' => 'required|max:50',
    ];
}
