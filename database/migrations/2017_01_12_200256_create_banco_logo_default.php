<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancoLogoDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $logo = new \Illuminate\Http\UploadedFile(
            storage_path('app/files/bancos/logos/sem-logo.png'),
            'sem-logo.png'
        );
        $nome = env('BANCO_LOGO_DEFAULT');
        $destFile = \SisFin\Models\Banco::logosDir();

        \Storage::disk('public')->putFileAs($destFile, $logo, $nome);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $name = env('BANCO_LOGO_DEFAULT');
        $path = \SisFin\Models\Banco::logosDir() . '/' . $name;
        \Storage::disk('public')->delete($path);
    }
}
