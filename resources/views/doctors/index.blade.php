@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Doctors</h1>
            <div>
                <a href="{{ route('find_duplicate_records',['type' => 'doctors']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Find Duplicate Doctors</a>
                    <a href="{{ route('find_duplicate_records',['type' => 'clinics']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Find Duplicate Clinics</a>
                <a href="{{ route('doctors.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Doctor</a>
            </div>
        </div>
        <hr>
        <br>
        @if (session('status'))
            <div class="w-full text-green-500">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="w-full text-red-500">
                {{ session('error') }}
            </div>
        @endif
        <br>
        {{ $doctors->links() }}
        <br>
        <hr>
        <table class="bg-white w-full border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Updated</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Specialty</th>
                    <th class="border px-4 py-2">Clinic Name</th>
                    <th class="border px-4 py-2">Clinic Address</th>
                    <th class="border px-4 py-2"># Tests</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td class="border px-4 py-2">{{ $doctor->id }}</td>
                        <td class="border px-4 py-2">{{ $doctor->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td class="border px-4 py-2">{{ $doctor->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->specialty }}</td>
                        <td class="border px-4 py-2">{{ $doctor->clinic->name }}</td>
                        <td class="border px-4 py-2">{{ $doctor->clinic->address }}</td>
                        <td class="border px-4 py-2">{{ $doctor->tests_count }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('doctors.show', $doctor) }}" class="text-blue-500">View</a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="text-green-500">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
