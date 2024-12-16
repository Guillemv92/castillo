<?php

namespace App\Controllers\Admin;

class DashboardController {
    public function index() {
        include __DIR__ . '/../../../templates/admin/dashboard.php';
    }
}
