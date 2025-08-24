<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'day_of_week',
        'is_active'
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'route_customers')
            ->withPivot('visit_order', 'notes')
            ->withTimestamps()
            ->orderBy('route_customers.visit_order');
    }

    public function routeCustomers()
    {
        return $this->hasMany(RouteCustomer::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }

    // Helper methods
    public function getDayNameAttribute()
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
        
        return $days[$this->day_of_week] ?? 'Unknown';
    }

    public function getTotalCustomersAttribute()
    {
        return $this->customers()->count();
    }
}
