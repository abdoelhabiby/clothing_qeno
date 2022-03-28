@extends('dashboard.layouts.app')


@php
$model_name = 'products';
@endphp


@section('title')
    | dashboard | {{ $model_name }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-12 ">


                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">home</a>
                                </li>
                                <li class="breadcrumb-item active"> {{ $model_name }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">

                @include('dashboard.includes.alerts.success')
                @include('dashboard.includes.alerts.errors')

                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> {{ $model_name }}</h4>

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
                                    <div class="card-body card-dashboard">
                                        <a class="btn btn-info mb-2" href="{{ route('dashboard.' . $model_name . '.create') }}" style="color: wheat">
                                            <i class="la la-plus" style="font-size:15px"></i> <strong>Add</strong>
                                        </a>
                                        <table class="table display nowrap table-striped table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>name</th>
                                                    <th>sku</th>
                                                    <th> slug</th>
                                                    <th>quantity</th>
                                                    <th>price</th>
                                                    <th>is_active</th>
                                                    <th>vendor</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if ($rows->count() > 0)
                                                    @foreach ($rows as $index => $row)
                                                        <tr>
                                                            <td> {{ orderNumberOfRows($rows->perPage()) + $index + 1 }}
                                                            </td>
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ $row->sku }}</td>
                                                            <td>{{ $row->slug }}</td>
                                                            <td>{{ $row->quantity }}</td>
                                                            <td>{{ $row->price }}</td>
                                                            <td>{{ $row->is_active ? 'active' : 'deactive' }}</td>
                                                            <td>{{ $row->vendor ? $row->vendor->name : '' }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic example">

                                                                    <a href="{{ route('dashboard.' . $model_name . '.edit', $row->id) }}"
                                                                        class="">
                                                                        <i class="la la-edit"></i>
                                                                    </a>

                                                                    <a type="button" id="custom_button_delete"
                                                                        data-action="{{ route('dashboard.' . $model_name . '.destroy', $row->id) }}"
                                                                        data-name="{{ $row->name }}"
                                                                        class="">
                                                                        <i class="la la-trash"></i>
                                                                    </a>

                                                                </div>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif







                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="justify-content-center d-flex">
                        {{ $rows->links() }}
                 </div>
                </section>



            </div>
        </div>



    </div>


    @include('dashboard.includes.alerts.model_delete')

@endsection



@section('js')
    <script>
        $(function() {


            $("body").on("click", "#custom_button_delete", function() {
                var action = $(this).data("action"),
                    name = $(this).data("name");
                $("#custom_modal_delete form").attr("action", action);
                $("#custom_modal_delete .modal-body span").text(name);
                $("#custom_modal_delete").modal("show");

            });




        });
    </script>
@endsection
