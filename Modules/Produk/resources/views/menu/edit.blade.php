@extends('layouts.app')

@section('template_title')
    Edit Menu
@endsection


@section('content')
<div class="col-lg-8">
    <div class="card card-shadow p-4">
        <form action="{{route('menu.update', [$data->id])}}" method="post" class="form-horizontal" enctype="multipart/form-data">                        
            @method('PATCH')
            @csrf

            <div class="form-group">
                <label for="name" class="control-label">Nama Menu</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" value="{{$data->name}}" name="name">
                </div>
            </div>

            <div class="form-group">
                <label for="screen_name" class="control-label">Screen Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" value="{{$data->screen_name}}" id="screen_name" name="screen_name" >
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Type Menu</label>
                <div class="form-control-wrap">
                    <select name="type" id="type" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                        <option value="{{$data->type}}" selected>{{$data->type}}</option>
                        <hr>
                        <option value="Prabayar">Prabayar</option>
                        <option value="Pascabayar">Pascabayar</option>
                        <option value="Donasi">Donasi</option>
                        <option value="Travel">Travel</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Promo">Promo</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="form-control-wrap">
                    <select name="status" id="status" data-search="on" data-ui="md" class="form-select js-select2 select2-hidden-accessible">
                        <option value="1">ACTIVE</option>
                        <option value="0">INACTIVE</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="position" class="control-label">Position Menu</label>
                <div class="form-control-wrap">
                    <input type="number" class="form-control" value="{{$data->position}}" id="position" name="position"  required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="icon" class="control-label">Icon Menu</label>
                <div class="form-control-wrap">
                    <input type="file" class="form-control" id="icon" name="icon">
                </div>

                <img src="{{$data->icon}}" alt="" width="100px" class="mt-3" srcset="">
            </div>

            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Save Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

@endsection