{{-- Success alert --}}
<div class="fixed inset-x-0 z-20 w-1/2 h-24 p-4 ml-1 bg-green-200 rounded-md alert_suc inset-y-1 left-64" hidden>
    <div class="flex">
      <div class="flex-shrink-0">
        <!-- Heroicon name: solid/check-circle -->
        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3 alert_suc_body">
        <h3 class="text-sm font-medium text-green-800">Title</h3>
        <div class="mt-2 text-sm text-green-700">
          <p>Message</p>
        </div>
      </div>
    </div>
  </div>
  {{-- Error alert --}}
  <div class="fixed inset-x-0 z-20 w-1/2 h-24 p-4 bg-red-100 rounded-md alert_err inset-y-1 left-64" hidden>
    <div class="flex">
      <div class="flex-shrink-0">
        <!-- Heroicon name: solid/x-circle -->
        <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3 alert_err_body">
        <h3 class="text-sm font-medium text-red-800">Title</h3>
        <div class="mt-2 text-sm text-red-700">
            <p>Message</p>
        </div>
      </div>
    </div>
  </div>
