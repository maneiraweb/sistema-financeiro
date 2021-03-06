<?php

use Illuminate\Database\Seeder;

class CategoryRevenuesTableSeeder extends Seeder
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

        factory(\SisFin\Models\CategoryRevenue::class, 15)
            ->make()
            ->each(function($categoy) use($clientes){
                $cliente = $clientes->random();
                $categoy->cliente_id = $cliente->id;
                $categoy->save();
            });
        $categoriesRoot = $this->getCategoriesRoot();

        foreach ($categoriesRoot as $root) {
            factory(\SisFin\Models\CategoryRevenue::class, 3)
            ->make()
            ->each(function($categoryFilha) use($root){
                $categoryFilha->cliente_id = $root->cliente_id;
                $categoryFilha->save();
                $categoryFilha->parent()->associate($root);
                $categoryFilha->save();
            });
        }
    }

    private function getCategoriesRoot() {
        $repository = app(\SisFin\Repositories\CategoryRevenueRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
