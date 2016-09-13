@extends('app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" id="app">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Gerenciamento de Moradores </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Relação</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="list"><a href="{{url('morador/novo')}}">NOVO <i class="fa fa-plus"></i></a>
                </li>
              </ul>
              <div class="clearfix">
              </div>
            </div>
            <div class="x_content">
              <div class="row">
                <form>
                  <div class="col-md-10 col-sm-8 col-xs-6 form-group has-feedback">
                    <input value="{{ isset($_GET['busca']) ? $_GET['busca'] : "" }}" type="text" class="form-control" name="busca" id="busca" placeholder="Buscar">
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-2 col-sm-4 col-xs-6 form-group has-feedback">
                    <button type="submit" name="button" class="btn btn-block btn-default"><i class="fa fa-search"></i> Filtrar</button>
                  </div>
                </form>
              </div>

              <div class="row">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>Telefone</th>
                      <th style="text-align:center;">Quantidade Dependentes</th>
                      <th style="text-align:center"> status </th>
                      <th style="text-align:center"> Opções </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($moradores as  $morador)
                      <tr>
                        <td scope="row">{{$morador->id}}</td>
                        <td>{{$morador->nome}}</td>
                        <td>{{$morador->cpf}}</td>
                        <td>{{$morador->contatos->telefone }}</td>
                        <td style="text-align:center">
                          <a href="{{url('morador/'.$morador->id.'/dependentes')}}" data-toggle="tooltip" data-placement="top" title="Ver dependentes">
                            {{$morador->total_dependentes}}
                          </a>
                        </td>
                        <td style="text-align:center">
                          @if(!$morador->usuario->desativado_em)
                            <a href="{{url('morador/'.$morador->id.'/alterarStatus')}}" class="btn btn-default btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ativo">
                              <i class="fa fa-thumbs-o-up"></i>
                            </a>
                          @else
                            <a href="{{url('morador/'.$morador->id.'/alterarStatus')}}" class="btn btn-default btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Desativado">
                              <i class="fa fa-thumbs-o-down"></i>
                            </a>
                          @endif
                        </td>
                        <td style="text-align:center">
                          <a @click="loadContratos('{{$morador->id}}')" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-xs"> <i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="Contrato"></i></a>

                          <a href="{{url('morador/'.$morador->id.'/editar')}}" class="btn btn-default btn-xs"> <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Alterar"></i></a>

                          <a @click.prevent="excluir('{{$morador->id}}')" href="#" class="btn btn-default btn-xs delete_row" data-toggle="confirmation" data-placement="bottom" data-original-title="" title="">
                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Excluir"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <span class="pull-right"> {{ $moradores->links() }} </span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Contrato do Morador</h4>
        </div>
        <div class="modal-body">

          <form class="form-inline">
            <div class="form-group">
              <input type="file" name="name"  class="form-control" value="" >
            </div>
            <button type="submit" class="btn btn-default pull-right">Adicionar Contrato</button>
          </form>

          <hr>
          <div class="well well-md" >
            <a href="#" class="btn  btn-default pull-right"><i class="fa fa-times"></i></a>
            <h4>Click para baixar</h4>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
@endsection


@push('script_level')
  <script type="text/javascript">
  var vm = new Vue({
    el: '#app',

    data: {


    },

    ready:function(){

    },

    methods:{
      loadContratos:function(morador_id){

      },
      excluir:function(morador_id){
        swal({
          title: "Tem certeza?",
          text: "Isso ira deletar permanentemente este morador e todos registros relacionados a ele.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/morador/"+morador_id+"/excluir";
        });
      },
      excluirContrato:function(morador_id){
        swal({
          title: "Tem certeza?",
          text: "Isso ira excluir permanentemente este contrato",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Sim, pode excluir!",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },function(){
          window.location.href =  "/morador/"+morador_id+"/excluir";
        });
      }
    }

  });
  </script>
@endpush
