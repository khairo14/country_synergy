<div x-show="open" class="fixed inset-0 z-40 flex md:hidden" x-ref="dialog" :aria-modal="open">

    <div @click="open = false"
        x-show="open"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
        class="fixed inset-0 bg-gray-600 bg-opacity-75">
    </div>
    <div
        x-show="open"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        x-description="Off-canvas menu, show/hide based on off-canvas menu state."
        class="relative flex flex-col flex-1 w-full max-w-xs pt-5 pb-4 bg-gray-800">

      <div
        x-show="open"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-description="Close button, show/hide based on off-canvas menu state."
        class="absolute top-0 right-0 pt-2 -mr-12">

          <button @click="open = false" type="button" class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
              <span class="sr-only">Close sidebar</span>
              <!-- Heroicon name: outline/x -->
              <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :aria-hidden="!open">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>

      </div>

      <div class="flex items-center flex-shrink-0 px-4">
        <img class="w-auto h-10 mx-4 my-4" src="{{asset('img/cs-Logo.png')}}" alt="Workflow">
      </div>
      <div x-data={active:'{{Request::segment(1)}}'} class="flex flex-col flex-1 overflow-y-auto">
        <nav class="flex-1 px-2 py-4 space-y-1">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          <a href="{{url('/')}}" :class="{'bg-gray-900 text-white' : active==='home'}" class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group">
            <!--
              Heroicon name: outline/home

              Current: "text-gray-300", Default: "text-gray-400 group-hover:text-gray-300"
            -->
            <svg :class="{'text-gray-300': active ==='home'}" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
          </a>

          <a href="{{url('/location')}}" :class="{'bg-gray-900 text-white': active ==='location'}"class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white group">
            <!-- Heroicon name: outline/users -->
            <svg :class="{'text-gray-300': active ==='location'}" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Locations
          </a>

        </nav>
      </div>
    </div>

    <div class="flex-shrink-0 w-14" :aria-hidden="!open">
      <!-- Dummy element to force sidebar to shrink to fit close icon -->
    </div>
  </div>
