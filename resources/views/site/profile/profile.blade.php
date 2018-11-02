@extends('adminlte::page')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>Meu Perfil</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
           <form action="{{ route('profile.update')}}" method="POST" enctype="multipart/form-data">
           		{!! csrf_field() !!}
           		<div class="form-group">
           			<label>Nome:</label>
           			<input type="text" name="name" class="form-control" value="{{auth()->user()->name}}">
           		</div>

           		<div class="form-group">
           			<label>Email:</label>
           			<input type="email" name="email" class="form-control" value="{{auth()->user()->email}}">
           		</div>

           		<div class="form-group">
           			<label>Senha:</label>
           			<input type="password" name="password" class="form-control" value="">
           		</div>
           		<div class="form-group">
           			@if(auth()->user()->image != null)
           				<img src="{{ url('storage/users/'.auth()->user()->image) }}" alt="{{auth()->user()->name}}" class="img-responsive" style="width: 300px">
           			@endif
           			<label>Imagem:</label>
           			<input type="file" name="image" class="form-control">
           		</div>
           		<button type="submit" class="btn btn-primary">Editar</button>
           </form>
        </div>
    </div>
@stop