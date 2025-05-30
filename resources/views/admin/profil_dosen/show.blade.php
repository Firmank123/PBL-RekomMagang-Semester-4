<div class="row">
    <div class="col-md-4 text-center mb-4">
        @if ($dosen->profilDosen && $dosen->profilDosen->foto_profil)
            <img src="{{ asset('storage/' . $dosen->profilDosen->foto_profil) }}" alt="Foto Profil"
                class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        @else
            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto"
                style="width: 150px; height: 150px; overflow: hidden;">
                <img src="{{ asset('imgs/profile_placeholder.jpg') }}" alt="Placeholder"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        @endif
        <div class="mt-1">
            <small class="text-muted">Foto Profil</small>
        </div>
    </div>

    <div class="col-md-8">
        <h4 class="mb-3">{{ $dosen->profilDosen->nama ?? 'Tidak tersedia' }}</h4>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%">NIP</th>
                    <td>{{ $dosen->username }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $dosen->email }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $dosen->profilDosen->programStudi->nama_program ?? 'Tidak tersedia' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $dosen->profilDosen->lokasi->alamat ?? 'Tidak tersedia' }}</td>
                </tr>
                <tr>
                    <th>Minat Penelitian</th>
                    <td>{{ $dosen->profilDosen->minat_penelitian ?? 'Tidak tersedia' }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>{{ $dosen->profilDosen->nomor_telepon ?? 'Tidak tersedia' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-{{ $dosen->is_active ? 'success' : 'danger' }}">
                            {{ $dosen->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>