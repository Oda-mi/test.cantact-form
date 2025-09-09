# test.contact-form

## 環境構築
1. リポジトリをクローン
```bash
git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
cd test.contact-form
```

2. Dockerでビルド・起動
```bash
docker-compose up -d --build
```

3. 依存パッケージのインストール
```bash
docker-compose exec app composer install
```

4. 環境設定ファイルの作成
```bash
docker-compose exec app cp .env.example .env
```
必要に応じて `.env` の内容を編集

5. マイグレーション
```bash
docker-compose exec app php artisan migrate
```

6. シーディング
```bash
docker-compose exec app php artisan db:seed
```


## 使用技術(実行環境)
- Laravel 8.83.8
- PHP 8.4.10
- MySQL 8.0
- Docker


## ER図
![ER図](docs/test.contact-form.svg)


## URL (開発環境)
- お問い合わせフォーム入力ページ: http://localhost/
- お問い合わせフォーム確認ページ: http://localhost/confirm
- サンクスページ: http://localhost/thanks
- 管理画面: http://localhost/admin
- ユーザ登録ページ: http://localhost/register
- ログインページ: http://localhost/login
- phpMyAdmin: http://localhost:8080


