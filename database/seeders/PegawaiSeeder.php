<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'nip' => '198501152010011001',
                'nama' => 'Ahmad Fauzi',
                'golongan' => 'III/a',
                'jabatan' => 'Analis Kepegawaian Ahli Pertama',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1985-01-15',
                'tanggal_mulai_kerja' => '2010-01-01',
                'instansi_asal' => 'BKPSDM Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198703202012012002',
                'nama' => 'Siti Nurhaliza',
                'golongan' => 'III/b',
                'jabatan' => 'Pengelola Kepegawaian',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1987-03-20',
                'tanggal_mulai_kerja' => '2012-01-01',
                'instansi_asal' => 'Dinas Pendidikan Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198211102008011003',
                'nama' => 'Dedi Kurniawan',
                'golongan' => 'III/c',
                'jabatan' => 'Pranata Komputer Ahli Muda',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1982-11-10',
                'tanggal_mulai_kerja' => '2008-01-01',
                'instansi_asal' => 'Dinas Komunikasi dan Informatika Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '199005252015032004',
                'nama' => 'Rina Marlina',
                'golongan' => 'III/a',
                'jabatan' => 'Analis Sumber Daya Manusia Aparatur',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1990-05-25',
                'tanggal_mulai_kerja' => '2015-03-01',
                'instansi_asal' => 'Dinas Kesehatan Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198612122011011005',
                'nama' => 'Budi Santoso',
                'golongan' => 'III/d',
                'jabatan' => 'Kepala Subbagian Umum dan Kepegawaian',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1986-12-12',
                'tanggal_mulai_kerja' => '2011-01-01',
                'instansi_asal' => 'Sekretariat Daerah Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '199203182016022006',
                'nama' => 'Dewi Anggraini',
                'golongan' => 'III/b',
                'jabatan' => 'Analis Perencanaan',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1992-03-18',
                'tanggal_mulai_kerja' => '2016-02-01',
                'instansi_asal' => 'Bappeda Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198409072009021007',
                'nama' => 'Agus Setiawan',
                'golongan' => 'III/c',
                'jabatan' => 'Pengawas Penyelenggaraan Urusan Pemerintahan',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1984-09-07',
                'tanggal_mulai_kerja' => '2009-02-01',
                'instansi_asal' => 'Inspektorat Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '199406142018012008',
                'nama' => 'Fitri Handayani',
                'golongan' => 'III/a',
                'jabatan' => 'Pengadministrasi Perkantoran',
                'pendidikan_terakhir' => 'D4',
                'tanggal_lahir' => '1994-06-14',
                'tanggal_mulai_kerja' => '2018-01-01',
                'instansi_asal' => 'Dinas Sosial Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198811232013011009',
                'nama' => 'Rudi Hermawan',
                'golongan' => 'III/d',
                'jabatan' => 'Analis Keuangan Pusat dan Daerah',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => '1988-11-23',
                'tanggal_mulai_kerja' => '2013-01-01',
                'instansi_asal' => 'Badan Pengelolaan Keuangan dan Aset Daerah Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '199107302014022010',
                'nama' => 'Lina Permatasari',
                'golongan' => 'III/b',
                'jabatan' => 'Analis Kebijakan Ahli Pertama',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => '1991-07-30',
                'tanggal_mulai_kerja' => '2014-02-01',
                'instansi_asal' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Majalengka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
