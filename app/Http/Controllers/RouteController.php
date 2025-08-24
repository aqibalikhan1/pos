<?php
namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Customer;
use App\Models\RouteCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    /**
     * Display a listing of the routes.
     */
    public function index()
    {
        $routes = Route::withCount('customers')
            ->orderBy('day_of_week')
            ->orderBy('name')
            ->get()
            ->groupBy('day_of_week');

        return view('pos.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new route.
     */
    public function create()
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

        return view('pos.routes.create', compact('days'));
    }

    /**
     * Store a newly created route in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'day_of_week' => 'required|integer|between:1,7',
        ]);

        $route = Route::create($validated);

        return redirect()->route('routes.show', $route)
            ->with('success', 'Route created successfully.');
    }

    /**
     * Display the specified route.
     */
    public function show(Route $route)
    {
        $route->load(['customers' => function ($query) {
            $query->orderBy('route_customers.visit_order');
        }]);

        // Format customer names for display
        foreach ($route->customers as $customer) {
            $customer->display_name = $customer->first_name . ' ' . $customer->last_name;
        }

        return view('pos.routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified route.
     */
    public function edit(Route $route)
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

        return view('pos.routes.edit', compact('route', 'days'));
    }

    /**
     * Update the specified route in storage.
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'day_of_week' => 'required|integer|between:1,7',
            'is_active' => 'boolean',
        ]);

        $route->update($validated);

        return redirect()->route('routes.show', $route)
            ->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified route from storage.
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('routes.index')
            ->with('success', 'Route deleted successfully.');
    }

    /**
     * Show the form for assigning customers to a route.
     */
    public function assignCustomers(Route $route)
    {
        $route->load('customers');
        
        $assignedCustomers = $route->customers->pluck('id')->toArray();
        
        $availableCustomers = Customer::whereNotIn('id', $assignedCustomers)
            ->where('is_active',true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('pos.routes.assign-customers', compact('route', 'availableCustomers'));
    }

    /**
     * Store customer assignments to a route.
     */
    public function storeCustomerAssignments(Request $request, Route $route)
    {
        $validated = $request->validate([
            'customers' => 'required|array',
            'customers.*.customer_id' => 'required|exists:customers,id',
            'customers.*.visit_order' => 'required|integer|min:1',
            'customers.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($route, $validated) {
            // Remove existing assignments
            $route->customers()->detach();
            
            // Add new assignments
            foreach ($validated['customers'] as $customerData) {
                $route->customers()->attach($customerData['customer_id'], [
                    'visit_order' => $customerData['visit_order'],
                    'notes' => $customerData['notes'] ?? null,
                ]);
            }
        });

        return redirect()->route('routes.show', $route)
            ->with('success', 'Customers assigned to route successfully.');
    }

    /**
     * Remove a customer from a route.
     */
    public function removeCustomer(Route $route, Customer $customer)
    {
        $route->customers()->detach($customer->id);

        return redirect()->route('routes.show', $route)
            ->with('success', 'Customer removed from route successfully.');
    }

    /**
     * Get route data for DataTables.
     */
    public function getRoutes()
    {
        $routes = Route::withCount('customers')
            ->orderBy('day_of_week')
            ->orderBy('name')
            ->get();

        return response()->json($routes);
    }
}
