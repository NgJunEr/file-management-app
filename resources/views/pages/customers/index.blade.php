@extends('layouts.app')
@section('title', 'Customer List')
@section('content')

<!-- Include Navigation -->
@include('layouts.nav')

<!-- Include Sidebar -->
@include('layouts.sidebar')

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <!-- Create Customer Button with Modal Trigger -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold dark:text-white">Customer List</h2>
            <button data-modal-target="customer-modal" data-modal-toggle="customer-modal" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" 
                    type="button">
                Create New Customer
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <div class="mt-2">
                <table id="export-table">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Company Name</th>
                            <th scope="col" class="px-6 py-3">Contact Name</th>
                            <th scope="col" class="px-6 py-3">Notes</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $customer->company_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->contact_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($customer->note, 30) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="#" class="edit-button text-yellow-600 hover:text-yellow-900" 
                                data-customer='{{ json_encode($customer) }}'>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Customer Modal -->
        <div id="customer-modal" tabindex="-1" aria-hidden="true" 
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New Customer
                        </h3>
                        <button type="button" 
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                data-modal-toggle="customer-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form class="p-4 md:p-5" action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Company Name -->
                            <div class="col-span-2">
                                <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                                <input type="text" name="company_name" id="company_name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter company name" required>
                            </div>
                            
                            <!-- Contact Name -->
                            <div class="col-span-2">
                                <label for="contact_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Name</label>
                                <input type="text" name="contact_name" id="contact_name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter contact name" required>
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-span-2">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                <textarea id="note" name="note" rows="4" 
                                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                          placeholder="Write customer notes here"></textarea>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Create Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Customer Modal -->
        <div id="edit-customer-modal" tabindex="-1" aria-hidden="true" 
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Customer
                        </h3>
                        <button type="button" 
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                data-modal-toggle="edit-customer-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form id="edit-customer-form" class="p-4 md:p-5" action="{{ route('customers.update', ['customer' => ':id']) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updates -->
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Company Name -->
                            <div class="col-span-2">
                                <label for="edit_company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                                <input type="text" name="company_name" id="edit_company_name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter company name" required>
                            </div>
                            
                            <!-- Contact Name -->
                            <div class="col-span-2">
                                <label for="edit_contact_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Name</label>
                                <input type="text" name="contact_name" id="edit_contact_name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter contact name" required>
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-span-2">
                                <label for="edit_note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                <textarea id="edit_note" name="note" rows="4" 
                                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                          placeholder="Write customer notes here"></textarea>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Update Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to open the edit modal and populate it with customer data
    function openEditModal(customer) {
        // Set the form action URL
        document.getElementById('edit-customer-form').action = "{{ route('customers.update', ['customer' => ':id']) }}".replace(':id', customer.id);

        // Populate the form fields
        document.getElementById('edit_company_name').value = customer.company_name;
        document.getElementById('edit_contact_name').value = customer.contact_name;
        document.getElementById('edit_note').value = customer.note;

        // Open the modal
        const editModal = new Modal(document.getElementById('edit-customer-modal'));
        editModal.show();
    }

    // Attach click event to edit buttons
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const customer = JSON.parse(button.getAttribute('data-customer'));
            openEditModal(customer);
        });
    });
</script>

@endsection