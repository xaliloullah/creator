<div class="card border-0 shadow mt-3">
    <div class="card-header">
        <h5>Roles</h5>
    </div>
    <div class="table-responsive card-body">
        <table class="datatables table table-striped table-hover align-middle w-100">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Designation</th>
                    <th>Permissions</th>
                    <th>Date de création</th>
                    <th class="d-print-none">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td><span class="text-{{ $role->color }}"><i
                                    class="bi {{ $role->icon }} me-2"></i>{{ $role->name }}</span></td>
                        <td>{{ $role->designation }}</td>
                        <td>
                            @component('components.tags', ['badges' => $role->permissions])
                            @endcomponent
                        </td>
                        <td>{{ formatDate($role->created_at) }}</td>
                        <td class="no-select">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    {{-- <li>
                                        <a class="dropdown-item" href="{{ route('access.show', $role->id) }}"><i
                                                class="bi bi-eye me-2"></i>Consulter</a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i
                                                class="bi bi-pencil-square me-2"></i>Modifier</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#delete-role-{{ $role->id }}"
                                            data-bs-toggle="modal"><i class="bi bi-trash me-2"></i>Supprimer</a>
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
