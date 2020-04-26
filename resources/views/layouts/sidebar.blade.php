<?php

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
        "link" => "#",
        "icon" => "",
      ],
      [
        "title" => "Hari Efektif",
        "link" => "#",
        "icon" => "",
      ],
      [
        "title" => "Hari Tidak Efektif",
        "link" => "#",
        "icon" => "",
      ],
    ]
  ],
  [
    "title" => "Menu 1",
    "link" => "#",
    "icon" => "fas fa-th",
    "children" => [
      [
        "title" => "Sub Menu 1",
        "link" => "#",
        "icon" => "",
      ],
      [
        "title" => "Sub Menu 2",
        "link" => "#",
        "icon" => "",
      ],
    ]
  ],
  [
    "title" => "Setting",
    "link" => "#",
    "icon" => "fas fa-cogs",
  ]
];

?>



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