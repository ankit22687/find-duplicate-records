@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4">
    
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Duplicate {{ ucfirst($type)}}</h1>
    </div>

    <div class="mb-4 ">
        <form class="flex flex-row gap-2 w-full" method="post" action="{{route('merge_duplicate_records')}}">
            @csrf
            <input type="hidden" name="type" value="{{$type}}" />
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Merge Duplicate Records</button>
        </form>
    </div>
    @if($type == 'doctors' && isset($duplicateRecords) && $duplicateRecords->isNotEmpty())
    <br>
    <p class="text-sm text-gray-700 leading-5">{{$duplicateRecords->count()}} duplicate records found</p>
        <br>
    <table class="bg-white w-full border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Specialty</th>
                    <th class="border px-4 py-2">Duplicate count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($duplicateRecords as $doctor)
                    <tr>
                        <td class="border px-4 py-2">{{ $doctor->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->specialty }}</td>
                        <td class="border px-4 py-2">{{ $doctor->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if($type == 'clinics' && isset($duplicateRecords) && $duplicateRecords->isNotEmpty())
    <br>
    <p class="text-sm text-gray-700 leading-5">{{$duplicateRecords->count()}} duplicate records found</p>
        <br>
    <table class="bg-white w-full border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Address</th>
                    <th class="border px-4 py-2">Duplicate count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($duplicateRecords as $clinic)
                    <tr>
                        <td class="border px-4 py-2">{{ $clinic->name }}</td>
                        <td class="border px-4 py-2">{{ $clinic->address }}</td>
                        <td class="border px-4 py-2">{{ $clinic->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
</div>
@endsection
