<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNull('slug')->get();
        
        foreach ($users as $user) {
            $slug = Str::slug($user->name) . '-' . $user->id;
            
            // S'assurer que le slug est unique
            $originalSlug = $slug;
            $counter = 1;
            
            while (User::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $user->update(['slug' => $slug]);
        }
    }
}
