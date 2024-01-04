@extends('template')

@section('content')
<main class="max-w-[768px] mx-auto">
    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
{!! Form::open(['method' => 'POST', 'route' => 'save_transaction', 'enctype' => 'multipart/form-data']) !!}
<form>
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Add New Transaction</h2>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Transaction Type</label>
            <div class="mt-2">
                {!! Form::select('type', ['topup' => 'Top Up', 'transaction' => 'Transaction'], null, ['autocomplete' => 'off', 'required', 'class' => 'type block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6']) !!}
            </div>
          </div>
  
          <div class="sm:col-span-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Amount</label>
            <div class="mt-2">
                {!! Form::text('amount', null, ['autocomplete' => 'off', 'required', 'class' => 'number block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6']) !!}
            </div>
          </div>
  
          <div class="col-span-full">
            <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
            <div class="mt-2">
                {!! Form::text('description', null, ['autocomplete' => 'off', 'required', 'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6', 'maxlength' => 200]) !!}
            </div>
          </div>

          <div class="col-span-full receipt-container">
            <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Receipt</label>
            <div class="mt-2">
              {!! Form::file('receipt', ['accept' => 'image/jpg,image/jpeg,image/png']) !!}
            </div>
          </div>
      </div>
    </div>
  
    <div class="mt-6 flex items-center justify-end gap-x-6">
      <a href="{{ route('home') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
{!! Form::close() !!}
  
</main>
@endsection

@push('scripts')
<script type="text/javascript">
  $(function() {
    const receiptContainer = $('.receipt-container')
      if($('.type').val() == "topup") {
        if(receiptContainer.hasClass('hidden')) {
          receiptContainer.removeClass('hidden')
          receiptContainer.find('input').val('')
        }
      } else {
        if(!receiptContainer.hasClass('hidden')) receiptContainer.addClass('hidden')
      }

    $('.type').change(function (obj) {
      const $this = $(obj)
      const receiptContainer = $('.receipt-container')
      if(this.value == "topup") {
        if(receiptContainer.hasClass('hidden')) {
          receiptContainer.removeClass('hidden')
          receiptContainer.find('input').val('')
        }
      } else {
        if(!receiptContainer.hasClass('hidden')) receiptContainer.addClass('hidden')
      }
    })
  })
</script>
@endpush