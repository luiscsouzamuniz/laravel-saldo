@extends('adminlte::page')

@section('content_header')
    <h1>Recarga</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    	<li><a href="">Depositar</a></li>
    </ol>
@stop

@section('content')
   <div class="box">
        <div class="box-header">
            <h3>Recarga</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
           <form method="post" action="{{route('deposit.store')}}">

                {!! csrf_field() !!}
               <div class="form-group">
                   <label>Valor da Recarga:</label>
                   <input type="number" step="0.01" min="0" name="value" class="form-control">
               </div>
               <div class="form-group">

                    <button type="submit" class="btn btn-success">Recarregar</button>
               </div>
           </form>
        </div>
    </div>
@stop