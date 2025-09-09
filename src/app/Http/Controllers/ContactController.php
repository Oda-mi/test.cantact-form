<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;


class ContactController extends Controller
{

    //入力画面の表示
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }


    //入力画面から確認画面へデータを渡す
    public function confirm(ContactRequest $request)
    {
        $contact = $request->only
        ([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel1','tel2','tel3',
            'address',
            'building',
            'category_id',
            'detail'
        ]);

        $categories = Category::all();
        
        return view('confirm', compact('contact', 'categories'));
    }


    //入力データをDBに保存
    public function store(ContactRequest $request)
    {
        $tel = $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3;
        
        $contact = $request->only
        ([
            'last_name',
            'first_name',
            'gender',
            'email',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
        $contact['tel'] = $tel;

        Contact::create($contact);
        
        return redirect('/thanks');
    }


    //サンクスページの表示
    public function thanks()
    {
        return view('thanks');
    }

}
