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

      <h3 style="text-align:center;"><b>Nova Mensagem</b></h3>
      <br>
      <br>

      <form class="form-horizontal" id="formProduto">
                    <div class="form-group">
                        <h5 for="contacts" style="text-align:left;">Digite o nome do contato e selecione uma opção</h5>
                        <div class="input-group">
                          <div class="col-md-12 text-center">
                              <input type="text" class="typeahead" id="show-contact" name="show_contact" value="" required>
                                  {{-- {{ $errors->first('contact_id', '<span class="help-inline">:message</span>') }} --}}
                           </div>
                        </div>
                    </div>

                    <input type="hidden" id="contact_id" name="contact_id" value="" />


                  </br>
                  </br>
                  </br>

                    <div class="form-group">
                        <h5 for="contacts" style="text-align:left;">Mensagem</h5>
                        <div class="input-group">
                            <textarea class="form-control" id="message" rows="7" required></textarea>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
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
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}" ></script>
<script src="{{ asset('js/bootstrap3-typeahead.min.js') }}" ></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}" ></script>

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
        });
    }

    $("#formProduto").submit( function(event){
        event.preventDefault();
        newMessage();
    });
</script>

<script>

var contacts = new Bloodhound({
datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nome'),
queryTokenizer: Bloodhound.tokenizers.whitespace,
prefetch: 'http://localhost:8000/api/loadContacts',
remote: {
url: 'http://localhost:8000/api/loadContacts?query=%query',
'wildcard': '%query'
}
});

$('#show-contact').typeahead(null, {
name: 'contacts',
display: 'name',
source: contacts
});


$('#show-contact').bind('typeahead:select', function(ev, suggestion) {
$("#contact_id").val(suggestion.id);
});

</script>


@endsection
