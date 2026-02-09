<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IbuBapa;
$parents = IbuBapa::select('ID_Parent','namaParent','emel','kataLaluan')->get();
foreach($parents as $p){
    echo $p->ID_Parent . " | " . $p->namaParent . " | " . substr($p->kataLaluan,0,6) . "...\n";
}
