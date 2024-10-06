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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rarities as $rarity)
                        <tr>
                            <td>{{ $rarity->id }}</td>
                            <td>{{ $rarity->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
@endsection