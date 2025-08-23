@extends('dashboard.index')
@section('title', 'journals')
@section('subtitle', 'Liste')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Mes journals</h1>
            <p class="text-muted mb-0">Retrouvez ci-dessous tous vos journals disponibles dans l'application.</p>
        </div>
        <a href="{{ route('journals.create') }}" class="btn btn-outline-dark">
            <i class="bi bi-plus-circle"></i><span class="d-none d-sm-inline ms-2">Nouveau</span>
        </a>
    </div>

    <div class="card border-0 shadow">
        <div class="table-responsive card-body">
            <table class="datatables table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Désignation</th>
                        <th>Recettes ({{ auth()->user()->parametre['devise'] }})</th>
                        <th>Dépenses ({{ auth()->user()->parametre['devise'] }})</th>
                        <th>Total ({{ auth()->user()->parametre['devise'] }})</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th class="d-print-none">Actions</th>
                        {{-- <th>Duree Jour(s)</th>
                        <th>Reduction (%)</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($journals as $journal)
                        <tr>
                            <td>{{ $journal->date }}</td>
                            <td>{{ $journal->designation }}</td>
                            <td>
                                @if ($journal->recettes == 0)
                                    {{ devise($journal->recettes) }}
                                @else
                                    <span class="text-success">{{ devise($journal->recettes) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($journal->depenses == 0)
                                    {{ devise($journal->depenses) }}
                                @else
                                    <span class="text-danger">-{{ devise($journal->depenses) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($journal->recettes - $journal->depenses >= 0)
                                    <span class="text-success">{{ devise($journal->recettes + $journal->depenses) }}</span>
                                @else
                                    <span class="text-danger">-{{ devise($journal->recettes + $journal->depenses) }}</span>
                                @endif
                            </td>
                            </td>
                            <td>
                                @component('components.tags', ['badge' => $journal->statut])
                                @endcomponent
                            </td>
                            <td>{{ $journal->created_at }}</td>
                            {{-- <td>{{ $journal->duree }}</td>
                            <td>{{ $journal->reduction }}</td> --}}
                            <td class="no-select">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('journals.show', $journal->id) }}"><i
                                                    class="bi bi-eye me-2"></i>Consulter</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('journals.edit', $journal->id) }}"><i
                                                    class="bi bi-pencil-square me-2"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"><i
                                                    class="bi bi-archive me-2"></i>Archiver</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#logout" data-bs-toggle="modal"
                                                data-bs-target="#delete-journal-{{ $journal->id }}"><i
                                                    class="bi bi-trash me-2"></i>Supprimer</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total</th>
                        <th><span class="text-success">{{ devise($journals->sum('recettes')) }}</span></th>
                        <th><span class="text-danger">- {{ devise($journals->sum('depenses')) }}</span></th>
                        <th><span
                                class="text-dark">{{ devise($journals->sum('recettes') + $journals->sum('depenses')) }}</span>
                        </th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @foreach ($journals as $journal)
        <div class="modal fade" id="delete-journal-{{ $journal->id }}" tabindex="-1"
            aria-labelledby="journal-{{ $journal->id }}-label" aria-hidden="true">
            @component('components.modals.delete', ['action' => route('journals.destroy', $journal->id)])
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
    @endpush
@endsection
