<?php

namespace App\Http\Controllers;

use App\Models\Pr;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrController extends Controller
{
    public function index()
    {
        $prs = Pr::with(['supplier', 'customer', 'products'])->orderBy('date', 'desc')->get();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        
        // Pass data as JSON for JavaScript
        return view('pages.purchase-requisitions.index', [
            'prs' => $prs,
            'suppliers' => $suppliers,
            'customers' => $customers,
            'prs_json' => $prs->toJson()
        ]);
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
            'products.*.product_name' => 'required|string|max:255', // Ensure product_name is required
            'products.*.quantity' => 'required|integer|min:1', // Ensure quantity is a positive integer
            'products.*.uom' => 'required|string|max:255', // Ensure uom is required
            'products.*.buying_price' => 'required|numeric|min:0', // Ensure buying_price is non-negative
            'products.*.selling_price' => 'required|numeric|min:0', // Ensure selling_price is non-negative
        ]);

        // Create the PR
        $pr = Pr::create($request->only(['date', 'supplier_id', 'customer_id', 'customer_po', 'note']));

        // Add products to the PR
        foreach ($request->products as $product) {
            $pr->products()->create([
                'product_name' => $product['product_name'],
                'quantity' => $product['quantity'],
                'uom' => $product['uom'],
                'buying_price' => $product['buying_price'],
                'selling_price' => $product['selling_price'],
            ]);
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
            'products.*.product_name' => 'required|string|max:255', // Ensure product_name is required
            'products.*.quantity' => 'required|integer|min:1', // Ensure quantity is a positive integer
            'products.*.uom' => 'required|string|max:255', // Ensure moq is required
            'products.*.buying_price' => 'required|numeric|min:0', // Ensure buying_price is non-negative
            'products.*.selling_price' => 'required|numeric|min:0', // Ensure selling_price is non-negative
        ]);

        // Update the PR
        $pr->update($request->only(['date', 'supplier_id', 'customer_id', 'customer_po', 'note']));

        // Delete existing products
        $pr->products()->delete();

        // Add new products
        foreach ($request->products as $product) {
            $pr->products()->create([
                'product_name' => $product['product_name'],
                'quantity' => $product['quantity'],
                'uom' => $product['uom'],
                'buying_price' => $product['buying_price'],
                'selling_price' => $product['selling_price'],
            ]);
        }

        return redirect()->route('prs.index')->with('success', 'PR updated successfully.');
    }

    public function destroy(Pr $pr)
    {
        $pr->delete();
        return redirect()->route('prs.index')->with('success', 'PR deleted successfully.');
    }

    public function exportSQL()
    {
        return new StreamedResponse(function () {
            // Get all PRs with relationships
            $prs = Pr::with(['supplier', 'customer', 'products'])->get();

            // Open output stream
            $handle = fopen('php://output', 'w');

            // Write headers
            fwrite($handle, "-- SUPPLIERS --\n");
            foreach ($prs->pluck('supplier')->unique() as $supplier) {
                fwrite($handle, "INSERT INTO suppliers (id, name, contact, note) VALUES ("
                    . "$supplier->id, "
                    . "'" . addslashes($supplier->name) . "', "
                    . "'" . addslashes($supplier->contact) . "', "
                    . ($supplier->note ? "'" . addslashes($supplier->note) . "'" : "NULL")
                    . ");\n");
            }

            // Similar blocks for customers, prs, and products
            // ... (rest of the SQL generation logic)

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/sql',
            'Content-Disposition' => 'attachment; filename="pr_export.sql"',
        ]);
    }
}