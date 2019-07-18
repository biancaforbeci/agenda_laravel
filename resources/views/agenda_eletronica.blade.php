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
    <h3 style="text-align:center;"><b>Agenda Eletrônica</b></h3>
    <br>
    <div>
        <button class="btn btn-sm btn-primary" role="button" onclick="newContact()">Novo Contato </button>
    </div>
    <table class="table table-ordered table-hover" id="tableContacts">
      <thead>
      <tr>
        <th>Nome</th>
        <th>Sobrenome</td>
        <th>Email</th>
        <th>Telefone</th>
        <th>Mensagens do Contato</th>
        <th>Edição</th>
        <th>Exclusão</th>
      </tr>
      </thead>

      <tbody>

      </tbody>

    </table>
  </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="dlgContatos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formContact">
                <div class="modal-header">
                    <h5 class="modal-title">Contato</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">
                    <div class="form-group">
                        <label for="name" class="control-label">Nome</label>
                        <div class="input-group">
                            <input type="text" class="form-control meucampo" id="name" placeholder="Nome do Contato" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="control-label">Sobrenome</label>
                        <div class="input-group">
                            <input type="text" class="form-control meucampo" id="lastname" placeholder="Sobrenome do Contato" required>
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
                            <input type="phone" class="form-control" id="phone" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" placeholder="Ex: (41) 3347-5013" required>
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
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/maskNameLastname.js') }}"></script>

<script type="text/javascript">
$.ajaxSetup({ //AJAX com o token CSRF para o formulário
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
});
    function newContact() {
      $('#id').val('');                //função para zerar todos os campos preenchidos e mostrar o modal com o formulário
      $('#name').val('');
      $('#lastname').val('');
      $('#email').val('');
      $('#phone').val('');
      $('#dlgContatos').modal('show');  //mostra formulário
    }

    function tableRows(p){
      var linha = "<tr>" +
        "<td style=display:none;>" + p.id + "</td>" +
        "<td>" +  "<b>" + p.name + "</b>" +"</td>" +
        "<td>" + p.lastname + "</td>" +
        "<td>" + p.email + "</td>" +
        "<td>" + p.phone + "</td>" +
        "<td>" + '<button class="btn btn-info"  onclick="show(' + p.id + ')">  Mensagens </button>' + "</td>" +
        "<td>" + '<button class="btn btn-sm btn-primary"  onclick="edit(' + p.id + ')"> Editar  </button>' +  "</td>" +        //montando cada linha da tabela e retornando
        "<td>" + '<button class="btn btn-sm btn-danger"  onclick="deleteContact(' + p.id + ')">  Apagar </button>' + "</td>"
        "</tr>"
        return linha;
    }
    function loadContacts(){
      $.getJSON('/api/contacts',function(contacts){  //list contatos
          for(i=0;i<contacts.length;i++){
              line = tableRows(contacts[i]);
              $('#tableContacts>tbody').append(line);
          }
      });
    }
    function createContact() {
        contact = {
            name: $("#name").val(),
            email: $("#email").val(),                  //salvar contato
            lastname: $("#lastname").val(),
            phone: $("#phone").val()
        };
        $.post("/api/contacts", contact, function(data) {
            alert("Salvo com sucesso");
            window.location.reload()
        });
    }
    function edit(id) {
        $.getJSON('/api/contacts/'+id, function(data) {
            console.log(data);
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#lastname').val(data.lastname);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#dlgContatos').modal('show');  //mostra formulário
        });
    }
    function deleteContact(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/contacts/" + id,
            context: this,
            success: function() {                         //delete contato
                console.log('Apagou OK');
                linhas = $("#tableContacts>tbody>tr");
                e = linhas.filter( function(i, elemento) {
                    return elemento.cells[0].textContent == id;
                });
                if (e)
                    e.remove();  //remove a linha
            },
            error: function(error) {
                console.log(error);  //se der erro entra aqui
            }
        });
    }
    function show(id){
       window.location.href = "/mensagens-contato/" + id ;
    }
    function saveContact() {
        contact = {
            id : $("#id").val(),
            name: $("#name").val(),
            lastname: $("#lastname").val(),              //update do contato
            email: $("#email").val(),
            phone: $("#phone").val()
        };
        $.ajax({
            type: "PUT",
            url: "/api/contacts/" + contact.id,
            context: this,
            data: contact,
            success: function(data) {
                alert("Salvo com sucesso");
                window.location.reload()
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    $("#formContact").submit( function(event){        //pega evento submit do formulário
        event.preventDefault();
        if ($("#id").val() != '')
            saveContact();           // se id do formulário for diferente de zero vai para editar
        else
            createContact();
        $("#dlgContatos").modal('hide');      //esconde o modal.
    });
    $(function(){
      loadContacts(); //chamando as funções
    })
</script>

<script type="text/javascript">       //validações
$("#phone").mask("(00) 0000-00009");
jQuery(function($){
  $("#lt").mask("aaaaaaaaaaaaa");
});

jQuery('.meucampo').keyup(function () {
    this.value = this.value.replace(/[^a-zA-Z.]/g,'');
});
</script>

@endsection
