@extends('template')

@section('content')
<main class="max-w-[1024px] mx-auto">
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto flex max-w-sm flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-600">Current Balance</dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Rp {{ number_format(auth()->user()->balance, 2, ',', '.') }}</dd>
              </div>
        </div>
      </div>
    
      
    <div class="flex justify-end mb-[24px]">
        <div>
            <a href="{{ route('add_transaction') }}" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add New Transaction</a>
        </div>
    </div>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Code</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</main>
@endsection

@push('scripts')
<script>
    $(function () {

var table = $('.yajra-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('transaction_list') }}",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'transaction_code', name: 'transaction_code'},
        {data: 'type', name: 'type', orderable: false, searchable: false},
        {data: 'amount', name: 'amount', orderable: false, searchable: false},
        {data: 'description', name: 'description', orderable: false},
        {
            data: 'action', 
            name: 'action', 
            orderable: false, 
            searchable: false
        },
    ]
});

});
</script>
@endpush