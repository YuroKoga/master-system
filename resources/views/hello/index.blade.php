@extends('layouts.master-system')

@section('title', 'index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')

    <p>{{ $msg }}</p>
    @if (count($errors) > 0)
        <p>入力に問題があります。再入力してください。</p>
    @endif
    <form action="/master-system/public/hello" method="post">
        <table>
            @csrf
            {{-- エラーメッセージの表示　名前 --}}
            @error('name')
                <tr>
                    <th>ERROR</th>
                    <td>{{ $message }}</td>
                </tr>
            @enderror
            <tr>
                <th>name: </th>
                <td><input type="text" name="name" value="{{ old('name') }}"></td>
            </tr>
            {{-- エラーメッセージの表示　メール --}}
            @error('mail')
                <tr>
                    <th>ERROR</th>
                    <td>{{ $message }}</td>
                </tr>
            @enderror
            <tr>
                <th>mail: </th>
                <td><input type="text" name="mail" value="{{ old('mail') }}"></td>
            </tr>
            {{-- エラーメッセージの表示　age --}}
            @error('age')
                <tr>
                    <th>ERROR</th>
                    <td>{{ $message }}</td>
                </tr>
            @enderror
            <tr>
                <th>age: </th>
                <td><input type="text" name="age" value="{{ old('age') }}"></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" name="send"></td>
            </tr>
        </table>
    </form>
@endsection

{{-- @section
        4-1 ミドルウェアのコンテンツ
        <p>ここが本文のコンテンツです。</p>
        <p>これは、<middleware>google.com</middleware>へのリンクです。</p>
        <p>これは、<middleware>yahoo.co.jp</middleware>へのリンクです。</p>
    @endsection --}}
@section('footer')
    copyright 2020 koga.
@endsection
