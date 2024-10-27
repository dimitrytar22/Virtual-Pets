@extends("admin.layout")


@section('title')
    Manage Fortune Wheel
@endsection

@section('content')
    <x-fortune-wheel-submenu></x-fortune-wheel-submenu>

    <main>
        <section id="pets">
            <h2>Virtual Pets - Create Prize</h2>
            <form class="form" method="POST" action="{{ route('admin.fortune_wheel.prizes.store') }}">
                @csrf
                @method('POST')
                <label for="title">Prize Title:</label>

                <input type="text" name="title" id="title" />



                <label for="description">Prize Description:</label>
                <input type="text" id="description" name="description" required>

                <label for="related_item">Related Item:</label>
                <select type="text" id="related_item" name="related_item">
                    <option value="">Not an item</option>
                   @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                   @endforeach
                </select>

                <label for="amount">Prize Amount:</label>
                <input type="number" id="amount" name="amount" required>

                <label for="chance">Prize Chance:</label>
                <input type="number" id="chance" name="chance" required>

                <button type="submit">Save Prize</button>
            </form>
        </section>


    </main>
@endsection
