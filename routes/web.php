<?php

use App\Http\Controllers\AdminMagangController;
use App\Http\Controllers\AdminProfilAdminController;
use App\Http\Controllers\AdminProfilDosenController;
use App\Http\Controllers\AdminProfilMahasiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\EvaluasiSPKController;
use App\Http\Controllers\MahasiswaAkunProfilController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaMagangController;
use App\Http\Controllers\MahasiswaPengajuanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PerusahaanMitraController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::get('demo', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/' . Auth::user()->getRole());
    });
    Route::get('/notifikasi', function () {
        return redirect('/' . Auth::user()->getRole() . '/notifikasi');
    })->name('notifikasi');
    Route::get('/notifikasi/getunread', [NotificationController::class, 'getUnreaded'])->name('notifikasi.getunread');
    Route::patch('/notifikasi/read/{id}', [NotificationController::class, 'read'])->name('notifikasi.read');
    Route::patch('/notifikasi/readall', [NotificationController::class, 'readall'])->name('notifikasi.readall');

    Route::middleware(['authorize:admin'])->group(function () {
        // Dashboard admin
        Route::get('/admin', function () {
            return view('admin.profil_admin.dashboard');
        });
        Route::get('/admin/notifikasi', [NotificationController::class, 'index'])->name('admin.notifikasi');

        Route::get('/admin/profile', function () {
            return view('admin.profil_admin.dashboard');
        })->name('admin.profile');

        // Admin
        Route::prefix('admin/pengguna/admin')->group(function () {
            Route::get('/', [AdminProfilAdminController::class, 'index'])->name('admin.admin.index');
            Route::get('/create', [AdminProfilAdminController::class, 'create'])->name('admin.admin.create');
            Route::post('/', [AdminProfilAdminController::class, 'store'])->name('admin.admin.store');
            Route::get('/{id}', [AdminProfilAdminController::class, 'show'])->name('admin.admin.show');
            Route::get('/{id}/edit', [AdminProfilAdminController::class, 'edit'])->name('admin.admin.edit');
            Route::put('/{id}', [AdminProfilAdminController::class, 'update'])->name('admin.admin.update');
            Route::delete('/{id}', [AdminProfilAdminController::class, 'destroy'])->name('admin.admin.destroy');
            Route::patch('/{id}/toggle-status', [AdminProfilAdminController::class, 'toggleStatus'])->name('admin.admin.toggle-status');
        });

        // Dosen
        Route::prefix('admin/pengguna/dosen')->group(function () {
            Route::get('/', [AdminProfilDosenController::class, 'index'])->name('admin.dosen.index');
            Route::get('/create', [AdminProfilDosenController::class, 'create'])->name('admin.dosen.create');
            Route::post('/', [AdminProfilDosenController::class, 'store'])->name('admin.dosen.store');
            Route::get('/{id}', [AdminProfilDosenController::class, 'show'])->name('admin.dosen.show');
            Route::get('/{id}/edit', [AdminProfilDosenController::class, 'edit'])->name('admin.dosen.edit');
            Route::put('/{id}', [AdminProfilDosenController::class, 'update'])->name('admin.dosen.update');
            Route::delete('/{id}', [AdminProfilDosenController::class, 'destroy'])->name('admin.dosen.destroy');
            Route::patch('/{id}/toggle-status', [AdminProfilDosenController::class, 'toggleStatus'])->name('admin.dosen.toggle-status');
        });

        // Mahasiswa
        Route::prefix('admin/pengguna/mahasiswa')->group(function () {
            Route::get('/', [AdminProfilMahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
            Route::get('/create', [AdminProfilMahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
            Route::post('/', [AdminProfilMahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
            Route::get('/{id}', [AdminProfilMahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
            Route::get('/{id}/edit', [AdminProfilMahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
            Route::put('/{id}', [AdminProfilMahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
            Route::delete('/{id}', [AdminProfilMahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
            Route::patch('/{id}/toggle-status', [AdminProfilMahasiswaController::class, 'toggleStatus'])->name('admin.mahasiswa.toggle-status');
        });

        Route::prefix('admin/program_studi')->group(function () {
            Route::get('/', [ProgramStudiController::class, 'index'])->name('program_studi.index');
            Route::get('/create', [ProgramStudiController::class, 'create'])->name('program_studi.create');
            Route::post('/', [ProgramStudiController::class, 'store'])->name('program_studi.store');
            Route::get('/{id}/edit', [ProgramStudiController::class, 'edit'])->name('program_studi.edit');
            Route::put('/{id}', [ProgramStudiController::class, 'update'])->name('program_studi.update');
            Route::delete('/{id}', [ProgramStudiController::class, 'destroy'])->name('program_studi.destroy');
        });

        Route::get('/admin/perusahaan/', [PerusahaanMitraController::class, 'index']);
        Route::get('/admin/perusahaan/create', [PerusahaanMitraController::class, 'create']);
        Route::post('/admin/perusahaan/', [PerusahaanMitraController::class, 'store']);
        Route::get('/admin/perusahaan/{id}', [PerusahaanMitraController::class, 'show']);
        Route::get('/admin/perusahaan/{id}/edit', [PerusahaanMitraController::class, 'edit']);
        Route::put('/admin/perusahaan/{id}', [PerusahaanMitraController::class, 'update']);
        Route::delete('/admin/perusahaan/{id}', [PerusahaanMitraController::class, 'destroy']);
        Route::patch('/admin/perusahaan/{id}/toggle-status', [PerusahaanMitraController::class, 'toggleStatus'])->name('admin.toggle-status');

        // MAGANG: Keagiatan
        Route::get('/admin/magang/kegiatan', [AdminMagangController::class, 'kegiatan'])->name('admin.magang.kegiatan');
        Route::get('/admin/magang/kegiatan/{pengajuan_id}/detail', [AdminMagangController::class, 'kegiatanDetail'])->name('admin.magang.kegiatan.detail');
        Route::get('/admin/magang/kegiatan/{dosen_id}/getDosenData', [AdminMagangController::class, 'getDosenData'])->name('admin.magang.kegiatan.getDosenData');
        Route::put('/admin/magang/kegiatan', [AdminMagangController::class, 'kegiatanPost'])->name('admin.magang.kegiatan.update');
        Route::put('/admin/magang/kegiatan/upload/keterangan/', [AdminMagangController::class, 'uploadKeterangan'])->name('admin.magang.kegiatan.upload.keterangan');
        Route::delete('/admin/magang/kegiatan/upload/keterangan/', [AdminMagangController::class, 'deleteKeterangan'])->name('admin.magang.kegiatan.delete.keterangan');

        // EVALUASI
        Route::get('/admin/evaluasi/spk', [EvaluasiSPKController::class, 'index'])->name('admin.evaluasi.spk');
        Route::get('/admin/evaluasi/spk/detail', [EvaluasiSPKController::class, 'spk'])->name('admin.evaluasi.spk.detail');
        Route::get('/admin/evaluasi/spk/lowongan', [EvaluasiSPKController::class, 'lowongan'])->name('admin.evaluasi.spk.lowongan');
        Route::get('/admin/evaluasi/spk/profileTesting', [EvaluasiSPKController::class, 'profileTesting'])->name('admin.evaluasi.spk.profile-testing');
        Route::put('/admin/evaluasi/spk/updateProfileTesting', [EvaluasiSPKController::class, 'updateProfileTesting'])->name('admin.evaluasi.spk.profile-testing.update');
        Route::put('/admin/evaluasi/spk/update', [EvaluasiSPKController::class, 'update'])->name('admin.evaluasi.spk.update');
    });

    Route::middleware(['authorize:dosen'])->group(function () {
        Route::get('/dosen', [DosenController::class, 'index']);
        Route::get('/dosen/notifikasi', [NotificationController::class, 'index'])->name('dosen.notifikasi');
        Route::get('/dosen/mahasiswabimbingan', [DosenController::class, 'tampilMahasiswaBimbingan'])->name('dosen.mahasiswabimbingan');
        Route::get('/dosen/mahasiswabimbingan/{id}/logAktivitas', [DosenController::class, 'logAktivitas'])->name('dosen.detail.logAktivitas');
        Route::get('/dosen/mahasiswabimbingan/{id}/detail', [DosenController::class, 'detailMahasiswaBimbingan'])->name('dosen.mahasiswabimbingan.detail');
        Route::get('/dosen/mahasiswabimbingan/{id}/logAktivitas', [DosenController::class, 'logAktivitas'])->name('dosen.detail.logAktivitas');

        Route::get('/dosen/profile', [DosenController::class, 'profile'])->name('dosen.profile');
        Route::get('/dosen/profile/edit', [DosenController::class, 'editProfile'])->name('dosen.edit-profil');
        Route::post('/dosen/profile/update', [DosenController::class, 'updateProfile'])->name('dosen.update-profil');
        Route::post('/dosen/profile/update-password', [DosenController::class, 'changePassword'])->name('dosen.profile.update-password');
    });

    Route::middleware(['authorize:mahasiswa'])->group(function () {
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/notifikasi', [NotificationController::class, 'index'])->name('mahasiswa.notifikasi');
        // PROFILE
        Route::get('/mahasiswa/profile', [MahasiswaAkunProfilController::class, 'profile'])->name('mahasiswa.profile');
        Route::get('/mahasiswa/profile/edit', [MahasiswaAkunProfilController::class, 'profile'])->name('mahasiswa.profile.edit');
        Route::put('/mahasiswa/profile/update', [MahasiswaAkunProfilController::class, 'update'])->name('mahasiswa.profile.update');
        Route::put('/mahasiswa/profile/update-password', [MahasiswaAkunProfilController::class, 'changePassword'])->name('mahasiswa.profile.update-password');
        Route::get('/mahasiswa/dokumen', [MahasiswaAkunProfilController::class, 'dokumen'])->name('mahasiswa.dokumen');
        Route::post('/mahasiswa/dokumen/upload', [MahasiswaAkunProfilController::class, 'dokumenUpload'])->name('mahasiswa.dokumen.upload');
        // MAGANG
        Route::get('/mahasiswa/magang', [MahasiswaMagangController::class, 'index'])->name('mahasiswa.magang');
        Route::get('/mahasiswa/magang/lowongan/', function () {
            return redirect('/mahasiswa/magang');
        });
        Route::get('/mahasiswa/magang/lowongan/{lowongan_id}/detail', [MahasiswaMagangController::class, 'magangDetail'])->name('mahasiswa.magang.lowongan.detail');
        Route::get('/mahasiswa/magang/lowongan/{lowongan_id}/ajukan', [MahasiswaMagangController::class, 'ajukan'])->name('mahasiswa.magang.lowongan.ajukan');
        Route::post('/mahasiswa/magang/lowongan/{lowongan_id}/ajukan', [MahasiswaMagangController::class, 'ajukanPost'])->name('mahasiswa.magang.lowongan.ajukan.post');
        // PENGAJUAN
        Route::get('/mahasiswa/magang/pengajuan', [MahasiswaPengajuanController::class, 'index'])->name('mahasiswa.magang.pengajuan');
        Route::get('/mahasiswa/magang/pengajuan/{pengajuan_id}/detail', [MahasiswaPengajuanController::class, 'pengajuanDetail'])->name('mahasiswa.magang.pengajuan.detail');
        Route::delete('/mahasiswa/magang/pengajuan/{pengajuan_id}/delete', [MahasiswaPengajuanController::class, 'pengajuanDelete'])->name('mahasiswa.magang.pengajuan.delete');
        // LOG AKTIVITAS
        Route::get('/mahasiswa/magang/pengajuan/log-aktivitas', function () {
            return redirect()->route('mahasiswa.magang.pengajuan');
        });
        Route::get('/mahasiswa/magang/pengajuan/log-aktivitas/{pengajuan_id}', [MahasiswaPengajuanController::class, 'logAktivitas'])->name('mahasiswa.magang.log-aktivitas');
        Route::get('/mahasiswa/magang/pengajuan/log-aktivitas/{pengajuan_id}/data', [MahasiswaPengajuanController::class, 'logAktivitasData'])->name('mahasiswa.magang.log-aktivitas.data');
        Route::put('/mahasiswa/magang/pengajuan/log-aktivitas/{pengajuan_id}', [MahasiswaPengajuanController::class, 'logAktivitasUpdate'])->name('mahasiswa.magang.log-aktivitas.update');
        // FEEDBACK
        Route::get('/mahasiswa/magang/pengajuan/feedback-lowongan/{pengajuan_id}', [MahasiswaPengajuanController::class, 'feedback'])->name('mahasiswa.magang.feedback');
        Route::put('/mahasiswa/magang/pengajuan/feedback-lowongan/{pengajuan_id}', [MahasiswaPengajuanController::class, 'feedbackPost'])->name('mahasiswa.magang.feedback.update');
        // FEEDBACK: SPK
        Route::get('/mahasiswa/evaluasi/spk', [MahasiswaPengajuanController::class, 'feedbackSpk'])->name('mahasiswa.evaluasi.feedback.spk');
    });
});
