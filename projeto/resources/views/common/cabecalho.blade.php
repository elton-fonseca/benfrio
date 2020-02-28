
      <div class="navbar navbar-inverse" id="menu-cima" role="navigation">
        <div class="container-fluid">

          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Navergação</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="{{ URL::asset('assets/images/logo.jpg') }}" height="30" /></a>

          </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav">
                  <li class=""><a href="{{ URL::to('estoque') }}">Estoque</a></li>
                  <li class=""><a href="{{ URL::to('saida')  }}">Pedido de saída</a></li>
                  <li class=""><a href="{{ URL::to('nfe')     }}">NF-e</a></li>
                  @if (\Session::get('cod_cliente') == "8000")
                    <li class=""><a href="{{ URL::to('posicaovazia') }}">Posição vazia</a></li>
                  @endif
                  <li class=""><a id="vermelho" href="{{ URL::to('login/logoff') }}">Sair</a></li>

                </ul>
                
              </div><!-- /.navbar-collapse -->

              
        </div><!-- /.container-fluid -->

      </div>
