
<nav class="navbar fixed-top navbar-expand-lg nav-bg-color">
  <div class="container">
     <a class="navbar-brand" href="#"><img src="{{URL::asset('/images/agenda.png')}}" style="height: 70px;
  width: 70px; "alt=""></a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars" style="color: #0000FF;"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="navi-link" href="{{ route('new-contact')}}">Contatos</a>
      </li>
      <li class="nav-item">
        <a class="navi-link" href="{{ route('new-message')}}">Enviar Mensagem</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
