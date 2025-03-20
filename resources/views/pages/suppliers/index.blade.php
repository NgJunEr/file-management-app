@extends('layouts.app')
@section('title', 'Supplier List')
@section('content')

<!-- Include Navigation -->
@include('layouts.nav')

<!-- Include Sidebar -->
@include('layouts.sidebar')

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <!-- Create Supplier Button with Modal Trigger -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold dark:text-white">Supplier List</h2>
            <button data-modal-target="supplier-modal" data-modal-toggle="supplier-modal" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" 
                    type="button">
                Create New Supplier
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <div class="mt-2">
                <table id="export-table">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-black-100">Company Name</th>
                            <th scope="col" class="px-6 py-3">Contact Name</th>
                            <th scope="col" class="px-6 py-3">Notes</th>
                            <th scope="col" class="px-6 py-3">Created At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $supplier->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $supplier->contact}}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($supplier->note, 30) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $supplier->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" 
                                        class="edit-button" 
                                        data-supplier-id="{{ $supplier->id }}"
                                        data-name="{{ $supplier->name }}"
                                        data-contact="{{ $supplier->contact}}"
                                        data-note="{{ $supplier->note }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <!-- Delete Button -->
                                <button type="button" 
                                        class="delete-button text-red-600 hover:text-red-900" 
                                        data-supplier-id="{{ $supplier->id }}"
                                        data-contact-name="{{ $supplier->contact }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Supplier Modal -->
        <div id="supplier-modal" tabindex="-1" aria-hidden="true" 
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New Supplier
                        </h3>
                        <button type="button" 
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                data-modal-toggle="supplier-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form class="p-4 md:p-5" action="{{ route('suppliers.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Name -->
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                                <input type="text" name="name" id="name" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter company name" required>
                            </div>
                            
                            <!-- Contact Name -->
                            <div class="col-span-2">
                                <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Name</label>
                                <input type="text" name="contact" id="contact" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                       placeholder="Enter contact name" required>
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-span-2">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                <textarea id="note" name="note" rows="4" 
                                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                          placeholder="Write supplier notes here"></textarea>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Create Supplier
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal (Place outside the table) -->
        <div id="edit-supplier-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Supplier</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-supplier-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">...</svg>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <form id="edit-supplier-form" method="POST" class="p-4 md:p-5">
                        @csrf
                        @method('PUT')
                        <!-- Form Fields -->
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                                <input type="text" name="name" id="edit_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            </div>
                            <div class="col-span-2">
                                <label for="edit_contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Name</label>
                                <input type="text" name="contact" id="edit_contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                            </div>
                            <div class="col-span-2">
                                <label for="edit_note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                <textarea id="edit_note" name="note" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Supplier
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
        <div id="delete-confirmation-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-4 md:p-5 text-center">
                        <!-- Warning Icon -->
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <!-- Confirmation Message -->
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete <span id="delete-supplier-name" class="font-semibold text-gray-900 dark:text-white"></span>?
                        </h3>
                        <!-- Delete Form -->
                        <form id="delete-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- Confirm Button -->
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <!-- Cancel Button -->
                            <button type="button" data-modal-hide="delete-confirmation-modal" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                No, cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Logic
        const editButtons = document.querySelectorAll('.edit-button');
        const editModal = new Modal(document.getElementById('edit-supplier-modal'));
    
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get supplier data from data attributes
                const supplierId = button.getAttribute('data-supplier-id');
                const name = button.getAttribute('data-name');
                const contact = button.getAttribute('data-contact');
                const note = button.getAttribute('data-note');
    
                // Update form action
                document.getElementById('edit-supplier-form').action = `/suppliers/${supplierId}`;
    
                // Populate form fields
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_contact').value = contact;
                document.getElementById('edit_note').value = note;
    
                // Show modal
                editModal.show();
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Modal Logic
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteModal = new Modal(document.getElementById('delete-confirmation-modal'));
    
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get supplier data from data attributes
                const supplierId = button.getAttribute('data-supplier-id');
                const contactName = button.getAttribute('data-contact-name');
    
                // Update form action
                document.getElementById('delete-form').action = `/suppliers/${supplierId}`;
    
                // Display the contact name in the modal
                document.getElementById('delete-supplier-name').textContent = contactName;
    
                // Show modal
                deleteModal.show();
            });
        });
    });
</script>

@endsection