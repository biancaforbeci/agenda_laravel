<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <link href="{{ asset('css/add_message.css') }}" rel="stylesheet">
</head>
<body align="center">
    <div class="container">
       <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3" >
                <div class="panel panel-primary">
                    <div class="panel-heading">Nova Mensagem</div>
                    <div class="panel-body">
                        <div class="form-group">


              <form class="form-horizontal" id="formProduto">
                    <div class="form-group">
                        <h5 for="contacts" style="text-align:left;">Digite o nome do contato e selecione uma opção</h5>
                        <div class="input-group">
                          <div class="col-md-12 text-center">


                              <input type="text" class="typeahead form-control" style="margin:0px auto;width:300px;" id="show-contact" name="show_contact" value="" required>

                           </div>
                        </div>
                    </div>

                    <input type="hidden" id="contact_id" name="contact_id" value="" />


                  </br>
                  </br>
                  </br>


                        <h5 for="contacts" style="text-align:left;">Mensagem</h5>
                        <div class="col-md-12 text-center">
                            <textarea class="form-control" id="message" rows="7" required></textarea>
                        </div>


                <div class="modal-footer">
                  </br>
                  <button type="button" class="btn btn-info"  style="margin:50px left;width:100px;" onclick="show()"> Voltar </button>
                  <button type="submit" style="margin:50px left;width:100px;" class="btn btn-success">Salvar</button>
                </div>
            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script type="text/javascript">
      var url = "http://localhost:8000/api/loadContacts";
      $('#show-contact').typeahead({
            source:  function (query, process) {
            return $.get(url, { query: query }, function (data) {
                    return process(data);
                });
            },
            afterSelect: function (item) {
              $("#contact_id").val(item.id);
            }
        });
</script>

<script type="text/javascript">
$.ajaxSetup({ //AJAX com o token CSRF para o formulário
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
});

    function newMessage() {
        message = {
            contact_id: $("#contact_id").val(),
            description: $("#message").val()
        };
        $.post("/api/messages", message, function(data) {
            console.log("Salvo")
            alert("Salvo com sucesso");
        });
    }

    function show(){
       window.location.href = "/";
    }

    $("#formProduto").submit( function(event){
        event.preventDefault();
        if($("#contact_id").val() == null){
          alert("Selecione um contato !");
        }else{
          newMessage();
        }
    });
</script>

</body>
</html>
