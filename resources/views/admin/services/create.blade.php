@extends('admin.layouts.admin')

@section('title', 'Ajouter un service')

@section('content')

<h3>Ajouter un service</h3>

<form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Titre</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
</div>


    <button class="btn btn-success">Enregistrer</button>
</form>

@endsection
