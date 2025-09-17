<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyUser = User::role('company')->first();
        $adminUser = User::role('admin')->first();

        if (!$companyUser || !$adminUser) {
            return;
        }

        
        $jobs = [
            [
                'title' => 'Staff Administrasi',
                'company' => 'CV. Maju Jaya',
                'location' => 'Martapura',
                'description' => 'Dicari staff administrasi untuk menangani urusan administrasi kantor, filing dokumen, dan membantu kegiatan operasional harian perusahaan. Kandidat yang ideal memiliki kemampuan komunikasi yang baik dan teliti dalam bekerja.',
                'salary' => 3500000,
                'deadline' => now()->addDays(30),
                'user_id' => $companyUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Surat Lamaran',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Pengalaman Kerja (Tahun)',
                        'type' => 'number',
                        'required' => false
                    ]
                ]
            ],
            [
                'title' => 'Marketing Executive',
                'company' => 'PT. Berkah Sukses',
                'location' => 'Belitang',
                'description' => 'Perusahaan kami membutuhkan marketing executive yang berpengalaman untuk mengembangkan pasar di wilayah Oku Timur. Kandidat harus memiliki kemampuan negosiasi yang baik dan siap bekerja dengan target.',
                'salary' => 4500000,
                'deadline' => now()->addDays(25),
                'user_id' => $companyUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Portfolio',
                        'type' => 'file',
                        'required' => false
                    ],
                    [
                        'label' => 'Pengalaman Marketing',
                        'type' => 'textarea',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Guru Matematika',
                'company' => 'SMA Negeri 1 Martapura',
                'location' => 'Martapura',
                'description' => 'Sekolah membutuhkan guru matematika untuk mengajar siswa SMA. Kandidat harus memiliki latar belakang pendidikan matematika atau pendidikan matematika dan memiliki pengalaman mengajar.',
                'salary' => 4000000,
                'deadline' => now()->addDays(20),
                'user_id' => $adminUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Ijazah',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Sertifikat Mengajar',
                        'type' => 'file',
                        'required' => false
                    ],
                    [
                        'label' => 'Pengalaman Mengajar (Tahun)',
                        'type' => 'number',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Teknisi Komputer',
                'company' => 'CV. Digital Solution',
                'location' => 'Belitang Hilir',
                'description' => 'Dicari teknisi komputer yang berpengalaman dalam service hardware dan software. Kandidat harus memahami troubleshooting komputer dan jaringan dasar.',
                'salary' => 3800000,
                'deadline' => now()->addDays(15),
                'user_id' => $companyUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Sertifikat Keahlian',
                        'type' => 'file',
                        'required' => false
                    ],
                    [
                        'label' => 'Pengalaman Teknis',
                        'type' => 'textarea',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Kasir',
                'company' => 'Minimarket Rejeki',
                'location' => 'Cit',
                'description' => 'Minimarket membutuhkan kasir yang jujur dan teliti. Jam kerja fleksibel, cocok untuk fresh graduate. Pengalaman menggunakan mesin kasir menjadi nilai plus.',
                'salary' => 3000000,
                'deadline' => now()->addDays(10),
                'user_id' => $companyUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Foto',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Kesediaan Kerja Shift',
                        'type' => 'radio',
                        'options' => 'Ya, Tidak',
                        'required' => true
                    ]
                ]
            ],
            [
                'title' => 'Driver Pribadi',
                'company' => 'PT. Anugrah Transportasi',
                'location' => 'Pedamaran',
                'description' => 'Dicari driver pribadi yang berpengalaman dan memiliki SIM A. Kandidat harus memiliki pengetahuan rute di Oku Timur dan sekitarnya, serta memiliki attitude yang baik.',
                'salary' => 3200000,
                'deadline' => now()->addDays(7),
                'user_id' => $companyUser->id,
                'application_form' => [
                    [
                        'label' => 'CV',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Foto Copy SIM A',
                        'type' => 'file',
                        'required' => true
                    ],
                    [
                        'label' => 'Pengalaman Mengemudi (Tahun)',
                        'type' => 'number',
                        'required' => true
                    ]
                ]
            ]
        ];

        foreach ($jobs as $jobData) {
            Job::create($jobData);
        }
    }
}
