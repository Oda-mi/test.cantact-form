@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('content')

<header class="header">
        <div class="header_inner">
            <a href="/" class="header_logo">
                FashionablyLate
            </a>
            <a href="/login" class="header_logout">logout</a>
        </div>
</header>

<div class="admin__content">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>
    <div class="admin__search">
        <form action="" method="get">
            @csrf
            <input type="text" name="keyword" class="admin__search-input" placeholder="名前やメールアドレスを入力してください">

            <div class="select-wrapper select-gender">
            <select name="gender" class="admin__search-select">
                <option value="" selected>性別</option>
                <option value="">全て</option>
                <option value="male">男性</option>
                <option value="female">女性</option>
                <option value="other">その他</option>
            </select>
            </div>

            <div class="select-wrapper select-category">
            <select name="category_id" class="admin__search-select">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $category)
                   <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                @endforeach
            </select>
            </div>

            <div class="select-wrapper select-date">
            <input type="date" name="date" placeholder="年/月/日">
            </div>

            <button class="btn_search" type="submit">検索</button>
            <button class="btn_reset" type="reset">リセット</button>
        </form>
    </div>

{{--エクスポート--}}
    <div class="admin__export-pagination">
        <div class="admin__export">
            <form action="/admin/export" method="post">
                @csrf
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">

                <button class="btn_export">エクスポート</button>
            </form>
        </div>

{{--ページネーション--}}
        <div class="admin__pagination">
            @if ($contacts->onFirstPage())
            <span class="page-item">&lt;</span>
            @else
            <a href="{{ $contacts->previousPageUrl() }}" class="page-item">&lt;</a>
            @endif

            @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
            @if ($page == $contacts->currentPage())
            <span class="page-item active">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="page-item">{{ $page }}</a>
            @endif
            @endforeach

            @if ($contacts->hasMorePages())
            <a href="{{ $contacts->nextPageUrl() }}" class="page-item">&gt;</a>
            @else
            <span class="page-item">&gt;</span>
            @endif
        </div>
    </div>

{{--テーブル--}}
    <div class="admin__table">
        <table>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact['last_name'] }} {{ $contact['first_name'] }}</td>
                <td>
                    @if ($contact['gender'] === 'male')
                      男性
                    @elseif ($contact['gender'] === 'female')
                      女性
                    @else
                      その他
                    @endif
                </td>
                <td>{{ $contact['email'] }}</td>
                <td>{{ $contact->category->content }}</td>
                <td>
                    <button class="btn_detail"
                            data-id="{{ $contact->id }}"
                            data-name="{{ $contact['last_name'] }} {{ $contact['first_name'] }}"
                            data-gender="{{ $contact['gender'] }}"
                            data-email="{{ $contact['email'] }}"
                            data-tel="{{ $contact['tel'] }}"
                            data-address="{{ $contact['address'] }}"
                            data-building="{{ $contact['building'] }}"
                            data-category="{{ $contact->category->content }}"
                            data-detail="{{ $contact['detail'] }}">
                            詳細
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>



{{--モーダルウィンドウ--}}
<div id="detailModal" class="modal hidden">
    <div class="modal__content">
        <div id="modalClose" class="modal__close">&times;</div>
        <div class="modal-item">
            <div class="modal-label">名前</div>
            <div class="modal-value" id="modalName"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">性別</div>
            <div class="modal-value" id="modalGender"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">メールアドレス</div>
            <div class="modal-value" id="modalEmail"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">電話番号</div>
            <div class="modal-value" id="modalTel"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">住所</div>
            <div class="modal-value" id="modalAddress"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">建物名</div>
            <div class="modal-value" id="modalBuilding"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">お問い合わせの種類</div>
            <div class="modal-value" id="modalCategory"></div>
        </div>
        <div class="modal-item">
            <div class="modal-label">お問い合わせ内容</div>
            <div class="modal-value" id="modalDetail"></div>
        </div>
        <div class="modal-button">
            <button class="btn-delete" id="modalDelete">削除</button>
        </div>
        <form id="deleteForm" method="POST" style="display:none;">
            @method('DELETE')
            @csrf
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("detailModal");
    const modalClose = document.getElementById("modalClose");
    const detailButtons = document.querySelectorAll(".btn_detail");
    const deleteButton = document.getElementById("modalDelete");

    detailButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("modalName").textContent = btn.dataset.name;
            document.getElementById("modalGender").textContent =
                btn.dataset.gender === "male" ? "男性" :
                btn.dataset.gender === "female" ? "女性" : "その他";
            document.getElementById("modalEmail").textContent = btn.dataset.email;
            document.getElementById("modalTel").textContent = btn.dataset.tel;
            document.getElementById("modalAddress").textContent = btn.dataset.address;
            document.getElementById("modalBuilding").textContent = btn.dataset.building;
            document.getElementById("modalCategory").textContent = btn.dataset.category;
            document.getElementById("modalDetail").textContent = btn.dataset.detail;

            deleteButton.dataset.id = btn.dataset.id;

            modal.classList.remove("hidden");
        });
    });

    modalClose.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

{{--モーダルウィンドウ内の削除ボタン--}}
    deleteButton.addEventListener("click", function() {
        const id = this.dataset.id;
        if (confirm('本当に削除しますか？')) {
             const form = document.getElementById("deleteForm");
             form.action = `/admin/delete/${id}`;
             form.submit();
        }
    });
});

</script>

@endsection