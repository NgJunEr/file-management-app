<?php

namespace App\Http\Controllers;

use App\Models\Pr;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;

class PrController extends Controller
{
    public function index()
    {
        $prs = Pr::with(['supplier', 'customer', 'products'])->get();
        return view('prs.index', compact('prs'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $customers = Customer::all();
        return view('prs.create', compact('suppliers', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'customer_id' => 'required|exists:customers,id',
            'customer_po' => 'required|string|max:255',
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
            'products.*.buying_price' => 'required|numeric',
            'products.*.selling_price' => 'required|numeric',
        ]);

        $pr = Pr::create($request->only(['date', 'supplier_id', 'customer_id', 'customer_po', 'note']));

        foreach ($request->products as $product) {
            $pr->products()->create($product);
        }

        return redirect()->route('prs.index')->with('success', 'PR created successfully.');
    }


    public function show(Pr $pr)
    {
        $pr->load(['supplier', 'customer', 'products']);
        return view('prs.show', compact('pr'));
    }

    public function edit(Pr $pr)
    {
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $pr->load('products');
        return view('prs.edit', compact('pr', 'suppliers', 'customers'));
    }

    public function update(Request $request, Pr $pr)
    {
        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'customer_id' => 'required|exists:customers,id',
            'customer_po' => 'required|string|max:255',
            'note' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer',
            'products.*.buying_price' => 'required|numeric',
            'products.*.selling_price' => 'required|numeric',
        ]);

        // Update PR
        $pr->update($request->only(['date', 'supplier_id', 'customer_id', 'customer_po', 'note']));

        // Delete existing products
        $pr->products()->delete();

        // Add new products
        foreach ($request->products as $product) {
            $pr->products()->create($product);
        }

        return redirect()->route('prs.index')->with('success', 'PR updated successfully.');
    }

    public function destroy(Pr $pr)
    {
        $pr->delete();
        return redirect()->route('prs.index')->with('success', 'PR deleted successfully.');
    }
}
