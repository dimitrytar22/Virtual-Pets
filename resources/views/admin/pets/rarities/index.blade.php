@extends('admin.layout')

@section('title')
    Rarities
@endsection


@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>

        <section id="existing-rarities">
            <h2>Virtual Pets - Existing Rarities</h2>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Rarity Index (1 - often 10 - rarely)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($rarities as $rarity)
                    <tr class="row">
                        <td>{{ $rarity->id }}</td>
                        <td>{{ $rarity->title }}</td>
                        <td class="rarity-index">{{ $rarity->rarity_index }}</td>
                        <td>
                            <button value="{{$rarity->id}}" class="increase-index" style="width: 40px; height: 30px">+</button>
                            <button value="{{$rarity->id}}" class="decrease-index" style="width: 40px; height: 30px">-</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.increase-index').click(function () {

                    var currentIndexElement = $(this).closest('tr').find('.rarity-index');
                    var currentIndex = parseInt(currentIndexElement.text());
                    var newIndex = currentIndex + 1;


                    var id = $(this).val();
                    var rarity_value =newIndex;
                    var url = "{{route('admin.pets.rarities.update', '') }}/" + id
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            'rarity_index': rarity_value,
                            _token: '{{ csrf_token() }}',

                        },
                        success: function (response) {
                            currentIndexElement.text(newIndex);

                        },
                        error: function (xhr, status, error) {
                            console.error('Error increasing index:', error);
                        }
                    });
                });

                $('.decrease-index').click(function () {

                    var currentIndexElement = $(this).closest('tr').find('.rarity-index');
                    var currentIndex = parseInt(currentIndexElement.text());
                    var newIndex = currentIndex - 1;

                    var id = $(this).val();
                    var rarity_value =newIndex;
                    var url = "{{route('admin.pets.rarities.update', '') }}/" + id
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            'rarity_index': rarity_value,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {

                            currentIndexElement.text(newIndex);

                        },
                        error: function (xhr, status, error) {
                            console.error('Error decreasing index:', error);
                        }
                    });
                });
            });
        </script>

    </main>

@endsection
