<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="{{asset('css/jquery.multiselect.css')}}"> --}}
        {{-- End Styles --}}
        {{-- scripts --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script defer src="https://unpkg.com/alpinejs@3.9.5/dist/cdn.min.js"></script>
        {{-- <script src="https://cdn.tailwindcss.com/?plugins=forms"></script> --}}
        {{-- end scripts --}}
    </head>
<body class="min-h-full overflow-auto antialiased bg-gray-100">
<div x-data="{open:false}" @keydown.window.escape="open = false">
    <div x-show="open" class="fixed inset-0 z-40 flex md:hidden" x-ref="dialog" aria-modal="true">

      <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-75" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." @click="open = false" aria-hidden="true">
      </div>
      <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-description="Off-canvas menu, show/hide based on off-canvas menu state."
        class="relative flex flex-col flex-1 w-full max-w-xs pt-5 pb-4 bg-gray-800">

        <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Close button, show/hide based on off-canvas menu state."
            class="absolute top-0 right-0 pt-2 -mr-12">
            <button type="button" class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="open = false">
                <span class="sr-only">Close sidebar</span>
                <!-- Heroicon name: outline/x -->
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex items-center flex-shrink-0 px-4">
          <img class="w-auto h-10 mx-4 my-4" src="{{asset('img/cs-Logo.png')}}" alt="Workflow">
        </div>
        <div class="flex-1 h-0 mt-5 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1" aria-label="Sidebar">
                <div>
                    <a href="/" class="flex items-center px-2 py-2 text-sm font-medium text-white bg-gray-900 rounded-md group">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </div>
                <div>
                    <a href="/products" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-gray-800 rounded-md hover:bg-gray-700 hover:text-white group" x-state:on="Current" x-state:off="Default">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                          </svg>
                        Products
                    </a>
                </div>

                <div x-data="{open:false}" class="space-y-1">
                    <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                      x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                      <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                      <span class="flex-1">
                        Orders
                      </span>
                      <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                      </svg>
                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div class="space-y-1" id="sub-menu-5" x-show="open">
                      <a href="/orders" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> View Orders </a>

                      <a href="/createOrder" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Create Order </a>
                    </div>
                </div>

                <div x-data="{open:false}" class="space-y-1">
                    <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                      x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                      <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                      <span class="flex-1">
                        Stocks
                      </span>
                      <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                      </svg>
                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div class="space-y-1" id="sub-menu-5" x-show="open">
                      <a href="/stocks" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> View Stocks </a>

                      {{-- <a href="/createOrder" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Create Order </a> --}}
                    </div>
                </div>

                <div>
                    <a href="/customers" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-gray-800 rounded-md hover:bg-gray-700 hover:text-white group" x-state:on="Current" x-state:off="Default">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Customers
                    </a>
                </div>

                <div>
                    <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-indigo-100 rounded-md hover:bg-indigo-600 group">
                    <!-- Heroicon name: outline/inbox -->
                    <svg class="flex-shrink-0 w-6 h-6 mr-4 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    Pallet Label
                  </a>
                </div>

                <div x-data="{open:false}" class="space-y-1">
                    <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                      x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                      <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                      <span class="flex-1">
                        Reports
                      </span>
                      <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                      </svg>
                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div class="space-y-1" id="sub-menu-5" x-show="open">
                      <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Overview </a>

                      <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Members </a>

                      <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Calendar </a>

                      <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Settings </a>
                    </div>
                  </div>
              </nav>
        </div>
      </div>

      <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
      </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-1 min-h-0 bg-gray-800">
        <div class="flex items-center flex-shrink-0 h-16 px-4 bg-gray-900">
          <img class="w-auto h-10 mx-4 my-4" src="{{asset('img/cs-Logo.png')}}" alt="Workflow">
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1 aria-label="Sidebar">
                <div>
                    <a href="/" class="flex items-center px-2 py-2 text-sm font-medium text-white bg-gray-900 rounded-md group" x-state:on="Current" x-state:off="Default">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </div>
                <div>
                    <a href="/products" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-gray-800 rounded-md hover:bg-gray-700 hover:text-white group" x-state:on="Current" x-state:off="Default">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                          </svg>
                        Products
                    </a>
                </div>
                <div x-data="{open:false}" class="space-y-1">
                    <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                      x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                      <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                      <span class="flex-1">
                        Orders
                      </span>
                      <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                      </svg>
                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div class="space-y-1" id="sub-menu-5" x-show="open">
                      <a href="/orders" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> View Orders </a>

                      <a href="/createOrder" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Create Order </a>
                    </div>
                </div>
                <div x-data="{open:false}" class="space-y-1">
                    <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                      x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                      <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                      <span class="flex-1">
                        Stocks
                      </span>
                      <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                      </svg>
                    </button>
                    <!-- Expandable link section, show/hide based on state. -->
                    <div class="space-y-1" id="sub-menu-5" x-show="open">
                      <a href="/stocks" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> View Stocks </a>

                      {{-- <a href="/createOrder" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Create Order </a> --}}
                    </div>
                </div>

                <div>
                    <a href="/customers" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-gray-800 rounded-md hover:bg-gray-700 hover:text-white group" x-state:on="Current" x-state:off="Default">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
                        -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Customers
                    </a>
                </div>

                <div>
                    <a href="/palletlabels" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group">
                    <!-- Heroicon name: outline/inbox -->
                    <svg class="flex-shrink-0 w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>

                    Pallet Labels
                  </a>
                </div>

                <div x-data="{open:false}" class="space-y-1">
                  <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-left text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-controls="sub-menu-5" aria-expanded="false"
                    x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-5" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                    <svg class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/chart-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="flex-1">
                      Reports
                    </span>
                    <svg class="flex-shrink-0 w-5 h-5 ml-3 text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                      <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                    </svg>
                  </button>
                  <!-- Expandable link section, show/hide based on state. -->
                  <div class="space-y-1" id="sub-menu-5-static" x-show="open">
                    <a href="{{url('/products')}}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Overview </a>

                    <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Members </a>

                    <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Calendar </a>

                    <a href="#" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-white rounded-md group pl-11 hover:text-gray-400 hover:bg-gray-500"> Settings </a>
                  </div>
                </div>

              </nav>
        </div>
      </div>
    </div>
    {{-- Top layout --}}
    <div class="flex flex-col md:pl-64">
      <div class="sticky top-0 z-10 flex flex-shrink-0 h-16 bg-white shadow">
        <button type="button" class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="open = true">
          <span class="sr-only">Open sidebar</span>
          <!-- Heroicon name: outline/menu-alt-2 -->
          <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
        <div class="flex justify-between flex-1 px-4">
          <div class="flex flex-1">
            {{-- <img class="w-auto h-8 my-4" src="{{asset('img/Country-Synergy-Logo.png')}}" alt="Workflow"> --}}
          </div>
          <div class="flex items-center ml-4 md:ml-6">
            <button type="button" class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">View notifications</span>
              <!-- Heroicon name: outline/bell -->
              <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative ml-3">
                <div>
                  <button type="button" class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                    <span class="sr-only">Open user menu</span>
                    <span class="inline-block w-8 h-8 overflow-hidden bg-gray-100 rounded-full">
                        <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                  </button>
                </div>

                  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()" style="display: none;">

                      <a href="#" class="block px-4 py-2 text-sm text-gray-700" x-state:on="Active" x-state:off="Not Active" :class="{ 'bg-gray-100': activeIndex === 0 }" role="menuitem" tabindex="-1" id="user-menu-item-0" @mouseenter="activeIndex = 0" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Your Profile</a>

                      <a href="#" class="block px-4 py-2 text-sm text-gray-700" :class="{ 'bg-gray-100': activeIndex === 1 }" role="menuitem" tabindex="-1" id="user-menu-item-1" @mouseenter="activeIndex = 1" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Settings</a>

                      <a href="/" onclick="event.preventDefault();" class="block px-4 py-2 text-sm text-gray-700 logout" :class="{ 'bg-gray-100': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="activeIndex = 2" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Sign out</a>

                  </div>

            </div>
          </div>
        </div>
      </div>

      <main class="flex-1">
        <div class="p-2">
            @yield('content')
        </div>
      </main>
    </div>
  </div>


</body>

{{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- end scripts --}}
</html>
