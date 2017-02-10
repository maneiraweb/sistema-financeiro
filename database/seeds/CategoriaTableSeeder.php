<?php

use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{
    use \SisFin\Repositories\GetClientesTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = $this->getClientes();

        factory(\SisFin\Models\Categoria::class, 30)
            ->make()
            ->each(function($categoria) use($clientes){
                $cliente = $clientes->random();
                $categoria->cliente_id = $cliente->id;
                $categoria->save();
            });
        $categoriasRoot = $this->getCategoriasRoot();

        foreach ($categoriasRoot as $root) {
            factory(\SisFin\Models\Categoria::class, 3)
            ->make()
            ->each(function($categoriaFilha) use($root){
                $categoriaFilha->cliente_id = $root->cliente_id;
                $categoriaFilha->save();
                $categoriaFilha->parent()->associate($root);
                $categoriaFilha->save();
            });
        }
    }

    private function getCategoriasRoot() {
        $repository = app(\SisFin\Repositories\CategoriaRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
