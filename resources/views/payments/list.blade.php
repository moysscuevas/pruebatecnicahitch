@extends('layout')
@section('content')
    <div class="row p-4">
        <div class="col-md-9">
            <h4 class="text-uppercase">Listado de Pagos</h4>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('payments-create') }}" class="btn btn-primary">Crear Pago</a>
        </div>
        <br>
        <br>
        <hr>
        @if (session()->has('alert-success'))
            <div class="alert alert-success" role="alert">
                {!! session()->get('alert-success') !!}
            </div>
        @endif
        @if (session('alert-error'))
            <div class="alert alert-danger" role="alert">
                {!! session('alert-error') !!}
            </div>
        @endif
        <div class="col-md-12">
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">DESCRIPCION</th>
                        <th class="text-center">PRECIO</th>
                        <th class="text-center">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var baseurl ="{!! url('/') !!}/";

        $(document).ready(function(){
            cargar_listado_pagos();
        });

        function cargar_listado_pagos()
        {
            var table = $('#table').DataTable({
                "headers": {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                "processing": true,
                "serverSide": false,
                "stateSave": false,
                "order": [[ 0, "asc" ]],
                "ajax": {
                    "url": baseurl+"listado_pagos",
                },
                "pagingType": "simple_numbers",
                "lengthMenu": [
                    [10, 25, 50, 100, 500, -1],
                    [10, 25, 50, 100, 500, "Todos"]
                ],
                'iDisplayLength': -1,
                "responsive": false,
                "columns":[
                    {data: 'id',},
                    {data: 'description',},
                    {data: 'price',},
                    {data: 'action', name: 'action', orderable: false, searchable: false, class:"text-left"}
                ]
            })
        }
    </script>
@endsection
