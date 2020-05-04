<?php

use Illuminate\Database\Seeder;
use App\Test;
use App\Subcategory;
use App\Category;

class RecopyAllSubcategoriesAgain extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = Subcategory::all();
        foreach ($subcategories as $s){
            $sub = Subcategory::find($s->id);
            $cat = Category::find($sub->category_id);
            $sub->commission = $cat->commission;
            $sub->save();
        }
  //  $new_subcategories = Test::all();
//
//        foreach ($new_subcategories as $new){
//            Subcategory::create([
//                'category_id' => $new->category_id,
//                'market_subcat_id' => $new->market_subcat_id,
//                'parent_subcat_id' => $new->parent_subcat_id,
//                'name' => $new->name,
//                'commission' => $new->commission,
//            ]);
//        }

      //  $sub = App\Test::all();
//        $mark_id = [];
//        $par_id = [];
//        foreach ($sub as $a){
//            array_push($mark_id, $a->market_subcat_id);
//            array_push($par_id, $a->parent_id);
//        }
//
//        $res = [];
//        for($i=0; $i < count($mark_id); $i++){
//            if(!in_array($mark_id[$i], $par_id)){
//                array_push($res, $mark_id[$i]);
//            }
//        }
//
//        $subcat = App\Subcategory::all();
//        $subcat_mark_id = [];
//
//        foreach ($subcat as $a){
//            array_push($subcat_mark_id, $a->market_subcat_id);
//        }
//
//        $new = $mark_id;
//        $new_res = array_diff ($new, $subcat_mark_id);
    //    $new_res = App\Subcategory::where('category_id', 314)->get();

    //    foreach ($new_res as $key){
//            foreach ($sub as $a){
//                if($key->market_subcat_id == $a->market_subcat_id){
//                $q = Subcategory::find($key->id);
//                $q->parent_subcat_id = $a->parent_id;
//                    $q->save();
//                }
//            }
//        }


    }
}
