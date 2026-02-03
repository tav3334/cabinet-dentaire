# 🦷 Cabinet Dentaire - Système de Gestion

Application web complète pour la gestion d'un cabinet dentaire, développée avec Laravel 12.

## 🌟 Fonctionnalités Principales

### 👥 Gestion des Patients
- Fiche complète du patient (informations personnelles, médicales)
- Historique médical et allergies
- Recherche et filtrage
- Dossier médical centralisé

### 📅 Gestion des Rendez-vous
- Prise de rendez-vous en ligne (formulaire public)
- Tableau de bord admin avec gestion complète
- Statuts: En attente, Confirmé, Annulé
- Soft delete avec possibilité de restauration
- Notifications par email

### 🦷 Gestion des Traitements
- Suivi détaillé des traitements dentaires
- 10 catégories de soins (préventif, restauration, chirurgie, etc.)
- Suivi du nombre de séances
- Gestion des coûts (estimé/réel)
- Progression automatique en pourcentage

### 📋 Consultations Médicales
- Fiches de consultation complètes
- Motif, examen clinique, diagnostic
- Plan de traitement et prescriptions
- Recommandations et suivi
- Schéma dentaire (JSON)

### 📁 Fichiers Médicaux
- Upload de radiographies, documents, ordonnances
- Types: Radiographie, Scanner, Photo, Document, etc.
- Stockage sécurisé
- Téléchargement et prévisualisation
- Max 10MB par fichier

### 🏥 Services
- Catalogue des services offerts
- Descriptions et images
- Attribution aux rendez-vous

### 📊 Tableau de Bord Admin
- Statistiques en temps réel
- Rendez-vous du jour et à venir
- Graphiques mensuels
- Patients récents

### 🔐 Authentification & Sécurité
- Système d'authentification complet (Laravel Breeze)
- Rôles utilisateurs (Admin/User)
- Middleware de protection
- Vérification d'email

## 🛠️ Technologies Utilisées

- **Framework:** Laravel 12
- **Base de données:** MySQL / SQLite
- **Frontend:**
  - Tailwind CSS
  - Alpine.js
  - Blade Templates
- **Build:** Vite
- **Tests:** Pest PHP
- **Email:** Configuration SMTP

## 📦 Installation

### Prérequis
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL ou SQLite

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd cabinet-dentaire
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances JavaScript**
```bash
npm install
```

4. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**
Éditer le fichier `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cabinet_dentaire
DB_USERNAME=root
DB_PASSWORD=
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Créer le lien symbolique pour le storage**
```bash
php artisan storage:link
```

8. **Compiler les assets**
```bash
npm run dev
```
ou pour la production:
```bash
npm run build
```

9. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible à: `http://localhost:8000`

## 👤 Créer un Compte Admin

Pour créer un administrateur, exécutez dans Tinker:

```bash
php artisan tinker
```

Puis:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@cabinet-dentaire.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->email_verified_at = now();
$user->save();
```

## 📂 Structure du Projet

```
cabinet-dentaire/
├── app/
│   ├── Http/Controllers/Admin/    # Contrôleurs admin
│   ├── Models/                    # Modèles Eloquent
│   ├── Mail/                      # Classes email
│   └── Http/Middleware/           # Middleware
├── database/
│   ├── migrations/                # Migrations
│   └── seeders/                   # Seeders
├── resources/
│   ├── views/                     # Vues Blade
│   └── js/                        # JavaScript
├── routes/
│   ├── web.php                    # Routes web
│   └── auth.php                   # Routes auth
├── storage/
│   └── app/public/medical-files/  # Fichiers médicaux
└── public/                        # Assets publics
```

## 🗄️ Base de Données

### Tables Principales

- `users` - Utilisateurs et administrateurs
- `patients` - Patients du cabinet
- `appointments` - Rendez-vous
- `services` - Services offerts
- `treatments` - Traitements dentaires
- `consultations` - Fiches de consultation
- `medical_files` - Documents médicaux
- `settings` - Paramètres de l'application

## 🔗 Routes Principales

### Public
- `/` - Page d'accueil
- `/services` - Catalogue des services
- `/rendez-vous` - Formulaire de prise de RDV

### Admin (Auth + Admin middleware)
- `/admin` - Dashboard
- `/admin/patients` - Gestion patients
- `/admin/patients/{id}/medical-record` - Dossier médical
- `/admin/appointments` - Gestion rendez-vous
- `/admin/treatments` - Gestion traitements
- `/admin/consultations` - Gestion consultations
- `/admin/medical-files` - Gestion fichiers
- `/admin/services` - Gestion services

### Authentification
- `/login` - Connexion
- `/register` - Inscription
- `/forgot-password` - Mot de passe oublié

## ⚙️ Configuration

### Email
Configurer dans `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@cabinet-dentaire.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Storage
Les fichiers médicaux sont stockés dans `storage/app/public/medical-files/`

