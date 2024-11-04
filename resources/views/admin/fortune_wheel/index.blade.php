@extends("admin.layout")


@section('title')
    Manage Fortune Wheel Prizes
@endsection

@section('content')
    <x-fortune-wheel-submenu></x-fortune-wheel-submenu>



    <main>

        <section id="existing-prizes">
            <h2>Virtual Pets - Existing Prizes</h2>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Item title</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Chance<br><span style="color:
                    @if($prizes->sum('chance') == 100)
                        {{'green'}}
                        @else
                        {{'red'}}
                    @endif">Total chances: {{$prizes->sum('chance')}}%</span></th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($prizes as $prize)
                    <tr class="row">

                        <td>{{ $prize->id }}</td>
                        <td>{{ $prize->title }}</td>
                        @if(!$prize->item?->title)
                            <td>{{ "Not an item" }}</td>

                        @else
                            <td>{{ $prize->item->title }}</td>

                        @endif
                        <td>{{ $prize->description }}</td>
                        <td class="amount">{{ $prize->amount }}</td>
                        <td class="amount">{{ $prize->chance }}</td>
                        <td>
                            <a href="{{route('admin.fortune_wheel.prizes.edit',$prize->id)}}">Edit</a>
                            <form action="{{route("admin.fortune_wheel.prizes.delete", $prize->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
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

                    var currentAmountElement = $(this).closest('tr').find('.amount');
                    var currentAmount = parseInt(currentAmountElement.text());
                    var step = $(this).closest('tr').find('.step').val();
                    var newAmount = currentIndex + step;


                    var id = $(this).val();
                    var amount_value =newAmount;
                    var url = "{{route('admin.pets.rarities.update', '') }}/" + id
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            'amount': amount_value,
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

                    var currentAmountElement = $(this).closest('tr').find('.amount');
                    var currentAmount = parseInt(currentAmountElement.text());
                    var step = $(this).closest('tr').find('.step').val();
                    var newAmount = currentIndex - step;

                    var id = $(this).val();
                    var amount_value =newIndex;
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
