<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    //管理画面の表示
    public function index(Request $request)
    {
        $categories = Category::all();

        $contacts = Contact::with('category')
           ->keywordSearch($request->keyword)
           ->genderSearch($request->gender)
           ->categorySearch($request->category_id)
           ->dateSearch($request->date)
           ->paginate(7);

        return view('admin.index', compact('contacts','categories'));
    }


    //データの削除
    public function destroy($id)
    {
        Contact::find($id)->delete();
        
        return redirect('/admin');
    }


    //エクスポート
    public function export(Request $request)
    {

        $contacts = Contact::with('category')
        ->keywordSearch($request->keyword)
        ->genderSearch($request->gender)
        ->categorySearch($request->category_id)
        ->dateSearch($request->date)
        ->get();

    //CSVのヘッダー
        $csvHeader = ['名前','性別','メールアドレス','電話番号','住所','お問い合わせ種類','お問い合わせ内容','作成日時','更新日時'];

    //ファイル名（テーブル名＋日付）
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';



        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, $csvHeader);

        foreach ($contacts as $c) {
            fputcsv($handle, [
            $c->last_name . ' ' . $c->first_name,
            $c->gender === 'male' ? '男性' : ($c->gender === 'female' ? '女性' : 'その他'),
            $c->email,
            $c->tel,
            $c->address,
            $c->category->content,
            $c->detail,
            $c->created_up,
            $c->updated_at,
        ]);
        }
    
            rewind($handle);
            $csv = "\xEF\xBB\xBF" . stream_get_contents($handle);
            fclose($handle);
    
        return response($csv)
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', "attachment; filename={$filename}");
}
}
