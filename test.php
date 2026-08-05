<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$b = \App\Models\Barang::all();
foreach($b as $x) {
    echo $x->id . ' - ' . $x->nama_barang . PHP_EOL;
}
