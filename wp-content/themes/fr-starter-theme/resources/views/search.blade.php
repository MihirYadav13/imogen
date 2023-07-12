@extends('layouts.app')

@section('content')
    <div class="search-main-container fr-page-builder-container">
        <div class="section-bg-light-gray fr-content-row vert-stack-middle">
            <div class="container">
                <div class="module strategy-cards">
                    <div class="module-heading">
                        <h2>Cards</h2>
                    </div>
                    <x-card-grid posts-per-page="5" />
                </div>
            </div>
        </div>
    </div>
@endsection
