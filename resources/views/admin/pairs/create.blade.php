@extends('admin.layout')

@section('content')

<h2>Add Trading Pair</h2>

<form action="{{ route('admin.pairs.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div>
<label class="block text-sm font-medium mb-1">Base Asset</label>
<input class="block w-60 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" name="base_asset" placeholder="BTC" required>
</div>
<div>
<label class="block text-sm font-medium mb-1">Quote Asset</label>
<input class="block w-60 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" name="quote_asset" placeholder="USDT" required>
</div>
<div>
<label class="block text-sm font-medium mb-1">Pair Icon</label>
<input type="file" name="icon">
<div>
<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Pair</button>
</div>
</form>


@endsection
