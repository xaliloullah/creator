@extends('dashboard.index')
@section('title', 'qrcodes')
@section('subtitle', 'Liste')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Mes qrcodes</h1>
            <p class="text-muted mb-0">Retrouvez ci-dessous tous vos qrcodes disponibles dans l'application.</p>
        </div>
        <a href="{{ route('qrcodes.create') }}" class="btn btn-outline-dark">
            <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
        </a>
    </div>

    <div class="card border-0 shadow">
        <div class="table-responsive card-body">
            <table class="datatables table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th>Qrcode</th>
                        <th>Lien</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th class="d-print-none">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($qrcodes as $qrcode)
                        <tr>
                            <td>{{ $qrcode->content }} ({{ $qrcode->type }})</td>
                            <td class="no-select">
                                <a data-copy="{{ route('qrcodes.show', $qrcode->id) }}"
                                    href="{{ route('qrcodes.show', $qrcode->id) }}" target="_blank">
                                    {{ Str::limit(route('qrcodes.show', $qrcode->id), 30) }}
                                </a>
                                <button class="btn btn-sm btn-outline-dark ms-3" onclick="copy(this)">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </td>
                            <td>
                                @component('components.tags', ['badge' => $qrcode->statut])
                                @endcomponent
                            </td>
                            <td>{{ $qrcode->created_at }}</td>
                            <td class="no-select">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('qrcodes.show', $qrcode->id) }}"><i
                                                    class="bi bi-eye me-2"></i>Consulter</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('qrcodes.edit', $qrcode->id) }}"><i
                                                    class="bi bi-pencil-square me-2"></i>Modifier</a>
                                        </li>
                                        {{-- <li>
                                            <a class="dropdown-item" href="{{ route('qrcode.download', $qrcode->id) }}"><i
                                                    class="bi bi-download me-2"></i>Télécharger</a>
                                        </li> --}}
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#delete-qrcode-{{ $qrcode->id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-qrcode-{{ $qrcode->id }}"><i
                                                    class="bi bi-trash me-2"></i>Supprimer</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($qrcodes as $qrcode)
        <div class="modal fade" id="delete-qrcode-{{ $qrcode->id }}" tabindex="-1"
            aria-labelledby="qrcode-{{ $qrcode->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('qrcodes.destroy', $qrcode->id)])
            @endcomponent
        </div>
    @endforeach

    @push('scripts')
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jquery.datatables.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/responsive.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/responsive.bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jszip.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/pdfmake.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.html5.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.print.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/buttons.colvis.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/select.js') }}"></script>

        <script src="{{ asset('assets/js/datatables/init.js') }}"></script>

        <script>
            function copy(button) {
                navigator.clipboard.writeText(button.previousElementSibling.getAttribute('data-copy'))
                    .then(() => {
                        button.innerHTML = '<i class="bi bi-check-lg"></i>';
                        setTimeout(() => button.innerHTML = '<i class="bi bi-copy"></i>', 2000);
                    });
            }
        </script>
    @endpush
@endsection
