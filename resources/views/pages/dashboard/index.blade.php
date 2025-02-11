@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<!-- Include Navigation -->
@include('layouts.nav')

<!-- Include Sidebar -->
@include('layouts.sidebar')

<div class="p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <table id="export-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Name
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th data-type="date" data-format="YYYY/DD/MM">
                    <span class="flex items-center">
                        Release Date
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        NPM Downloads
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Growth
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Flowbite</td>
                <td>2021/25/09</td>
                <td>269000</td>
                <td>49%</td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">React</td>
                <td>2013/24/05</td>
                <td>4500000</td>
                <td>24%</td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Angular</td>
                <td>2010/20/09</td>
                <td>2800000</td>
                <td>17%</td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer">
                <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">Vue</td>
                <td>2014/12/02</td>
                <td>3600000</td>
                <td>30%</td>
            </tr>
        </tbody>
      </table>
   </div>
</div>


@endsection