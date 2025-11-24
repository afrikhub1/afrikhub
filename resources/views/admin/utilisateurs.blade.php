@extends('admin.header_footer')

@section('titre', 'Utilisateurs | Admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/admin_residences.css') }}">
@endsection

@section('main')
    <div class="container mx-auto p-2">

        <h3 class="text-center display-3 text-primary fw-bold mb-4">
            Gestion des Utilisateurs
        </h3>

       @if ($utilisateurs->isEmpty())
            <div class="alert alert-warning border-start border-warning border-5 shadow-sm p-4" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Base de données vide</h4>
                <p class="mb-0">Aucun utilisateur n'a été trouvé. Veuillez vérifier les enregistrements.</p>
            </div>
        @else
    <h2 class="mb-4 fs-4 fw-bold text-primary">
        Total : <span class="badge bg-primary rounded-pill">{{ $utilisateurs->count() }}</span> utilisateurs enregistrés
    </h2>

    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-striped table-hover table-bordered align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Date d'Inscription</th>
                    <th scope="col">Dernière Mise à Jour</th>
                    <th scope="col" class="text-center" style="width: 300px;">Actions Administratives</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($utilisateurs as $user)
                    <tr class="search-row" data-name="{{ $user->name }}" data-status="{{ $user->status ?? 'inconnu' }}">

                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @if ($user->email_verified_at && $user->statut === 'suspendu')
                                <span class="badge bg-danger p-2">Suspendu (Vérifié) <i class="fas fa-lock"></i></span>
                            @elseif ($user->email_verified_at && $user->statut === 'actif')
                                <span class="badge bg-success p-2">Actif (Vérifié) <i class="fas fa-check-circle"></i></span>
                            @else
                                <span class="badge bg-warning text-dark p-2">En attente <i class="fas fa-spinner fa-spin"></i></span>
                            @endif
                        </td>

                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $user->updated_at->format('d/m/Y') }}</td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.users.residences', $user->id) }}" class="btn btn-info btn-sm text-white" title="Voir les Résidences">
                                    <i class="fas fa-home me-1"></i> Résidences
                                </a>

                                <form action="{{ route('admin.users.toggle_suspension', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-warning btn-sm"
                                            title="Suspendre ou Réactiver l'accès"
                                            onclick="return confirm('Confirmer l\'action pour {{ $user->name }} ?')">
                                        @if ($user->statut === 'suspendu')
                                            <i class="fas fa-unlock-alt me-1"></i> Réactiver
                                        @else
                                            <i class="fas fa-lock me-1"></i> Suspendre
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $user->name }} ? Cette action est irréversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer définitivement l'utilisateur">
                                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Vous pouvez ajouter ici la pagination si elle est gérée par Laravel --}}
    @if ($utilisateurs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $utilisateurs->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endif

    </div>
@endsection
