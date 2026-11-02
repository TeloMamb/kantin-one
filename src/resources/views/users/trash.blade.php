
@extends('layouts.dashboard')

@section('title', 'Pengguna Terhapus')
@section('page-title', 'Pengguna Terhapus')
@section('page-description', 'Kelola akun pengguna yang telah dihapus.')

@section('dashboard-content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Data Pengguna Terhapus</h5>
            <small class="text-muted">
                {{ $users->total() }} akun terhapus
            </small>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali ke Pengguna
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>Pengguna</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status Sebelumnya</th>
                        <th>Tanggal Dihapus</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">
                                    {{ $user->email ?: '—' }}
                                </small>
                            </td>

                            <td>{{ $user->username }}</td>

                            <td>
                                <span class="badge bg-info-subtle text-info">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>

                            <td>
                                @if ($user->is_active)
                                    <span class="badge bg-success-subtle text-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $user->deleted_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    {{-- Restore --}}
                                    <form action="{{ route('users.restore') }}"
                                          method="POST"
                                          class="restore-user-form"
                                          data-name="{{ $user->name }}">

                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                title="Pulihkan Pengguna">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>

                                    @if (!$user->is_protected)
                                        {{-- Hapus Permanen --}}
                                        <form action="{{ route('users.force-delete') }}"
                                            method="POST"
                                            class="force-delete-user-form"
                                            data-name="{{ $user->name }}">

                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus Permanen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-trash-alt fa-2x mb-3 d-block"></i>
                                Belum ada pengguna yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() ?? 0 }}
                sampai {{ $users->lastItem() ?? 0 }}
                dari {{ $users->total() }} pengguna
            </small>

            {{ $users->links() }}
        </div>
    </div>
</div>

@vite('resources/js/pages/users.js')
@endsection
