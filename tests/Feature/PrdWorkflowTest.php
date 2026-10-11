<?php

use App\Models\BeritaAcara;
use App\Models\KategoriSarana;
use App\Models\LaporanSarana;
use App\Models\Ruangan;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function sarprasFixture(string $categoryName = 'Elektronik'): array
{
    $category = KategoriSarana::create(['nama_kategori' => $categoryName]);
    $room = Ruangan::create([
        'kode_ruangan' => 'R-'.fake()->unique()->numerify('####'),
        'nama_ruangan' => 'Ruang Uji',
        'lokasi' => 'Gedung A',
    ]);
    $facility = Sarana::create([
        'kode_sarana' => 'S-'.fake()->unique()->numerify('####'),
        'nama_sarana' => 'Komputer Uji',
        'id_kategori' => $category->id,
        'id_ruangan' => $room->id,
        'kondisi' => 'baik',
        'status_perbaikan' => 'normal',
        'jumlah' => 1,
    ]);

    return [$category, $room, $facility];
}

test('role permissions follow the PRD route boundaries', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $staff = User::factory()->create(['role' => 'petugas_sarpras']);
    $teacher = User::factory()->create(['role' => 'guru']);
    $student = User::factory()->create(['role' => 'murid']);

    $this->actingAs($admin)->get('/dashboard')->assertOk();
    $this->actingAs($staff)->get('/dashboard')->assertOk();
    $this->actingAs($teacher)->get('/dashboard')->assertForbidden();
    $this->actingAs($student)->get('/dashboard')->assertForbidden();

    $this->actingAs($admin)->get('/guru')->assertOk();
    $this->actingAs($staff)->get('/guru')->assertForbidden();
    $this->actingAs($teacher)->get('/sarana')->assertForbidden();
    $this->actingAs($student)->get('/berita-acara')->assertForbidden();
    $this->actingAs($teacher)->get('/berita-acara')->assertOk();
    $this->actingAs($admin)->get('/sarana/create')->assertOk();
    $this->get('/kategori/create')->assertOk();
    $this->get('/ruangan/create')->assertOk();
    $this->get('/guru/create')->assertOk();
    $this->get('/petugas/create')->assertOk();
    $this->get('/berita-acara/create')->assertOk();
});

test('facility CRUD supports search category filters pagination and guarded deletion', function () {
    [$category, $room, $facility] = sarprasFixture();
    $otherCategory = KategoriSarana::create(['nama_kategori' => 'Meubel']);
    Sarana::create([
        'kode_sarana' => 'MEJA-1',
        'nama_sarana' => 'Meja Uji',
        'id_kategori' => $otherCategory->id,
        'id_ruangan' => $room->id,
        'kondisi' => 'baik',
        'status_perbaikan' => 'normal',
        'jumlah' => 2,
    ]);
    for ($i = 0; $i < 10; $i++) {
        Sarana::create([
            'kode_sarana' => 'PAGE-'.$i,
            'nama_sarana' => 'Unit '.$i,
            'id_kategori' => $category->id,
            'id_ruangan' => $room->id,
            'kondisi' => 'baik',
            'status_perbaikan' => 'normal',
            'jumlah' => 1,
        ]);
    }

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->get('/sarana?search=Komputer&id_kategori='.$category->id)
        ->assertOk()
        ->assertSee('Komputer Uji')
        ->assertDontSee('Meja Uji');

    $this->get('/sarana?id_kategori='.$category->id)
        ->assertOk()
        ->assertSee('page=2');

    $student = User::factory()->create(['role' => 'murid']);
    LaporanSarana::create([
        'id_murid' => $student->id,
        'id_sarana' => $facility->id,
        'id_ruangan' => $room->id,
        'jenis_kerusakan' => 'Layar',
        'deskripsi_kerusakan' => 'Tidak menyala',
    ]);
    $this->delete('/sarana/'.$facility->id)->assertSessionHasErrors('sarana');
});

test('category and room CRUD tables have search pagination and related-category filters', function () {
    [$category, $room] = sarprasFixture('Elektronik');
    $otherRoom = Ruangan::create([
        'kode_ruangan' => 'R-OTHER',
        'nama_ruangan' => 'Ruang Lain',
        'lokasi' => 'Gedung B',
    ]);

    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin)
        ->get('/kategori?search=Elektronik')
        ->assertOk()
        ->assertSee('Elektronik')
        ->assertDontSee('Meubel');
    $this->get('/ruangan?id_kategori='.$category->id)
        ->assertOk()
        ->assertSee('Ruang Uji')
        ->assertDontSee('Ruang Lain');

    $this->delete('/kategori/'.$category->id)->assertSessionHasErrors('kategori');
    $this->delete('/ruangan/'.$room->id)->assertSessionHasErrors('ruangan');
    $this->delete('/ruangan/'.$otherRoom->id)->assertRedirect('/ruangan');
});

