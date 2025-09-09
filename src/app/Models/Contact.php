<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    //スコープ検索処理
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('first_name', $keyword)
                  ->orWhere('last_name', $keyword)
                  ->orWhere('email', $keyword)
                  ->orWhere('first_name', 'like', '%' . $keyword . '%')
                  ->orWhere('last_name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%')
                  ->orWhereRaw("CONCAT(last_name, first_name)= ?", [$keyword])
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ['%' . $keyword . '%']);
            });
        }
    }


    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }
    }

    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
    }

    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
    }

}