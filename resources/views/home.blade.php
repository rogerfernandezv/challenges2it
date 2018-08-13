@extends('layouts.app')

@section('content')
@if (session('messages'))
    <div class="alert alert-success">
        <ul>
            @foreach ( session('messages')  as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Process XML</div>

                <div class="card-body">

                    <form action="{{route('process.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="people_xml">People</label>
                            <input type="file" class="form-control-file" id="people_xml" name="people_xml">
                        </div>
                        <div class="form-group">
                            <label for="shiporder_xml">Shiporder</label>
                            <input type="file" class="form-control-file" id="shiporder_xml" name="shiporder_xml">
                        </div>

                        <button class="btn">Process</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection