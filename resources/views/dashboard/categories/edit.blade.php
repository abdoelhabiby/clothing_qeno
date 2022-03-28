@extends('dashboard.layouts.app')


@php
$model_name = 'categories';
@endphp

@section('title')
    | dashboard | {{ $model_name }} | edit
@endsection





@section('content')


    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.home') }}">home </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.'. $model_name . '.index') }}">
                                        {{ $model_name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">
                                    edit
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content-body">
                @include('dashboard.includes.alerts.success')
                @include('dashboard.includes.alerts.errors')
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> edit {{ $row->name }} </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">

                                        @if ($row->image && \File::exists(public_path($row->image)))
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <img src="{{ asset($row->image) }}"
                                                        style="min-height: 300px; max-height:500px" alt="">
                                                </div>
                                            </div>
                                        @endif


                                        <form class="form" action="{{ route('dashboard.'. $model_name . '.update', $row->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-list"></i>
                                                    {{ Str::singular($model_name) }} data
                                                </h4>




                                                <div class="row">



                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="name"> name
                                                            </label>
                                                            <input type="text" value="{{ old('name',$row->name) }}" id="name"
                                                                class="form-control" placeholder="input name" name="name">
                                                            @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    {{-- --------------slug --}}
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="slug"> slug
                                                            </label>
                                                            <input type="text" value="{{ old('slug',$row->slug) }}" id="slug"
                                                                class="form-control" placeholder="input slug" name="slug">
                                                            @error('slug')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    {{-- ---------------------------------- --}}

                                                    <div class="col-md-6">
                                                        @php
                                                            $input = 'image';
                                                        @endphp
                                                        <div class="form-group">
                                                            <label for="{{ $input }}"> {{ $input }} </label>
                                                            <input type="file" id="{{ $input }}"
                                                                class="form-control" name=" {{ $input }}">
                                                            @error($input)
                                                                <span class="text-danger">{{ $message }} </span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>






                                                {{-- ----------------------- --}}


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fom-group">


                                                            <label>
                                                                <input type="checkbox" name="is_active" value="true"
                                                                   @if($row->is_active == true) checked @endif > active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>






                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                        <i class="ft-x"></i> back
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> save
                                                    </button>
                                                </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
