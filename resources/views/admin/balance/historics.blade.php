@extends('adminlte::page')

@section('content_header')
    <h1>Históricos</h1>

    <ol class="breadcrumb">
    	<li><a href="">Dashboard</a></li>
      <li><a href="">Históricos</a></li>
    	
    </ol>
@stop

@section('content')

   <div class="box">
        <div class="box-header">
            <form action="{{route('historic.search')}}" method="POST" class="form form-inline">
              <div class="form-group">
                {!! csrf_field() !!}
                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control" placeholder="">

                <select name="type" class="form-control">
                  <option value="">-- Selecione uma Opção --</option>

                  @foreach($types as $key => $type)
                    <option value="{{$key}}">{{$type}}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
            </form>
        </div>
        <div class="box-body">
            @include('admin.includes.alerts')
            
            <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>ID Usuário</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($historics as $historic)
                  <tr>
                    <td>{{ $historic->id }}</td>
                    <td>{{ number_format($historic->amount, 2, ',','') }}</td>
                    <td>{{$historic->type($historic->type)}}</td>
                    <td>{{$historic->date}}</td>
                    <td>
                      @if($historic->user_id_transaction)
                        {{$historic->userSender->name}}
                      @else
                        -
                      @endif
                    </td>
                  </tr>
                  @empty
                  @endforelse
                </tbody>
            </table>

            @if(isset($dataForm))
              {!! $historics->appends($dataForm)->links() !!}
            @else
              {!! $historics->links() !!}
            @endif
            
        </div>
    </div>
@stop