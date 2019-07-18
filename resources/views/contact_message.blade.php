@extends('layouts.component')

@section('title')
<title>Mensagens do Contato</title>
@endsection

@section('css_assets')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')

  @php
    $jsonObjContact = json_decode($jsonContact);
    $jsonObjMessage = json_decode($json,true);
  @endphp

	<div class="container">
		<div class="profile-details">
			<div class="row">

        <div class="col">
          <br>
				<center>

        <img src="{{URL::asset('/images/contacts-icon.png')}}" style="height: 90px;
width: 90px;" alt="">
        </center>
			</div>
			<div class="col-lg-9">
        <hr>
				<div class="contact-details">

					<p id="name" class="contact-name-lastname"> {{$jsonObjContact->name}} {{$jsonObjContact->lastname}}</p>

					<div class="contact-message-email">
            <p id="email" class="contact-email"> {{$jsonObjContact->email}}  </p>

					</div>


					<div class="contact-message-phone">
            <p id="phone" class="contact-phone"> {{$jsonObjContact->phone}} </p>
					</div>

					<hr>

				</div>
			</div>

			</div>
		</div>
	</div>



	<!-- Certificates -->
	<div class="container">
		<div class="messages">
			<h3 class="messages-area-title">Mensagens </h3>
			<hr><br>

      @foreach ($jsonObjMessage as $message)
			<div class="row">
					<div class="col-lg-4">
						<div class="topic-messages">

              <div style="display: inline-block; text-align: left; width: 100%">
                <p id="date"> <b> Mensagem salva em  {{$message['created_at']}} </b></p>
              </div>

            </br>

              <p id="message"> {{$message['description']}} </p>


              <p>
                 <button class="button-message btn btn-sm btn-primary"  onclick="editMessage({{$message['id']}})"> Editar  </button>

                 <button class="button-message btn btn-sm btn-danger"  onclick="deleteMessage({{$message['id']}})"> Apagar </button>
               </p>

						</div>
					</div>
			</div>

      <hr>
      <br>
      <div>


      @endforeach
			<br>
			<br>
		</div>
	</div>


  <div class="modal" tabindex="-1" role="dialog" id="dlgMessages">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form class="form-horizontal" id="formMessage">
                  <div class="modal-header">
                      <h5 class="modal-title">Editar Mensagem</h5>
                  </div>
                  <div class="modal-body">
                    @csrf

                    <input type="hidden" value="" id="id">

                    <div class="form-group">
                        <label for="contacts" class="control-label">Contato</label>
                        <div class="input-group">
                            <select class="form-control" id="contacts" >
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Mensagem</label>
                        <div class="input-group">
                            <textarea class="form-control" id="message" rows="7"></textarea>
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

    function editMessage(id) {
          $.getJSON('/api/messages/'+id, function(data) {
              console.log(data);
              $('#id').val(data.id);
              $("textarea#message").val(data.description);
              loadContact(data.contact_id);
          });
    }

    function loadContact(id){
      $.getJSON('/api/contacts/'+id, function(data) {
          option = '<option value= "' + data.id + '">' + data.name + '</option>';
          $('#contacts').append(option);
      });
      $('#dlgMessages').modal('show');
    }

    function deleteMessage(id) {
          $.ajax({
              type: "DELETE",
              url: "/api/messages/" + id,
              context: this,
              success: function() {
                  console.log('Apagou OK');
                  window.location.reload()
              },
              error: function(error) {
                  console.log(error);  //se der erro entra aqui
              }
          });
      }

      function saveMessage() {
          message = {
              id : $("#id").val(),
              contact_id: $("#contacts").val(),
              description: $("textarea#message").val()
          };
          $.ajax({
              type: "PUT",
              url: "/api/messages/" + message.id,
              context: this,
              data: message,
              success: function(data) {
                  console.log("Sucesso.")
                  window.location.reload()
              },
              error: function(error) {
                  console.log(error);
              }
          });
      }
      $("#formMessage").submit( function(event){
          event.preventDefault();
          saveMessage();
          $("#dlgMessages").modal('hide');      //esconde o modal.
      });
  </script>


@endsection
