<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteCustomer extends Model
{
    use HasFactory;

    protected $table = 'route_customers';

    protected $fillable = [
        'route_id',
        'customer_id',
        'visit_order',
        'notes'
    ];

    protected $casts = [
        'visit_order' => 'integer',
    ];

    // Relationships
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
