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
                        <!--<div class="form-group">
                            <label for="people_xml">People</label>
                            <input type="file" class="form-control-file" id="people_xml" name="people_xml">
                        </div>
                        <div class="form-group">
                            <label for="shiporder_xml">Shiporder</label>
                            <input type="file" class="form-control-file" id="shiporder_xml" name="shiporder_xml">
                        </div>-->

                        <div class="form-group">
                            <label for="shiporder_xml">People</label>
                            <div class="dropbox">
                              <input type="file" name="people_xml" @change="checkFile($event)" accept="xml" class="input-file">
                                <p id="people_text" style="display: block;">
                                    Drop here your file(people_xml).
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shiporder_xml">Shiporder</label>
                            <div class="dropbox">
                              <input type="file" name="shiporder_xml" @change="checkFile($event)" accept="xml" class="input-file">
                                <p id="shiporder_text" style="display: block;">
                                    Drop here your file(shiporder_xml).
                                </p>
                            </div>
                        </div>

                        <button class="btn btn-primary">Process</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkFile(event)
    {
        filename = event.target.files[0].name;
        name = 'shiporder_text';
        if(event.target.name == 'people_xml')
            name = 'people_text';
        $('#' + name ).text(filename);
    }
</script>
@endsection