
@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-description', 'Informasi lengkap akun pengguna Kantin.ONE.')

@section('dashboard-content')
<div class="row g-4">

    {{-- Informasi Pengguna --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Pengguna</h5>

                @if ($user->is_active)
                    <span class="badge bg-success-subtle text-success">
                        <i class="fas fa-circle-check me-1"></i> Aktif
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger">
                        <i class="fas fa-circle-xmark me-1"></i> Nonaktif
                    </span>
                @endif
            </div>

            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                         style="width: 65px; height: 65px; font-size: 24px;">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <span class="text-muted">{{ '@' . $user->username }}</span>
                    </div>
                </div>

                <hr>

                <div class="row g-4">
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Nama Lengkap</small>
                        <div class="fw-semibold">{{ $user->name }}</div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Username</small>
                        <div class="fw-semibold">{{ $user->username }}</div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Email</small>
                        <div class="fw-semibold">{{ $user->email ?: '—' }}</div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Role</small>
                        <span class="badge bg-info-subtle text-info">
                            {{ ucwords(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Tanggal Dibuat</small>
                        <div class="fw-semibold">
                            {{ $user->created_at?->format('d F Y, H:i') ?? '—' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Terakhir Diperbarui</small>
                        <div class="fw-semibold">
                            {{ $user->updated_at?->format('d F Y, H:i') ?? '—' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Verifikasi Email</small>
                        <div class="fw-semibold">
                            @if ($user->email_verified_at)
                                <span class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Terverifikasi
                                </span>
                            @elseif ($user->email)
                                <span class="text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    Belum Terverifikasi
                                </span>
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi Pengguna --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Aksi Pengguna</h5>
            </div>

            <div class="card-body">

                @if (!$user->is_protected)
                    {{-- Edit Pengguna --}}
                    <form action="{{ route('users.select-edit') }}"
                            method="POST"
                            class="mb-2">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-edit me-2"></i>
                            Edit Pengguna
                        </button>
                    </form>

                    @if ($user->id !== auth()->id())

                        {{-- Toggle Status --}}
                        <form action="{{ route('users.toggle-status') }}"
                                method="POST"
                                class="status-form mb-2"
                                data-name="{{ $user->name }}"
                                data-active="{{ $user->is_active ? '1' : '0' }}">

                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <button type="submit"
                                    class="btn {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} w-100">
                                <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} me-2"></i>
                                {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                            </button>
                        </form>

                        @if (!$user->is_active)

                            {{-- Soft Delete --}}
                            <form action="{{ route('users.destroy') }}"
                                    method="POST"
                                    class="delete-user-form"
                                    data-name="{{ $user->name }}">

                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash me-2"></i>
                                    Hapus Akun
                                </button>
                            </form>

                        @endif
                    @endif

                @else
                    <div class="alert alert-info small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Ini adalah akun yang sedang Anda gunakan. Aksi aktivasi dan penghapusan tidak tersedia.
                    </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Informasi
                </h6>
                <p class="text-muted small mb-0">
                    Akun yang dihapus akan dipindahkan ke data terhapus
                    (Soft Delete), sehingga datanya masih tersimpan
                    di database.
                </p>
            </div>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('users.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali ke Daftar Pengguna
    </a>
</div>

@vite('resources/js/pages/users.js')
@endsection