N'oubliez pas de créer le lien symbolique:
```bash
php artisan storage:link
```

## 🧪 Tests

Exécuter les tests:
```bash
php artisan test
```

ou avec Pest:
```bash
./vendor/bin/pest
```

## 📝 Utilisation

### Pour l'Admin

1. **Créer un patient**
   - Menu Patients > Nouveau patient
   - Remplir les informations

2. **Créer un rendez-vous**
   - Menu Rendez-vous > Nouveau RDV
   - Sélectionner patient et service

3. **Documenter une consultation**
   - Patient > Dossier médical > Nouvelle consultation
   - Remplir la fiche de consultation

4. **Ajouter un traitement**
   - Patient > Dossier médical > Nouveau traitement
   - Définir le plan de traitement

5. **Uploader des fichiers**
   - Patient > Dossier médical > Ajouter fichier
   - Radiographies, ordonnances, etc.

### Pour les Patients (Public)

1. Aller sur `/rendez-vous`
2. Remplir le formulaire de demande
3. Recevoir un email de confirmation
4. L'admin gérera le statut du RDV

## 🎨 Personnalisation

### Couleurs et Styles
Modifier `tailwind.config.js` et les fichiers CSS dans `resources/css/`

### Logo et Images
Placer vos images dans `public/images/`

### Emails
Modifier les templates dans `resources/views/emails/`

## 🔒 Sécurité

- Authentification Laravel Breeze
- Middleware Admin pour les routes admin
- CSRF Protection
- Validation des formulaires
- Stockage sécurisé des fichiers
- Hash des mots de passe (bcrypt)

## 📱 Responsive Design

L'application est entièrement responsive et fonctionne sur:
- Desktop
- Tablette
- Mobile

## 🚀 Déploiement

### Production

1. Configurer `.env` pour la production
2. Compiler les assets:
```bash
npm run build
```

3. Optimiser l'application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4. Configurer le serveur web (Apache/Nginx)
5. Pointer le document root vers `/public`

## 🐛 Dépannage

### Erreur 500
- Vérifier les logs: `storage/logs/laravel.log`
- Vérifier les permissions: `storage/` et `bootstrap/cache/`

### Assets non chargés
- Exécuter `npm run build`
- Vérifier `public/build/`

### Fichiers non uploadés
- Vérifier `php artisan storage:link`
- Vérifier les permissions de `storage/app/public/`

## 📄 Licence

Ce projet est sous licence MIT.

## 🤝 Contribution

Les contributions sont les bienvenues! N'hésitez pas à:
1. Fork le projet
2. Créer une branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit vos changements (`git commit -m 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrir une Pull Request

## 📞 Support

Pour toute question ou assistance:
- Consulter la documentation Laravel: https://laravel.com/docs
- Consulter le fichier `NOUVELLES_FONCTIONNALITES.md`

## 📊 Version

**Version actuelle:** 2.0
**Dernière mise à jour:** Février 2026

---

Développé avec ❤️ pour la gestion moderne des cabinets dentaires
