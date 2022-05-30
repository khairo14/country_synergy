<!-- This example requires Tailwind CSS v2.0+ -->
<div x-data="{printmodal:false}" x-show="printmodal" class="relative z-10" id="printModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none">
    <div
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-description="Background overlay, show/hide based on modal state."
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed z-10 inset-0 overflow-y-auto">
      <div x-show="printmodal" @click="printmodal=!printmodal" id="printModalBody" class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0" style="display: none">
        <div
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-description="Modal panel, show/hide based on modal state."
            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-sm sm:w-full sm:p-6">
          <div class="print_table">


          </div>
      </div>
    </div>
  </div>
