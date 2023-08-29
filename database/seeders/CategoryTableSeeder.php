<?php
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\Category;

    class CategoryTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $main = Category::create([
                'level' => 1,
                'parent_id' => null,
                'name' => 'main Category',
            ]);
            $sub = Category::create([
                'level' => 2,
                'parent_id' => $main->id,
                'name' => 'Sub Category',
            ]);
        }
    }
