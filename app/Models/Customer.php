<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'town_id',
        'is_active',
        'is_filer',
        'cnic',
        'tax_number',
        'notes'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_filer' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the town associated with the customer.
     */
    public function town()
    {
        return $this->belongsTo(Town::class);
    }
}
