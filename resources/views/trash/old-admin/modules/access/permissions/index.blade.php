<div class="card border-0 shadow mt-3">
    <div class="card-header">
        <h5>Permissions</h5>
    </div>
    <div class="table-responsive card-body">
        <table class="datatables table table-striped table-hover align-middle w-100">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th>Designation</th>
                    <th>Roles</th>
                    <th>Date de création</th>
                    <th class="d-print-none">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->designation }}</td>
                        <td>
                            @component('components.tags', ['badges' => $permission->roles])
                            @endcomponent
                        </td>
                        <td>{{ formatDate($permission->created_at) }}</td>
                        <td class="no-select">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    {{-- <li>
                                        <a class="dropdown-item" href="{{ route('access.show', $permission->id) }}"><i
                                                class="bi bi-eye me-2"></i>Consulter</a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('permissions.edit', $permission->id) }}"><i
                                                class="bi bi-pencil-square me-2"></i>Modifier</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger"
                                            href="#delete-permission-{{ $permission->id }}" data-bs-toggle="modal"><i
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
