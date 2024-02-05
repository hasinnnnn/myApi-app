<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    use HasFactory;
    protected $fillable  = [
        'name',
        'email',
        'password',
        'phone',
        
    ];

    public function hasRequiredFields(): bool
    {
        // Validate if required fields are present and return true/false
        // Use validation rules, accessors, or any other logic as needed
        return true; // Replace with your actual validation logic
    }
}
