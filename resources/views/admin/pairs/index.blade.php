@extends('admin.layout')

@section('content')

<a href="{{ route('admin.pairs.create') }}" class="btn btn-primary">+ Add Pair</a>

<table class="w-full table-auto border-collapse border border-gray-700 mt-4">
    <thead>    
        <tr class="bg-gray-800">
            <th class="border border-gray-600 px-4 py-2">Symbol</th>
            <th class="border border-gray-600 px-4 py-2">Status</th>
            <th class="border border-gray-600 px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pairs as $pair)
        <tr class="bg-gray-700">
            <td  class="border border-gray-600 px-4 py-2">{{ $pair->symbol }}</td>

            <td  class="border border-gray-600 px-4 py-2">
                @if($pair->is_active)
                Active
                @else
                Disabled
                @endif
            </td>

            <td class=" flex border border-gray-600 px-4 py-2">
            <form action="{{ route('admin.pairs.toggle',$pair) }}" method="POST">
            @csrf
            <button class="btn btn-primary text-blue-500 hover:cursor-pointer" type="submit">Toggle</button>
            </form>

            <form action="{{ route('admin.pairs.destroy',$pair) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger text-red-500 hover:cursor-pointer" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection
