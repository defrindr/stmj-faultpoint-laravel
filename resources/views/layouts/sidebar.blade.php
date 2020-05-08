@php
$sidebar = [
  [
    "title" => "Dashboard",
    "link" => "/",
    "icon" => "fas fa-tachometer-alt",
    "children" => []
  ],
  [
    "title" => "Data Master",
    "link" => "#",
    "icon" => "fas fa-th",
    "role" => "Super Admin",
    "children" => [
      [
        "title" => "Jurusan",
        "link" => route('jurusan.index'),
        "icon" => "",
      ],
      [
        "title" => "Kategori Point",
        "link" => route('kategori-point.index'),
        "icon" => "",
      ],
      [
        "title" => "Hari Efektif",
        "link" => route('hari-efektif.index'),
        "icon" => "",
      ],
      [
        "title" => "Hari Tidak Efektif",
        "link" => route('hari-tidak-efektif.index'),
        "icon" => "",
      ],
    ]
  ],
  [
    "title" => "Kelas",
    "link" => route('kelas.index'),
    "role" => "Super Admin|Wali Kelas",
    "icon" => "fas fa-users",
  ],
  [
    "title" => "User",
    "link" => route('user.index'),
    "role" => "Super Admin",
    "icon" => "fas fa-user",
  ],
  [
    "title" => "Kasus",
    "link" => route('kasus.index'),
    "role" => "Super Admin|Petugas Konseling",
    "icon" => "far fa-file-alt",
  ],
  [
    "title" => "Absensi",
    "link" => route('absensi.index'),
    "role" => "Super Admin|Petugas Absensi",
    "icon" => "far fa-bookmark",
  ],
];
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?= HtmlHelper::generateSidebar($sidebar) ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
