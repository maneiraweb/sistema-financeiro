<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancosData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $repository = app(\SisFin\Repositories\BancoRepository::class);
        foreach ($this->getData() as $bancoArray) {
            $repository->create($bancoArray);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $repository = app(\SisFin\Repositories\BancoRepository::class);
        $repository->skipPresenter(true);
        $count = count($this->getData());
        foreach (range(1, $count) as $value){
            $model = $repository->find($value);
            $path = \SisFin\Models\Banco::logosDir() . '/' . $model->logo; // caminho para excluir imagem
            \Storage::disk('public')->delete($path);
            $model->delete();
        }
    }

    public function getData() {
        return [
            [
                'nome' => 'Banco do Brasil',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/banco-do-brasil.png'),
                    'banco-do-brasil.png'
                )
            ],
            [
                'nome' => 'Banrisul',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/banrisul.png'),
                    'banrisul.png'
                )
            ],
            [
                'nome' => 'Bradesco',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/bradesco.jpg'),
                    'bradesco.jpg'
                )
            ],
            [
                'nome' => 'Caixa',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/caixa.jpg'),
                    'caixa.jpg'
                )
            ],
            [
                'nome' => 'Cresol',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/cresol.png'),
                    'cresol.png'
                )
            ],
            [
                'nome' => 'Itaú',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/itau.jpg'),
                    'itau.jpg'
                )
            ],
            [
                'nome' => 'Santander',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/bancos/logos/santander.jpg'),
                    'santander.jpg'
                )
            ],
        ];
    }
}
