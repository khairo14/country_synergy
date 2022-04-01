@extends('layouts.app')
  
@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                Show Post
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('customers.index') }}">< Back</a>
            </div>
        </div>
   
        <div class="flex flex-col mt-5">
            <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                <h3 class="text-2xl font-semibold">{{ $customer->name }}</h3>
                <p class="text-base text-gray-700 mt-5">{{ $customer->contact_person }}</p>
                <p class="text-base text-gray-700 mt-5">{{ $customer->street }}</p>
                <p class="text-base text-gray-700 mt-5">{{ $customer->city }}</p>
                <p class="text-base text-gray-700 mt-5">{{ $customer->state }}</p>
                <p class="text-base text-gray-700 mt-5">{{ $customer->phone }}</p>
            </div>
        </div>
    </div>
@endsection