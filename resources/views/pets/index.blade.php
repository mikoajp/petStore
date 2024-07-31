@extends('layouts.app')

@section('content')
    <h1>Pets</h1>
    <a href="{{ route('pets.create') }}" class="btn btn-primary">Add Pet</a>

    @if($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

    <ul>
        @foreach ($pets as $pet)
            <li>
                {{ $pet['name'] }}
                <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-secondary">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