test('administrator can create fixed-role staff accounts and search their table', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->post('/guru', [
        'nama' => 'Guru Contoh',
        'email' => 'guru@example.com',
        'password' => 'StrongPassword123!',
        'password_confirmation' => 'StrongPassword123!',
        'role' => 'admin',
    ])->assertRedirect('/guru');

    expect(User::where('email', 'guru@example.com')->first()->role)->toBe('guru');
    $this->get('/guru?search=Guru+Contoh')->assertOk()->assertSee('guru@example.com');

    $this->post('/petugas', [
        'nama' => 'Petugas Contoh',
        'email' => 'petugas@example.com',
        'password' => 'StrongPassword123!',
        'password_confirmation' => 'StrongPassword123!',
    ])->assertRedirect('/petugas');

    expect(User::where('email', 'petugas@example.com')->first()->role)->toBe('petugas_sarpras');
});

test('student reports save optional photos and remain private to their owner', function () {
    Storage::fake('public');
    [$category, $room, $facility] = sarprasFixture();
    $student = User::factory()->create(['role' => 'murid']);
    $this->actingAs($student)->get('/laporan')->assertOk();

    $this->actingAs($student)->post('/laporan', [
        'id_ruangan' => $room->id,
        'id_sarana' => $facility->id,
        'jenis_kerusakan' => 'Layar',
        'deskripsi_kerusakan' => 'Layar tidak menyala.',
        'foto' => UploadedFile::fake()->image('kerusakan.jpg'),
    ])->assertRedirect('/laporan');

    $report = LaporanSarana::firstOrFail();
    expect($report->id_murid)->toBe($student->id)
        ->and($report->status)->toBe('pending')
        ->and($report->foto)->not->toBeNull();
    Storage::disk('public')->assertExists($report->foto);

    $otherStudent = User::factory()->create(['role' => 'murid']);
    LaporanSarana::create([
        'id_murid' => $otherStudent->id,
        'id_sarana' => $facility->id,
        'id_ruangan' => $room->id,
        'jenis_kerusakan' => 'Kabel',
        'deskripsi_kerusakan' => 'Kabel terlepas.',
    ]);

    $this->get('/laporan/riwayat')->assertOk()->assertSee('Layar')->assertDontSee('Kabel');
});

test('staff can filter and move reports through allowed statuses and dashboard counts update', function () {
    [$category, $room, $facility] = sarprasFixture();
    $student = User::factory()->create(['role' => 'murid']);
    $report = LaporanSarana::create([
        'id_murid' => $student->id,
        'id_sarana' => $facility->id,
        'id_ruangan' => $room->id,
        'jenis_kerusakan' => 'Layar',
        'deskripsi_kerusakan' => 'Tidak menyala',
    ]);
    $staff = User::factory()->create(['role' => 'petugas_sarpras']);

    $this->actingAs($staff)->get('/laporan?search=Layar&id_kategori='.$category->id.'&status=pending')
        ->assertOk()
        ->assertSee('Tidak menyala');

    $this->patch('/laporan/'.$report->id.'/status', ['status' => 'dalam_perbaikan'])->assertRedirect();
    expect($report->fresh()->status)->toBe('dalam_perbaikan')
        ->and($facility->fresh()->status_perbaikan)->toBe('dalam_perbaikan');
    $this->get('/dashboard')->assertSee('1');

    $this->patch('/laporan/'.$report->id.'/status', ['status' => 'selesai'])->assertRedirect();
    expect($report->fresh()->status)->toBe('selesai')
        ->and($facility->fresh()->status_perbaikan)->toBe('normal');
    $this->patch('/laporan/'.$report->id.'/status', ['status' => 'pending'])->assertSessionHasErrors('status');
});

test('teacher can create and only view their own incident records', function () {
    [$category, $room, $facility] = sarprasFixture();
    $teacher = User::factory()->create(['role' => 'guru']);

    $this->actingAs($teacher)->post('/berita-acara', [
        'no_berita_acara' => 'BA/01/2026',
        'id_sarana' => $facility->id,
        'jenis_tindakan' => 'perbaikan',
        'keterangan' => 'Sarana telah diperiksa.',
        'tanggal' => '2026-10-11',
    ])->assertRedirect();

    $record = BeritaAcara::firstOrFail();
    expect($record->id_user_pembuat)->toBe($teacher->id);
    $this->get('/berita-acara')->assertOk()->assertSee('BA/01/2026');
    $this->get('/berita-acara/'.$record->id.'/print')->assertOk()->assertSee('Sarana telah diperiksa.');
    $this->put('/berita-acara/'.$record->id, ['keterangan' => 'Diubah'])->assertForbidden();

    $anotherTeacher = User::factory()->create(['role' => 'guru']);
    $otherRecord = BeritaAcara::create([
        'no_berita_acara' => 'BA/02/2026',
        'id_user_pembuat' => $anotherTeacher->id,
        'id_sarana' => $facility->id,
        'jenis_tindakan' => 'pemeliharaan',
        'keterangan' => 'Catatan lain.',
        'tanggal' => '2026-10-10',
    ]);
    $this->get('/berita-acara/'.$otherRecord->id)->assertForbidden();
});
