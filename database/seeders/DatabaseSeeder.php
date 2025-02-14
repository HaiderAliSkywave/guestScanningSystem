<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin@12345'),
            'role' => 'admin',
        ]);
        
        User::factory()->create([
            'name' => 'Searcher',
            'email' => 'searcher1@gss.com',
            'password' => Hash::make('password'),
            'role' => 'searcher',
        ]);
        
        User::factory()->create([
            'name' => 'Searcher',
            'email' => 'searcher2@gss.com',
            'password' => Hash::make('password'),
            'role' => 'searcher',
        ]);
        
        User::factory()->create([
            'name' => 'Searcher',
            'email' => 'searcher3@gss.com',
            'password' => Hash::make('password'),
            'role' => 'searcher',
        ]);
        
        User::factory()->create([
            'name' => 'Searcher',
            'email' => 'searcher4@gss.com',
            'password' => Hash::make('password'),
            'role' => 'searcher',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender1@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender2@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender3@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender4@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender5@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender6@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender7@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender8@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender9@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
        
        User::factory()->create([
            'name' => 'Attender',
            'email' => 'attender10@gss.com',
            'password' => Hash::make('password'),
            'role' => 'attender',
        ]);
    }
}
