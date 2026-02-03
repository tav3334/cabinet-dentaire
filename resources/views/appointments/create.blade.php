<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
            padding: 60px 0;
        }
        .form-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .service-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .service-card.selected {
            border-color: #0d6efd;
            background-color: #f0f7ff;
        }
        .time-slot {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .time-slot:hover {
            background-color: #e9ecef;
        }
        .time-slot.selected {
            background-color: #0d6efd !important;
            color: white !important;
        }
        .time-slot.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-light">

<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-5 fw-bold mb-3">
            <i class="bi bi-calendar-check me-2"></i>Prendre rendez-vous
        </h1>
        <p class="lead mb-0">Réservez votre consultation en quelques clics</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card form-card border-0">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
                        @csrf

                        <!-- Étape 1: Choix du service -->
                        <div class="mb-5">
                            <h4 class="mb-4">
                                <span class="badge bg-primary rounded-circle me-2">1</span>
                                Choisissez un service
                            </h4>
                            <div class="row g-3">
                                @foreach($services as $service)
                                    <div class="col-md-6">
                                        <div class="card service-card h-100" onclick="selectService({{ $service->id }}, this)">
                                            <div class="card-body">
                                                @if($service->image)
                                                    <img src="{{ asset('storage/'.$service->image) }}"
                                                         class="img-fluid rounded mb-3"
                                                         style="height: 120px; width: 100%; object-fit: cover;">
                                                @endif
                                                <h6 class="card-title mb-2">{{ $service->title }}</h6>
                                                <p class="card-text small text-muted">{{ Str::limit($service->description, 80) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="service_id" id="service_id" value="{{ old('service_id') }}">
                        </div>

                        <!-- Étape 2: Date et heure -->
                        <div class="mb-5">
                            <h4 class="mb-4">
                                <span class="badge bg-primary rounded-circle me-2">2</span>
                                Choisissez la date et l'heure
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="appointment_date" class="form-label">Date souhaitée</label>
                                    <input type="date"
                                           class="form-control form-control-lg"
                                           id="appointment_date"
                                           name="appointment_date"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           value="{{ old('appointment_date') }}"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Heure souhaitée</label>
                                    <div class="d-flex flex-wrap gap-2" id="timeSlots">
                                        @foreach(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'] as $time)
                                            <button type="button"
                                                    class="btn btn-outline-secondary time-slot {{ old('appointment_time') == $time ? 'selected' : '' }}"
                                                    onclick="selectTime('{{ $time }}', this)">
                                                {{ $time }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="appointment_time" id="appointment_time" value="{{ old('appointment_time') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3: Informations personnelles -->
                        <div class="mb-5">
                            <h4 class="mb-4">
                                <span class="badge bg-primary rounded-circle me-2">3</span>
                                Vos informations
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text"
                                           class="form-control"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Jean Dupont"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="tel"
                                           class="form-control"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="06 12 34 56 78"
                                           required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email (optionnel)</label>
                                    <input type="email"
                                           class="form-control"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="jean.dupont@email.com">
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message ou informations complémentaires</label>
                                    <textarea class="form-control"
                                              id="message"
                                              name="message"
                                              rows="3"
                                              placeholder="Décrivez brièvement la raison de votre visite...">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-calendar-plus me-2"></i>Confirmer le rendez-vous
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations du cabinet -->
            <div class="card mt-4 border-0 bg-white shadow-sm">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <i class="bi bi-geo-alt text-primary fs-3"></i>
                            <p class="mb-0 mt-2">123 Rue de la Santé<br>75000 Paris</p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <i class="bi bi-telephone text-primary fs-3"></i>
                            <p class="mb-0 mt-2">01 23 45 67 89</p>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-clock text-primary fs-3"></i>
                            <p class="mb-0 mt-2">Lun - Ven: 9h - 18h<br>Sam: 9h - 12h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function selectService(serviceId, element) {
        document.querySelectorAll('.service-card').forEach(card => {
            card.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('service_id').value = serviceId;
    }

    function selectTime(time, element) {
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('appointment_time').value = time;
    }

    // Sélectionner le service si déjà choisi
    document.addEventListener('DOMContentLoaded', function() {
        const selectedServiceId = document.getElementById('service_id').value;
        if (selectedServiceId) {
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach(card => {
                if (card.getAttribute('onclick').includes(selectedServiceId)) {
                    card.classList.add('selected');
                }
            });
        }
    });
</script>
</body>
</html>
