<?php
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\IbuBapa;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Try to create or update test parent
    $parent = IbuBapa::updateOrCreate(
        ['ID_Parent' => 'TEST001'],
        [
            'namaParent' => 'Test Parent',
            'emel' => 'test@parent.com',
            'noTel' => '0123456789',
            'kataLaluan' => bcrypt('password123'),
            'diciptaOleh' => 'ADMIN01', 
        ]
    );
    
    echo "✅ Test parent created/updated successfully\n";
    echo "Username: TEST001\n";
    echo "Password: password123\n";
    echo "Name: " . $parent->namaParent . "\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
}
