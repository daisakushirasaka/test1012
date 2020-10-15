<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;

class CreateRecipeController extends Controller
{
	// バリデーションのルール
	protected $validationRules = [
		"name" => ["required", "string"],
		"url" => ["nullable", "url"],
		"description" => ["nullable","string"]
	];

	// ログインしていないと使用できない様にする
    function __construct(){
		$this->middleware('auth');
    }

	// レシピ登録フォームを表示
	function create(){
		return view("recipe.recipe_create_form");
	}

	// レシピ登録フォームからの遷移先
	function store(Request $request){
		//入力値の受け取り
		$validatedData = $request->validate($this->validationRules);

		//作成するユーザーIDを設定\
		$validatedData["user_id"] = \Auth::id();

		//レシピの保存
		$new = Recipe::create($validatedData);
		
		//登録後は一覧に遷移
		return redirect()->route("recipe_list")
				->withStatus("おめでとうございます！【 {$new->name}】が新たに作成され、一覧に追加されました！");
	}
}
