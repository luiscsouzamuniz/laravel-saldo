@extends('adminlte::page')

@section('content_header')
    <h1>Transferência</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    	<li><a href="">Transferência</a></li>
    </ol>
@stop

@section('content')

   <div class="box">
        <div class="box-header">
            <h3>Transferência</h3>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
           <form method="post" action="{{route('transfer.confirm')}}">

                {!! csrf_field() !!}
               <div class="form-group">
                   <label>Destinatário:</label>
                   <input type="text" name="sender" class="form-control" placeholder="Nome ou email">
               </div>
               <div class="form-group">

                    <button type="submit" class="btn btn-primary">Próxima etapa</button>
               </div>
           </form>
        </div>
    </div>
@stop