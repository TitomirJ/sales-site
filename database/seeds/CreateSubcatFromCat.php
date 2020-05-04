<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Subcategory;

class CreateSubcatFromCat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $categories = Category::orderBy('name', 'asc')->get();
//
//        foreach ($categories as $c){
//            if($c->subcategories->count() == 0){
//                Subcategory::firstOrCreate([
//                    'category_id' => $c->id
//                ],[
//                    'category_id' => $c->id,
//                    'name' => $c->name
//                ]);
//            }
//        }

        $subcategories = Subcategory::all();

        foreach ($subcategories as $s){
            $subcategory = Subcategory::find($s->id);
            $subcategory->commission = ($subcategory->commission + 5);
            $subcategory->save();
        }
    }
}
