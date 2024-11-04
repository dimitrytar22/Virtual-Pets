@extends("admin.layout")


@section('title')
    Edit Fortune Prize
@endsection

@section('content')
    <x-fortune-wheel-submenu></x-fortune-wheel-submenu>

    <main>
        <section id="pets">
            <h2>Virtual Pets - Edit Prize</h2>
            <form class="form" method="POST" action="{{ route('admin.fortune_wheel.prizes.update', $prize->id) }}">
                @csrf
                @method('PUT')
                <label for="title">Prize Title:</label>

                <input type="text" name="title" id="title" value="{{$prize->title}}" />



                <label for="description">Prize Description:</label>
                <input type="text" id="description" name="description" value="{{$prize->description}}" required>

                <label for="related_item">Related Item:</label>
                <select type="text" id="related_item" name="related_item">
                    <option value="">Not an item</option>
                    @foreach($items as $item)
                        <option value="{{$item->id}}"
                                @if($prize->related_item == $item->id)
                                    {{'selected'}}
                                    @endif
                        >{{$item->title}}</option>
                    @endforeach
                </select>

                <label for="amount">Prize Amount:</label>
                <input type="number" id="amount" name="amount" value="{{$prize->amount}}" required>

                <label for="chance">Prize Chance:</label>
                <input type="number" id="chance" name="chance" value="{{$prize->chance}}" required>

                <button type="submit">Save Prize</button>
            </form>
        </section>


    </main>
@endsection
