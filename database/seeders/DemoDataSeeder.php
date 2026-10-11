<?php

namespace Database\Seeders;

use App\Models\BeritaAcara;
use App\Models\KategoriSarana;
use App\Models\LaporanSarana;
use App\Models\Ruangan;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $usersByRole = $this->seedUsers();
        $categories = $this->seedCategories();
        $rooms = $this->seedRooms();
        $sarana = $this->seedSarana($categories, $rooms);

        $this->seedLaporan($usersByRole['murid'], $sarana);
        $this->seedBeritaAcara($usersByRole, $sarana);
    }

    /**
     * @return array<string, list<User>>
     */
    private function seedUsers(): array
    {
        $usersByRole = [];
        $accounts = [
            ['nama' => 'Administrator', 'email' => 'admin@gmail.com', 'role' => 'admin'],
            ['nama' => 'Petugas Sarpras', 'email' => 'petugas_sarpras@gmail.com', 'role' => 'petugas_sarpras'],
            ['nama' => 'Guru Demo', 'email' => 'guru@gmail.com', 'role' => 'guru'],
            ['nama' => 'Murid Demo', 'email' => 'murid@gmail.com', 'role' => 'murid'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [...$account, 'password' => 'password'],
            );

            $usersByRole[$account['role']][] = $user;
        }

        foreach (range(1, 15) as $index) {
            foreach (['guru', 'petugas_sarpras'] as $role) {
                $prefix = $role === 'guru' ? 'Guru Demo' : 'Petugas Sarpras Demo';
                $emailPrefix = $role === 'guru' ? 'guru' : 'petugas';
                $user = User::updateOrCreate(
                    ['email' => sprintf('%s.demo.%02d@example.test', $emailPrefix, $index)],
                    [
                        'nama' => sprintf('%s %02d', $prefix, $index),
                        'password' => 'password',
                        'role' => $role,
                    ],
                );

                $usersByRole[$role][] = $user;
            }
        }

        foreach (range(1, 60) as $index) {
            $user = User::updateOrCreate(
                ['email' => sprintf('murid.demo.%03d@example.test', $index)],
                [
                    'nama' => sprintf('Murid Demo %03d', $index),
                    'password' => 'password',
                    'role' => 'murid',
                ],
            );

            $usersByRole['murid'][] = $user;
        }

        return $usersByRole;
    }

    /**
     * @return list<KategoriSarana>
     */
    private function seedCategories(): array
    {
        $names = [
            'Elektronik',
            'Komputer dan Jaringan',
            'Meubel',
            'Alat Laboratorium',
            'Peralatan Olahraga',
            'Alat Kebersihan',
            'Peralatan Kelas',
            'Audio Visual',
            'Kelistrikan',
            'Peralatan Kantor',
            'Peralatan Perpustakaan',
            'Keamanan',
        ];

        $categories = [];

        foreach ($names as $index => $name) {
            $categories[] = KategoriSarana::updateOrCreate(
                ['nama_kategori' => $name],
                ['deskripsi' => sprintf('Kategori data demo untuk pengujian pencarian %02d.', $index + 1)],
            );
        }

        return $categories;
    }

    /**
     * @return list<Ruangan>
     */
    private function seedRooms(): array
    {
        $names = [
            'Laboratorium Komputer',
            'Ruang Kelas',
            'Perpustakaan',
            'Ruang Guru',
            'Laboratorium IPA',
            'Ruang Tata Usaha',
            'Aula Sekolah',
            'Ruang UKS',
            'Gudang',
            'Lapangan Olahraga',
            'Ruang Kepala Sekolah',
            'Laboratorium Bahasa',
        ];
        $rooms = [];

        foreach (range(1, 24) as $index) {
            $rooms[] = Ruangan::updateOrCreate(
                ['kode_ruangan' => sprintf('DEMO-R-%03d', $index)],
                [
                    'nama_ruangan' => sprintf('%s %02d', $names[($index - 1) % count($names)], $index),
                    'lokasi' => sprintf('Gedung %s, Lantai %d', chr(65 + (($index - 1) % 4)), (($index - 1) % 3) + 1),
                ],
            );
        }

        return $rooms;
    }

    /**
     * @param  list<KategoriSarana>  $categories
     * @param  list<Ruangan>  $rooms
     * @return list<Sarana>
     */
    private function seedSarana(array $categories, array $rooms): array
    {
        $names = [
            'Laptop Lenovo',
            'Komputer Desktop',
            'Proyektor Epson',
            'Printer Canon',
            'Kursi Siswa',
            'Meja Guru',
            'Papan Tulis',
            'AC Split',
            'Kipas Angin',
            'Mikroskop',
            'Bola Voli',
            'Speaker Aktif',
            'Router WiFi',
            'Lemari Arsip',
            'CCTV',
            'Scanner Dokumen',
            'Lampu LED',
            'Rak Buku',
            'Pemadam Api',
            'Mesin Fotokopi',
        ];
        $conditions = ['baik', 'rusak_ringan', 'rusak_berat'];
        $sarana = [];

        foreach (range(1, 120) as $index) {
            $condition = $conditions[($index - 1) % count($conditions)];

            $sarana[] = Sarana::updateOrCreate(
                ['kode_sarana' => sprintf('DEMO-S-%03d', $index)],
                [
                    'nama_sarana' => sprintf('%s %03d', $names[($index - 1) % count($names)], $index),
                    'id_kategori' => $categories[($index - 1) % count($categories)]->id,
                    'id_ruangan' => $rooms[(intdiv($index - 1, 5)) % count($rooms)]->id,
                    'kondisi' => $condition,
                    'status_perbaikan' => $index % 7 === 0 ? 'dalam_perbaikan' : 'normal',
                    'jumlah' => (($index - 1) % 20) + 1,
                ],
            );
        }

        return $sarana;
    }

    /**
     * @param  list<User>  $murid
     * @param  list<Sarana>  $sarana
     */
    private function seedLaporan(array $murid, array $sarana): void
    {
        $damageTypes = ['Kerusakan ringan', 'Gangguan listrik', 'Tidak dapat menyala', 'Komponen aus', 'Kerusakan fisik'];
        $statuses = ['pending', 'dalam_perbaikan', 'selesai', 'ditolak'];

        foreach (range(1, 150) as $index) {
            $facility = $sarana[($index - 1) % count($sarana)];

            LaporanSarana::updateOrCreate(
                ['deskripsi_kerusakan' => sprintf('[DEMO-L%03d] Pemeriksaan %s memerlukan tindak lanjut.', $index, $facility->nama_sarana)],
                [
                    'id_murid' => $murid[($index - 1) % count($murid)]->id,
                    'id_sarana' => $facility->id,
                    'id_ruangan' => $facility->id_ruangan,
                    'jenis_kerusakan' => $damageTypes[($index - 1) % count($damageTypes)],
                    'foto' => null,
                    'status' => $statuses[($index - 1) % count($statuses)],
                    'tanggal_laporan' => now()->subDays($index % 90)->startOfDay(),
                ],
            );
        }
    }

    /**
     * @param  array<string, list<User>>  $usersByRole
     * @param  list<Sarana>  $sarana
     */
    private function seedBeritaAcara(array $usersByRole, array $sarana): void
    {
        $actions = ['perbaikan', 'pemeliharaan', 'penghapusan'];
        $creators = [...$usersByRole['admin'], ...$usersByRole['petugas_sarpras'], ...$usersByRole['guru']];

        foreach (range(1, 75) as $index) {
            $facility = $sarana[($index - 1) % count($sarana)];
            $action = $actions[($index - 1) % count($actions)];

            BeritaAcara::updateOrCreate(
                ['no_berita_acara' => sprintf('BA-DEMO-%04d', $index)],
                [
                    'id_user_pembuat' => $creators[($index - 1) % count($creators)]->id,
                    'id_sarana' => $facility->id,
                    'jenis_tindakan' => $action,
                    'keterangan' => sprintf('Dokumen demo: hasil %s pada %s telah dicatat untuk uji pencarian.', $action, $facility->nama_sarana),
                    'tanggal' => now()->subDays($index)->toDateString(),
                ],
            );
        }
    }
}
