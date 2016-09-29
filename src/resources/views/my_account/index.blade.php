@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_my_account') }}
@endsection

@section('main-content')

    <h1>Mon compte</h1>

    <a href="{{ route('logout') }}">Se déconnecter</a>
@endsection