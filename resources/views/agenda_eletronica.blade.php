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

  <div class="card border">
  <div class="card-body">
    <h5 class="card-title">Cadastro de Produtos</h5>

    <table class="table table-ordered table-hover" id="tabelaProdutos">
      <thead>
      <tr>
        <th>Nome</th>
        <th>Sobrenome</td>
        <th>Email</th>
        <th>Telefone</th>
        <th>Edição</th>
        <th>Exclusão</th>
      </tr>
      </thead>

      <tbody>

      </tbody>

    </table>
  </div>

  <div class="card-footer">
      <button class="btn btn-sm btn-primary" role="button" onclick="novoContato()">Novo Contato </button>
  </div>

</div>



<div class="modal" tabindex="-1" role="dialog" id="dlgContatos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formContact">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Contato</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">
                    <div class="form-group">
                        <label for="name" class="control-label">Nome</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" placeholder="Nome do Contato" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="control-label">Sobrenome</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="lastname" placeholder="Sobrenome do Contato" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" placeholder="Ex: nome@hotmail.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="control-label">Telefone</label>
                        <div class="input-group">
                            <input type="phone" class="form-control" id="phone" placeholder="Ex: 41-3347-5013" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
    function novoContato() {
      $('#id').val('');                //função para zerar todos os campos preenchidos e mostrar o modal com o formulário
      $('#name').val('');
      $('#lastname').val('');
      $('#email').val('');
      $('#phone').val('');
      $('#dlgContatos').modal('show');  //mostra formulário
    }

    function montarLinha(p){
      var linha = "<tr>" +
        "<td style=display:none;>" + p.id + "</td>" +
        "<td>" + p.name + "</td>" +
        "<td>" + p.lastname + "</td>" +
        "<td>" + p.email + "</td>" +
        "<td>" + p.phone + "</td>" +
        "<td>" + '<button class="btn btn-sm btn-primary"  onclick="editar(' + p.id + ')"> Editar  </button>' +  "</td>" +        //montando cada linha da tabela e retornando
        "<td>" + '<button class="btn btn-sm btn-danger"  onclick="apagar(' + p.id + ')">  Apagar </button>' + "</td>"
        "</tr>"
        return linha;
    }
    function loadContacts(){
      $.getJSON('/api/contacts',function(contacts){  //chamando a api e retornando json e recebendo na variável produtos
          for(i=0;i<contacts.length;i++){
              line = montarLinha(contacts[i]);
              $('#tabelaProdutos>tbody').append(line); //mostrando a linha na tabela
          }
      });
    }
    function criarProduto() {
        contact = {
            name: $("#name").val(),
            email: $("#email").val(),                  //pega os valores digitados do novo produto
            lastname: $("#lastname").val(),
            phone: $("#phone").val()
        };
        $.post("/api/contacts", contact, function(data) {    //envia esse novo produto (prod) para salvar
            contact = JSON.parse(data);  //transforma o JSON em produto
            linha = montarLinha(contact); //monta a linha com as informações do novo produto.
            $('#tabelaProdutos>tbody').append(linha); //coloca nova linha na tabela
        });
    }
    function editar(id) {
        $.getJSON('/api/contacts/'+id, function(data) {
            console.log(data);
            $('#id').val(data.id);                 //função retornando todos os dados do produto para editar e populando campos do formulário.
            $('#name').val(data.name);
            $('#lastname').val(data.lastname);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#dlgContatos').modal('show');  //mostra formulário
        });
    }
    function apagar(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/contacts/" + id,  //envia id para apagar produto referente
            context: this,
            success: function() {
                console.log('Apagou OK');
                linhas = $("#tabelaProdutos>tbody>tr");     //pega referência para a primeira coluna com os ids
                e = linhas.filter( function(i, elemento) {
                    return elemento.cells[0].textContent == id;  //encontra a linha que foi apagada passando o id dela.
                });
                if (e)
                    e.remove();  //remove a linha
            },
            error: function(error) {
                console.log(error);  //se der erro entra aqui
            }
        });
    }
    function salvarProduto() {
        contact = {
            id : $("#id").val(),
            nome: $("#name").val(),
            lastname: $("#lastname").val(),              //update do produto, pegando valores dos campos do formulário
            email: $("#email").val(),
            phone: $("#phone").val()
        };
        $.ajax({
            type: "PUT",
            url: "/api/contacts/" + contact.id,    //enviando id do produto para encontrar o produto.
            context: this,
            data: contact,
            success: function(data) {
                contact = JSON.parse(data);
                linhas = $("#tabelaProdutos>tbody>tr");
                e = linhas.filter( function(i, e) {
                    return ( e.cells[0].textContent == contact.id );
                });
                if (e) {
                    e[0].cells[0].textContent = contact.id;
                    e[0].cells[1].textContent = contact.name;
                    e[0].cells[2].textContent = contact.lastname;
                    e[0].cells[3].textContent = contact.email;
                    e[0].cells[4].textContent = contact.phone;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    $("#formContact").submit( function(event){        //pega evento submit do formulário
        event.preventDefault();
        if ($("#id").val() != '')
            salvarProduto();           // se id do formulário for diferente de zero vai para editar
        else
            criarProduto();           // se for id nulo vai para criar produto
        $("#dlgContatos").modal('hide');      //esconde o modal.
    });
    $(function(){
      loadContacts(); //chamando as funções
    })
</script>
@endsection
