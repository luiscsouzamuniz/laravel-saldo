@extends('adminlte::page')

@section('content_header')
    <h1>Confirmar Transferência</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    	<li><a href="">Confirmar Transferência</a></li>
    </ol>
@stop

@section('content')

   <div class="box">
        <div class="box-header">
            <h3>Transferir para: <b>{{$sender->name}} <small>{{$sender->email}}</small></b></h3>
            <h3>Saldo: R$ {{number_format($balance->amount, 2, ',', '')}}</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
           <form method="post" action="{{route('transfer.store')}}">

                {!! csrf_field() !!}
               <div class="form-group">
                   <label>Valor da Transferência:</label>
                   <input type="hidden" name="sender_id" value="{{$sender->id}}">
                   <input type="number" step="0.01" min="0" name="value" class="form-control">
               </div>
               <div class="form-group">

                    <button type="submit" class="btn btn-success">Transferir</button>
                    <a href="{{ route('balance.transfer') }}" type="submit" class="btn btn-danger">Cancelar</a>
               </div>
           </form>
        </div>
    </div>
@stop