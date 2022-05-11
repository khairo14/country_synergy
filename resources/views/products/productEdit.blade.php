<div x-show="editproduct" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

      <div
       x-show="editproduct"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       x-description="Background overlay, show/hide based on modal state."
       @click="editproduct=!editproduct"
        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" style="display: none">
      </div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div
       x-show="editproduct"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
       x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
       x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
       x-description="Modal panel, show/hide based on modal state."
        class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-gray-100 rounded-lg shadow-xl ul_modal_body sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">

            <div class="sm:flex sm:items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit Product</h3>
                </div>
                <div class="mt-3 text-center rounded-lg sm:mt-0 sm:ml-4 sm:text-left">
                    <p class="px-4 text-sm font-medium leading-6 text-white bg-red-300" id="edit-modal-message"></p>
                </div>
            </div>

        <div class="mt-2 space-y-6 ul_form sm:space-y-5">
            <div>
                <input id="edit_prod_id" type="hidden" value=""/>
                <label for="edit_prod_code" class="block text-sm font-medium text-gray-700">Product Code</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_code" id="edit_prod_code" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="PLU">
                </div>
            </div>
            <div>
                <label for="edit_prod_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_name" id="edit_prod_name" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Product Name">
                </div>
            </div>
            <div>
                <label for="edit_prod_gtin" class="block text-sm font-medium text-gray-700">Gtin</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_gtin" id="edit_prod_gtin" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="GTIN">
                </div>
            </div>
            <div>
                <label for="edit_prod_brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_brand" id="edit_prod_brand" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Brand">
                </div>
            </div>
            <div>
                <label for="edit_prod_desc" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_desc" id="edit_prod_desc" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Description">
                </div>
            </div>
            <div>
                <label for="edit_prod_size" class="block text-sm font-medium text-gray-700">Size</label>
                <div class="mt-1 text-center">
                  <input type="text" name="edit_prod_size" id="edit_prod_size" class="block w-full p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Size">
                </div>
            </div>
        </div>

        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
          <button type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm edit_prod hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">Update</button>
          <button type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm" @click="editproduct=false">Cancel</button>
        </div>
      </div>
    </div>
</div>
