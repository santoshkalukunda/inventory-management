<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(100);
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer = null)
    {
        if (!$customer) {
            $customer = new Customer;
        }
        return view('customer.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return redirect()->route('bills.store', compact('customer'))->with('success', 'Customer Registration Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $bills = $customer->bill()->get();
        $total = 0;
        $due = 0;
        $payment = 0;
        foreach ($bills as $bill) {
            if ($bill->status == "cancel") {
                continue;
            }
            $total = $total + $bill->net_total;
            $payment = $payment + $bill->payment;
            $due = $due + $bill->due;
        }
        $bills = $customer->bill()->latest()->paginate(200);
        return view('customer.show', compact('customer', 'bills', 'total', 'due', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return redirect()->back()->with('success', 'Customer Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->back()->with('success', 'Customer Information Deleted');
    }
    public function search(Request $request)
    {
        $customers = new Customer;

        if ($request->has('name')) {
            if ($request->name != null)
                $customers = $customers->where('name', 'LIKE', ["$request->name%"]);
        }
        if ($request->has('email')) {
            if ($request->email != null)
                $customers = $customers->where('email', 'LIKE', ["$request->email%"]);
        }
        if ($request->has('phone')) {
            if ($request->phone != null)
                $customers = $customers->where('phone', ["$request->phone"]);
        }
        if ($request->has('address')) {
            if ($request->address != null)
                $customers = $customers->where('address', 'LIKE', ["$request->address%"]);
        }
        if ($request->has('pan_vat')) {
            if ($request->pan_vat != null)
                $customers = $customers->where('pan_vat', ["$request->pan_vat"]);
        }
        // if ($request->has('age')) {
        //     if ($request->age != null)
        //         $customers = $customers->where('age', ["$request->age"]);
        // }
        $customers = $customers->when($request->has('age_min') && !is_null($request->age_min), function ($query) use ($request) {
            $query->where('age', '>=', $request->age_min);
        })
            ->when($request->has('age_max') && !is_null($request->age_max), function ($query) use ($request) {
                $query->where('age', '<=', (int)$request->age_max);
            });
        $customers = $customers->paginate(100000);
        return view('customer.index', compact('customers'));
    }
    public function find(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
        ]);
        $customer = Customer::findOrFail($request->customer_id);
        return redirect()->route('bills.store', $customer);
    }
}
