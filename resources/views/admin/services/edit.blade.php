@extends('admin.layouts.admin')

@section('title', 'Modifier service')

@section('content')

<h3>Modifier le service</h3>

<form method="POST" action="{{ route('services.update', $service) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Titre</label>
        <input type="text" name="title" value="{{ $service->title }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required>{{ $service->description }}</textarea>
    </div>

    <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
</div>

@if($service->image)
    <img src="{{ asset('storage/'.$service->image) }}" width="100" class="mt-2">
@endif


    <button class="btn btn-primary">Mettre à jour</button>
</form>

@endsection
