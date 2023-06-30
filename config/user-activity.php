<?php

return [
    'activated'        => true, // active/inactive all logging
    'middleware'       => ['web', 'auth'],
    'route_path'       => 'admin/user-activity',
    'admin_panel_path' => 'admin/dashboard',
    'delete_limit'     => 7, // default 7 days

    'model' => [
      'user' => "App\Models\Users",
      'instansi' => "App\Models\Instansi",
      'dengan_harap' => "App\Models\DenganHarap",
      'jabatan' => "App\Models\Jabatan",
      'jenis_surat' => "App\Models\JenisSurat",
      'sifat_surat' => "App\Models\SifatSurat",
      'asn' => "App\Models\MasterASN",
      'surat_masuk' => "App\Models\SuratMasuk",
      'surat_keluar' => "App\Models\SuratKeluar",
      'surat_disposisi' => "App\Models\SuratDisposisi",
      'surat_tugas' => "App\Models\SuratTugas",
      'surat_bast' => "App\Models\SuratBAST",
      'surat_keputusan' => "App\Models\SuratKeputusan",
      'surat_tte' => "App\Models\FileTte"
    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true
    ]
];
