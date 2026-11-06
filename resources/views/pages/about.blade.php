@extends('layouts.app')

@section('title', 'About | POS Workspace')

@section('content')
    <section class="page-heading">
        <h1>About the workspace</h1>
        <p class="lead">This Laravel application demonstrates a small point-of-sale administration interface.</p>
    </section>
    <h2>Built for the essentials</h2>
    <p>The landing page, customer directory, and user directory are connected through Laravel routes and reusable Blade views. Customer and user records are loaded from the database using Eloquent.</p>
@endsection
