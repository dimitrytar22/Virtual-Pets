@extends('admin.layout')

@section('title')
    Add Item
@endsection

@section('content')
    <x-users-submenu></x-users-submenu>
    <div class="container">
        <h2>Add Item</h2>
        <form class="form" method="POST" action="{{route('admin.users.inventories.store')}}">
            @csrf
            @method('POST')


            <label for="users">User:</label>
            <select name="user_id" id="users">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{'@'}}{{$user->name}}, {{$user->chat_id}}</option>
                @endforeach
            </select>

            <label for="item">Item:</label>
            <select name="item_id" id="item">
                @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>


            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="" required>





            @php
                $url = url()->previous();
                $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
            @endphp
            <input type="hidden" name="previous_page" value="{{$route}}">
            <button type="submit">Save Item</button>
        </form>
    </div>
@endsection
