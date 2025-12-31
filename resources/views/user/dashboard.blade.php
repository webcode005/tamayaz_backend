@extends('layouts.app')


@section('title', 'Category Management')
@section('header', 'Dashboard')


@section('content')

<h1>User Dashboard</h1>
<p>Welcome {{ auth()->user()->name }}</p>

@endsection