@extends('admin.layout')

@section('title')
    User's inventories edit
@endsection

@section('content')
    <div class="container">
        <h2>Edit ItemUser</h2>
        <form class="form" method="POST" action="{{ route('admin.users.inventories.update', $itemUser->id) }}">
            @csrf
            @method('PUT')

            <label for="title">Item Title:</label>
            <input type="text" list="title" name="title" value="{{ $itemUser->item->title }}" readonly />


            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="{{ $itemUser->id }}" required>





            @php
                $url = url()->previous();
                $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
            @endphp
            <input type="hidden" name="previous_page" value="{{$route}}">
            <button type="submit">Save Item</button>
        </form>
    </div>
@endsection


