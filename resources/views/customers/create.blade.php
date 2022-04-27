@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto mt-8">
        <div class="mb-4">
            <h1 class="text-3xl font-bold">
                Add New Post
            </h1>
            <div class="flex justify-end mt-5">
                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('customers.index') }}">< Back</a>
            </div>
        </div>

        <div class="flex flex-col mt-5">
            <div class="flex flex-col">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">

                    @if ($errors->any())
                        <div class="p-3 rounded bg-red-500 text-white m-3">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">

                        <form action="{{ route('customers.store') }}" method="POST">
                            @csrf

                            <div>
                                <label class="block text-sm font-bold text-gray-700" for="title">Customer Name</label>
                                <input type="text" name="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Name">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700" for="title">Contact Person</label>
                                <input type="text" name="contact_person" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contact Person">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Street:</label>
                                <input type="text" name="street" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Street">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">City:</label>
                                <input type="text" name="city" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="City">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">State:</label>
                                <input type="text" name="state" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="State">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Phone:</label>
                                <input type="text" name="phone" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Phone">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Gtin Start:</label>
                                <input type="number" name="gtin_start" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Gtin Start">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700" for="title">Gtin End:</label>
                                <input type="number" name="gtin_end" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Gtin End">
                            </div>

                            <div class="flex items-center justify-start mt-4 gap-x-2">
                                <button type="submit" class="px-6 py-2 text-sm font-semibold rounded-md shadow-md text-green-100 bg-green-500 hover:bg-green-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
