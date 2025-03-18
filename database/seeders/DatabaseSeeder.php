<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          \App\Models\categorie::factory(10)->create();
          \App\Models\article::factory(10)->create();
          \App\Models\client::factory(10)->create();
          \App\Models\fournisseur::factory(10)->create();
          \App\Models\contenir::factory(10)->create();
          \App\Models\commande::factory(10)->create();
          \App\Models\achat::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
