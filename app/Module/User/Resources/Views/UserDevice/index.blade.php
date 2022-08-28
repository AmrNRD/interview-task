@extends('backend.layout')

@push('styles')
    <link href="{{ asset('layout-dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('sub_header')
    @component('backend.components.sub-header')
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!--begin: Datatable -->
                    <table class="table table-striped table-inverse" id="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>fcm_token</th>
								<th>type</th>
								<th>user</th>
								
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userDevices as $userDevice)
                            <tr>
                                <td scope="row">{{$userDevice->id}}</td>
                                <td> {{ $userDevice->fcm_token}}</td>
								<td> {{ $userDevice->type}}</td>
								<td> {{ $userDevice->user?->name}}</td>
								
                                <td>   @include("{$alias}::UserDevice.buttons.actions",['id' => $userDevice->id,'name'=>$userDevice->name])</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!--begin::Page Vendors(used by this page) -->
    
    <script src="{{ asset("layout-dist/plugins/datatables/jquery.dataTables.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("layout-dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush
