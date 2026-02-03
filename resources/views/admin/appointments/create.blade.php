<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">Prendre rendez-vous</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nom complet</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date souhaitée</label>
            <input type="date" name="appointment_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Message (optionnel)</label>
            <textarea name="message" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Envoyer
        </button>
    </form>
</div>

</body>
</html>
