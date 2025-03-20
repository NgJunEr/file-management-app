@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<!-- Include Navigation -->
@include('layouts.nav')

<!-- Include Sidebar -->
@include('layouts.sidebar')

<div class="flex items-center justify-center h-screen w-full">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 flex flex-col items-center justify-center">
         <div aria-label="Orange and tan hamster running in a metal wheel" role="img" class="wheel-and-hamster">
             <div class="wheel"></div>
             <div class="hamster">
                 <div class="hamster__body">
                     <div class="hamster__head">
                         <div class="hamster__ear"></div>
                         <div class="hamster__eye"></div>
                         <div class="hamster__nose"></div>
                     </div>
                     <div class="hamster__limb hamster__limb--fr"></div>
                     <div class="hamster__limb hamster__limb--fl"></div>
                     <div class="hamster__limb hamster__limb--br"></div>
                     <div class="hamster__limb hamster__limb--bl"></div>
                     <div class="hamster__tail"></div>
                 </div>
             </div>
             <div class="spoke"></div>
         </div>
         <h2 class="mt-4 text-xl font-bold">Coming Soon</h2>
    </div>
 </div>
 


@endsection