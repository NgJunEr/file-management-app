@extends('layouts.app')
@section('title', 'Purchase Requisition List')
@section('content')

<!-- Include Navigation -->
@include('layouts.nav')

<!-- Include Sidebar -->
@include('layouts.sidebar')

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <!-- Header and Create Button -->
        <!-- Header Container (Outside Scrollable Area) -->
        <div class="flex justify-between items-center mb-4 relative z-40">
            <h2 class="text-2xl font-bold dark:text-white">Purchase Requisition List</h2>
            <button data-modal-target="pr-modal" data-modal-toggle="pr-modal" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Create New PR
            </button>
        </div>
        
        <div class="overflow-x-auto relative">
            <div class="mt-2">
                <table id="export-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">PR ID</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Supplier</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">PO Number</th>
                            <th class="px-6 py-3">Product Name</th>
                            <th class="px-6 py-3">Quantity</th>
                            <th class="px-6 py-3">Buying Price</th>
                            <th class="px-6 py-3">Selling Price</th>
                            <th class="px-6 py-3">Note</th>
                            <th class="px-6 py-3">Actions</th>
                            <th class="hidden">Supplier Contact</th>
                            <th class="hidden">Customer Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prs as $pr)
                            @foreach ($pr->products as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <!-- PR Information -->
                                <td class="px-6 py-4">{{ $pr->id }}</td>
                                <td class="px-6 py-4">{{ $pr->date }}</td>
                                <td class="px-6 py-4">{{ $pr->supplier->name }}</td>
                                <td class="px-6 py-4">{{ $pr->customer->company_name }}</td>
                                <td class="px-6 py-4">{{ $pr->customer_po }}</td>
                                
                                <!-- Product Information -->
                                <td class="px-6 py-4">{{ $product->product_name }}</td>
                                <td class="px-6 py-4">{{ $product->quantity }}</td>
                                <td class="px-6 py-4">${{ number_format($product->buying_price, 2) }}</td>
                                <td class="px-6 py-4">${{ number_format($product->selling_price, 2) }}</td>
                                <td class="px-6 py-4">{{ Str::limit($pr->note, 1000) }}</td>

                                <!-- Cus & Sup Information -->
                                <td class="hidden">{{ $pr->supplier->contact }}</td>
                                <td class="hidden">{{ $pr->customer->contact_name }}</td>
                                
                                <!-- Actions -->
                                <td class="px-6 py-4 flex space-x-2">
                                    @if($loop->first)
                                    <!-- Show actions only on first product row -->
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            class="edit-pr" 
                                            data-pr="{{ json_encode($pr) }}" 
                                            data-products="{{ json_encode($pr->products) }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            class="delete-pr text-red-600 hover:text-red-900" 
                                            data-pr-id="{{ $pr->id }}" 
                                            data-customer-po="{{ $pr->customer_po }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Create PR Modal -->
            <div id="pr-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-4xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold dark:text-white">Create New Purchase Requisition</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="pr-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form class="p-4 md:p-5" action="{{ route('prs.store') }}" method="POST">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <!-- Basic Info -->
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                    <input type="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer PO</label>
                                    <input type="text" name="customer_po" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                                    <select name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer</label>
                                    <select name="customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Products Section -->
                                <div class="col-span-2 mt-4">
                                    <h4 class="text-lg font-semibold mb-2">Products</h4>
                                    <div id="product-fields" class="space-y-4">
                                        <div class="product-row flex gap-4 items-center">
                                            <input type="text" name="products[0][product_name]" placeholder="Product Name" class="flex-1" required>
                                            <input type="number" name="products[0][quantity]" placeholder="Qty" class="w-24" required>
                                            <input type="number" step="0.01" name="products[0][buying_price]" placeholder="Buy Price" class="w-32" required>
                                            <input type="number" step="0.01" name="products[0][selling_price]" placeholder="Sell Price" class="w-32" required>
                                            <button type="button" class="remove-product text-red-500 hover:text-red-700">×</button>
                                        </div>
                                    </div>
                                    <button type="button" id="add-product" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                        + Add Product
                                    </button>
                                </div>

                                <!-- Note -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                                    <textarea name="note" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Create PR
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Edit PR Modal -->
            <div id="edit-pr-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-4xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold dark:text-white">Edit Purchase Requisition</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-pr-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form id="edit-pr-form" method="POST" class="p-4 md:p-5">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <!-- Basic Info -->
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                    <input type="date" name="date" id="edit_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer PO</label>
                                    <input type="text" name="customer_po" id="edit_customer_po" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                                    <select name="supplier_id" id="edit_supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer</label>
                                    <select name="customer_id" id="edit_customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Products Section -->
                                <div class="col-span-2 mt-4">
                                    <h4 class="text-lg font-semibold mb-2">Products</h4>
                                    <div id="edit-product-fields" class="space-y-4">
                                        <!-- Product rows will be added dynamically -->
                                    </div>
                                    <button type="button" id="add-edit-product" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                        + Add Product
                                    </button>
                                </div>

                                <!-- Note -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                                    <textarea name="note" id="edit_note" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Update PR
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Confirmation Modal -->
            <div id="delete-pr-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="p-4 md:p-5 text-center">
                            <!-- Warning Icon -->
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <!-- Confirmation Message -->
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                Are you sure you want to delete PR with PO Number: <span id="delete-pr-po" class="font-semibold text-gray-900 dark:text-white"></span>?
                            </h3>
                            <!-- Delete Form -->
                            <form id="delete-pr-form" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Confirm Button -->
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                                <!-- Cancel Button -->
                                <button type="button" data-modal-hide="delete-pr-modal" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    No, cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Initialize modals
    const editModal = new Modal(document.getElementById('edit-pr-modal'));
    const deleteModal = new Modal(document.getElementById('delete-pr-modal'));

    // Add Product Functionality (Create Modal)
    const productFields = document.getElementById('product-fields');
    const addProductButton = document.getElementById('add-product');
    let productCount = 1;

    if (addProductButton) {
        addProductButton.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.className = 'product-row flex gap-4 items-center mt-2';
            newRow.innerHTML = `
                <input type="text" name="products[${productCount}][product_name]" placeholder="Product Name" class="flex-1" required>
                <input type="number" name="products[${productCount}][quantity]" placeholder="Qty" class="w-24" required>
                <input type="number" step="0.01" name="products[${productCount}][buying_price]" placeholder="Buy Price" class="w-32" required>
                <input type="number" step="0.01" name="products[${productCount}][selling_price]" placeholder="Sell Price" class="w-32" required>
                <button type="button" class="remove-product text-red-500 hover:text-red-700">×</button>
            `;
            productFields.appendChild(newRow);
            productCount++;
        });
    }

    // Remove Product Functionality (Create Modal)
    if (productFields) {
        productFields.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
            }
        });
    }

    // Edit Modal Functionality
    const editButtons = document.querySelectorAll('.edit-pr');
    const editProductFields = document.getElementById('edit-product-fields');
    let editProductCount = 0;

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pr = JSON.parse(this.dataset.pr);
            const products = JSON.parse(this.dataset.products);

            // Populate PR fields
            document.getElementById('edit_date').value = pr.date;
            document.getElementById('edit_customer_po').value = pr.customer_po;
            document.getElementById('edit_supplier_id').value = pr.supplier_id;
            document.getElementById('edit_customer_id').value = pr.customer_id;
            document.getElementById('edit_note').value = pr.note;

            // Update form action
            document.getElementById('edit-pr-form').action = `/prs/${pr.id}`;

            // Clear existing product rows
            editProductFields.innerHTML = '';

            // Add product rows
            products.forEach((product, index) => {
                const row = document.createElement('div');
                row.className = 'product-row flex gap-4 items-center mt-2';
                row.innerHTML = `
                    <input type="text" name="products[${index}][product_name]" value="${product.product_name}" class="flex-1" required>
                    <input type="number" name="products[${index}][quantity]" value="${product.quantity}" class="w-24" required>
                    <input type="number" step="0.01" name="products[${index}][buying_price]" value="${product.buying_price}" class="w-32" required>
                    <input type="number" step="0.01" name="products[${index}][selling_price]" value="${product.selling_price}" class="w-32" required>
                    <button type="button" class="remove-product text-red-500 hover:text-red-700">×</button>
                `;
                editProductFields.appendChild(row);
            });

            // Reset editProductCount to the number of existing products
            editProductCount = products.length;

            // Show edit modal
            editModal.show();
        });
    });

    // Add Product Functionality (Edit Modal)
    const addEditProductButton = document.getElementById('add-edit-product');

    if (addEditProductButton) {
        addEditProductButton.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.className = 'product-row flex gap-4 items-center mt-2';
            newRow.innerHTML = `
                <input type="text" name="products[${editProductCount}][product_name]" placeholder="Product Name" class="flex-1" required>
                <input type="number" name="products[${editProductCount}][quantity]" placeholder="Qty" class="w-24" required>
                <input type="number" step="0.01" name="products[${editProductCount}][buying_price]" placeholder="Buy Price" class="w-32" required>
                <input type="number" step="0.01" name="products[${editProductCount}][selling_price]" placeholder="Sell Price" class="w-32" required>
                <button type="button" class="remove-product text-red-500 hover:text-red-700">×</button>
            `;
            editProductFields.appendChild(newRow);
            editProductCount++;
        });
    }

    // Remove Product Functionality (Edit Modal)
    if (editProductFields) {
        editProductFields.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-row').remove();
                editProductCount = Math.max(0, editProductCount - 1); // Decrement counter
            }
        });
    }

    // Delete Modal Functionality
    document.addEventListener('click', function (e) {
        if (e.target.closest('.delete-pr')) {
            const button = e.target.closest('.delete-pr');
            const prId = button.dataset.prId;
            const customerPo = button.dataset.customerPo;

            // Update form action
            document.getElementById('delete-pr-form').action = `/prs/${prId}`;

            // Set PO number in modal
            document.getElementById('delete-pr-po').textContent = customerPo;

            // Show modal
            deleteModal.show();
        }
    });
});
</script>


@endsection