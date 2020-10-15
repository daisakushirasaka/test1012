<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Recipe;
class RecipeListController extends Controller
{
    function __construct(){
		$this->middleware('auth');
	}
	function show(Request $request){
		//自分で登録したレシピを取り出す
		$recipe_list = Recipe::where("user_id","=",\Auth::id())
			//並び順を新しい順にする
			->orderBy("id","desc")
			//20件毎にページングする
			->paginate(20);
		//View:recipe.recipe_listを表示する
		return view("recipe.recipe_list",[
			"recipe_list" => $recipe_list
		]);
	}
}
