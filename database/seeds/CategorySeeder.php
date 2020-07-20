<?php

use Illuminate\Database\Seeder;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            1 => ['name' => 'Bolos e Tortas Doces'],
            2 => ['name' => 'Carnes'],
            3 => ['name' => 'Aves'],
            4 => ['name' => 'Peixes e Frutos do Mar'],
            5 => ['name' => 'Saladas'],
            6 => ['name' => 'Molhos e Acompanhamentos'],
            7 => ['name' => 'Sopas'],
            8 => ['name' => 'Massas'],
            9 => ['name' => 'Bebidas'],
            10 => ['name' => 'Doces e Sobremesas'],
            11 => ['name' => 'Lanches'],
            12 => ['name' => 'Prato Único'],
            13 => ['name' => 'Light'],
            14 => ['name' => 'Light'],
            15 => ['name' => 'Alimentação Saúdavel'],
        ]);
    }
}
