@extends('dashboard.layouts.app')


@php
$model_name = 'users';
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

                                        @if ($row->image && fileExists(public_path($row->image)))
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <img src="{{ asset($row->image) }}" style="height: 130px; height:130px" class="rounded-circle" alt="">
                                                </div>
                                            </div>
                                        @endif



                                        <form class="form"
                                            action="{{ route('dashboard.' . $model_name . '.update',$row->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('put')

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-list"></i>
                                                    {{ Str::singular($model_name) }} data </h4>


                                                 <div class="row">

                                                    <x-inputs.input_row_form label="Name" name="name" placeholder="input name"  value="{{ $row->name }}"  />
                                                    <x-inputs.input_row_form label="Email" type="email" name="email" placeholder="input email"  value="{{ $row->email }}"  />
                                                    <x-inputs.input_row_form label="Password" type="password" name="password" placeholder="input password"  />
                                                    <x-inputs.input_row_form label="password confirmation" type="password" name="password_confirmation" placeholder="input password confirmation"  />
                                                    <x-inputs.input_row_form label="image" type="file" name="image" placeholder="input image"  />


                                                 </div>

                                                {{-- ----------------------- --}}


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
