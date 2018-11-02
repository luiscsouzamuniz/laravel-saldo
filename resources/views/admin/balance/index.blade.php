@extends('adminlte::page')

@section('content_header')
    <h1>Saldo</h1>

    <ol class="breadcrumb">
    	<li><a href="/admin">Dashboard</a></li>
    	<li><a href="#">Saldo</a></li>
    </ol>
@stop

@section('content')
    <div class="box">
    	<div class="box-header">
    		<a href="{{route('balance.deposit')}}" class="btn btn-primary"><span class="fa fa-plus"></span> Recarregar</a>

            @if($amount > 0)
              <a href="{{ route('balance.withdraw')}}" class="btn btn-danger"><span class="fa fa-minus"></span> Sacar</a>
    		  <a href="{{ route('balance.transfer')}}" class="btn btn-info"><span class="fa fa-exchange"></span> Transferir</a>

            @endif
    	</div>
    	<div class="box-body">
            @include('admin.includes.alerts')
    		<div class="small-box bg-green">
    			<div class="inner">
    				<h3>R$ {{number_format($amount, 2, ',', '.')}}</h3>
    			</div>
    			<div class="icon">
    				<i class="ion ion-cash"></i>
    			</div>
    			<a href="#" class="small-box-footer">Histórico</a>
    		</div>
    	</div>
    </div>
@stop