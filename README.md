## Shopifyのmultipassログインをlaravelに実装

ログイン後にShopifyのmultipassログイン（SSO）を実装（Shopify Plusプランのみ　※2020年8月）
[ShopifyのMultipass](https://shopify.dev/docs/admin-api/rest/reference/plus/multipass)


### ユーザーの動き

1. ログインフォームでログイン
2. 指定のURLにリダイレクトされる（すでにShopifyにログインされている）


### 処理の流れ

1. Laravelのログイン処理を上書き
2. ログイン後のリダイレクトURLをmultipassのルーティングに指定（冗長か？）
3. ログインユーザーからトークンを作成し、Shopifyのトークン付きURLにリダイレクト


## 見るべきは、、、

1. ログイン周りのコントローラ
2. ルーティング
3. MultipassController
4. ShopifyMultipassController


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
