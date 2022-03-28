@extends('dashboard.layouts.app')


@php
$model_name = 'products';
@endphp

@section('title')
    | dashboard | {{ $model_name }} | create
@endsection





@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">home </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.' . $model_name . '.index') }}">
                                        {{ $model_name }} </a>
                                </li>
                                <li class="breadcrumb-item active"> add
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
                                    <h4 class="card-title" id="basic-layout-form"> add
                                        {{ Str::singular($model_name) }}
                                    </h4>
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


                                        <form class="form"
                                            action="{{ route('dashboard.' . $model_name . '.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-list"></i>
                                                    {{ Str::singular($model_name) }} data </h4>


                                                 <div class="row">

                                                    <x-inputs.input_row_form label="Name" name="name" placeholder="input name" rows_number="6" />
                                                     <x-inputs.input_row_form label="Slug" name="slug" placeholder="input slug"  />
                                                    <x-inputs.input_row_form label="Sku" name="sku" placeholder="input sku"  />
                                                    <x-inputs.input_row_form label="quantity" type="number" name="quantity" placeholder="input quantity"  />
                                                    <x-inputs.input_row_form label="price" type="number" name="price" placeholder="input price"  />
                                                    <x-inputs.input_row_form label="image" type="file" name="image" placeholder="input image"  />

                                                 </div>


                                                 <div class="row">
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="text-bold-600 font-medium-2">
                                                              Categories
                                                            </div>

                                                            <select class="select2 form-control " name="categories[]" multiple id="id_h5_multi" tabindex="-1" aria-hidden="true">

                                                                @if(isset($categories) && $categories->count() > 0)

                                                                   @foreach ($categories as $category)

                                                                       <option value="{{ $category->id }}" @if(old('categories') && is_array(old('categories')))

                                                                        {{ in_array($category->id,old('categories')) ? 'selected' : '' }}

                                                                        @endif>
                                                                        {{ $category->name }}
                                                                    </option>

                                                                   @endforeach

                                                                @endif

                                                              </select>
                                                              @error('categories')
                                                            <span class="text-danger">{{ $message }} </span>
                                                            @enderror
                                                              @error('categories.0')
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
                                                                    checked=""> active
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
