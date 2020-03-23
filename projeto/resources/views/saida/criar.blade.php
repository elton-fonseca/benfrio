
@extends('common.base')

@section('body')
    <div class="container">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li class="m-l-sm">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    
      <div class="caixa-login">
        

            {{ Form::open(array(
                'url' => 'saida/criarpost',
                'method' => 'POST',
                'accept-charset' => 'UTF-8',
                'class' => 'form-signin login_form'
                )) }}
                
              <h2>Criar Pedido de saida</h2>
                   <div class="form-group"> 
                    <p>O preenchimento dos campos não é obrigatório. Ao clicar em Criar Pedido será direcionado para a página de adição de itens</p>
                    <label for="placa">Placa Caminhão:</label> Letras e números
                    <input type="text" name="placa" class="input-block-level" placeholder="Placa" id="placa" onkeyup="alteraMaiusculo()" onKeyPress="return !(event.keyCode==13);" value="{{ old('placa') }}" />
                   
                   </div>
                   <div class="form-group">
                    <label for="datas">Data retirada:</label> Formato dd/mm/aaaa
                    <input type="text" name="datas" class="input-block-level" placeholder="Revisão retirada" onKeyPress="return !(event.keyCode==13);" value="{{ (old('datas')) ? old('datas') : date('d/m/Y') }}" />
                   </div>                   
                   <div class="form-group">
                    <label for="chegada">Hora retirada:</label> Formato hh:mm
                    <input type="text" name="chegada" class="input-block-level" placeholder="Revisão retirada" onKeyPress="return !(event.keyCode==13);" value="{{ old('chegada') }}" />
                   </div>                      
                   <div class="form-group">
                    <label for="obs">Observação ou Nome Motorista:</label>
                    <textarea class="form-control" name='obs' rows="3">{{ old('obs') }}</textarea>

                   </div>  

                    <input type="submit" value="Escolher Pallets" class="btn btn-large btn-primary" />

            {{ Form::close() }}

      </div>
    </div>
@stop

