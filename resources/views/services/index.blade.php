<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-5">Nos services dentaires</h2>

    <div class="row">
        @forelse($services as $service)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->title }}</h5>
                        @if($service->image)
    <img src="{{ asset('storage/'.$service->image) }}" class="card-img-top" style="height:200px; object-fit:cover;">
@endif

                        <p class="card-text">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Aucun service disponible.</p>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="/rendez-vous" class="btn btn-primary">
            Prendre rendez-vous
        </a>
    </div>
</div>

</body>
</html>
