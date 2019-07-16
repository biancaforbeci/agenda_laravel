@extends('layouts.component')

@section('title')
<title>Agenda</title>
@endsection

@section('css_assets')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">

            <form class="form-horizontal" id="formProduto">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Mensagem</h5>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="contacts" class="control-label">Selecione qual contato deseja enviar uma mensagem</label>
                        <div class="input-group">
                            <select class="form-control" id="contacts" >
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="id" class="form-control">
                    <div class="form-group">
                        <label for="message">Mensagem</label>
                        <div class="input-group">
                            <textarea class="form-control" id="message" rows="7"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>


</div>
@endsection

@section('js_assets')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

<script type="text/javascript">
$.ajaxSetup({ //AJAX com o token CSRF para o formulário
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
});
    function novaMensagem() {
      $('#id').val('');                //função para zerar todos os campos preenchidos e mostrar o modal com o formulário
      $('#contacts').val('');
      $('#message').val('');
      $('#dlgProdutos').modal('show');  //mostra formulário
    }
    function carregarCategorias(){
      $.getJSON('/api/loadContacts',function(data){          //função para mostrar todas as categorias cadastradas no select do formulário
        for(i=0;i<data.length;i++){
          option = '<option value= "' + data[i].id + '">' + data[i].name + '</option>';
          $('#contacts').append(option);  //seta categoria no select do formulário
        }
      });
    }

    function criarProduto() {
        message = {
            contact_id: $("#contacts").val(),
            description: $("#message").val()
        };
        $.post("/api/messages", message, function(data) {
            console.log("Salvo")
        });
    }

    $("#formProduto").submit( function(event){
        event.preventDefault();
        criarProduto();
        $("#dlgProdutos").modal('hide');      //esconde o modal.
    });
    $(function(){
      carregarCategorias();       //chamando as funções
    })
</script>
@endsection
