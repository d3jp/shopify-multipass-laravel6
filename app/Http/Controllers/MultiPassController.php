<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ShopifyMultiController;
use Illuminate\Support\Facades\Auth;

class MultiPassController extends Controller
{
    
    public function index(){
        $user = Auth::user(); // ログインユーザ情報の取得
        
        // Shopifyへリクエストするユーザ情報の作成
        $customer_data = array(
            "email" => $user->email,
            "first_name" => $user->name,
            "return_to" => "https://hoge.myshopify.com/" //リダイレクト先URL
        );

        $multipass = new ShopifyMultiController("multipass secret from shop admin"); //キーを使ってインスタンスを作成

        $token = $multipass->generate_token($customer_data); //tokenの作成

        $url = "https://hoge.myshopify.com/account/login/multipass/".$token;

        return redirect()->away($url); //作成したURLへリダイレクトする
    }
}