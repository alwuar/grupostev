<x-admin.layout title="Usuarios">

    <div class="page-head">
        <div>
            <h1>Usuarios</h1>
            <p class="sub">Quién entra al panel y qué puede ver.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-mx">Nuevo usuario</a>
    </div>

    <div class="tabla-wrap">
        <table class="table tabla-leads tabla-simple">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Estado</th>
                    <th scope="col"><span class="visually-hidden">Acciones</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr data-href="{{ route('admin.users.edit', $u) }}" @class(['fila-inactiva' => ! $u->activo])>
                        <td data-label="Nombre" class="td-nombre">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <a href="{{ route('admin.users.edit', $u) }}" class="nombre">{{ $u->name }}</a>
                                @if ($u->is(auth()->user()))<span class="badge-medio">Tú</span>@endif
                            </div>
                        </td>
                        <td data-label="Correo" class="text-break">{{ $u->email }}</td>
                        <td data-label="Rol"><span class="badge-rol rol--{{ $u->role->value }}">{{ $u->role->label() }}</span></td>
                        <td data-label="Estado">{{ $u->activo ? 'Activo' : 'Sin acceso' }}</td>
                        <td class="td-accion text-end"><a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-mx-outline">Editar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin.layout>
