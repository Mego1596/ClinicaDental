<!DOCTYPE html>
<html lang="es">

  <head>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('img/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('img/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon">          
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@include('layouts.nombreEmpresa') | Inicio</title>


    <link href="{{asset('index/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="{{asset('index/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{asset('css/estilo.css')}}" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"> <img src="{{asset('img/favicon.ico')}}" alt=""> @include('layouts.nombreEmpresa')    <img src="{{asset('img/diente.png')}}" alt=""> </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#acerca">¿Quienes somos?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#servicios">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#ubicacion">Ubicacion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contacto">Contactos</a>
            </li>
            <li class="nav-item">
              @auth
                <a class="nav-link btn btn-outline-success" href="{{ url('/home') }}">Sesión activa</a>
              @else
                <a class="nav-link btn btn-outline-success" href="{{ route('login') }}">Iniciar sesión</a>
              @endauth
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-black d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>@include('layouts.nombreEmpresa')</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class=" mb-5 text-black">Clinica Dental de Atencion Integral y Preventiva @include('layouts.nombreEmpresa')</p>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="#acerca">Ver más</a>
          </div>
        </div>

      </div>
    </header>

    <section class="bg-primary" id="acerca">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Quienes somos</h2>
            <hr class="light my-4">
            <div class="text-faded mb-4" style=" text-align: justify;text-justify: inter-word;">
              Somos un equipo profesional y capacitado para el cuido de tu salud bucal, enfocados en la prevenciòn, tratamiento y rehabilitaciòn oral.
              Prestándote servicios oontológicos desde el año 2009, capacitándonos continuamente en el área estética y cosmética dental y en 2018 en cirugía oral.
            </div>
            <a class="btn btn-light btn-xl js-scroll-trigger" href="#servicios">Servicios</a>
          </div>
        </div>
      </div>
    </section>

    <section id="servicios">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Contamos con los siguientes servicios</h2>
            <hr class="my-4">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-tooth text-primary mb-3 sr-icon-1"></i>
              <h3 class="mb-3">Atención dental</h3>
              <div class="text-muted mb-0" style=" text-align: justify;text-justify: inter-word;">Atención dental especializada con diferentes servicios y planes de tratamiento a disposición de nuestros clientes.</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-users text-primary mb-3 sr-icon-2"></i>
              <h3 class="mb-3">Atención especializada</h3>
              <div class="text-muted mb-0" style=" text-align: justify;text-justify: inter-word;"> 
                Contamos con el equipo adecuado para brindarte un mejor servicio, lleno de calidad y adecuado a lo que se amerite.
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-clock text-primary mb-3 sr-icon-3"></i>
              <h3 class="mb-3">Horarios de Atención</h3>
              <div class="text-muted mb-0" style=" text-align: justify;text-justify: inter-word;">Lunes - Viernes y Domingo  de 8:00 am a 6:00 pm. <br/>Sábado  de 8:00 am a 3:00 pm.</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-briefcase-medical text-primary mb-3 sr-icon-4"></i>
              <h3 class="mb-3">Tratamientos</h3>
              <div class="text-muted mb-0" style=" text-align: justify;text-justify: inter-word;">
                Contamos con mas de 25 diferentes tipos de servicios, que pueden ser indicados en un plan de tratamiento accesible para nuestros clientes.  
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="p-0" id="">
      <div class="container-fluid p-0">
        <div class="row no-gutters popup-gallery">
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/1.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/1.jpg')}}" width="" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Equipo adecuado
                  </div>
                  <div class="project-name">
                    Equipo adecuado en nuestras instalaciones a disposición para servirte.
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/2.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/2.jpg')}}"  alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Participación
                  </div>
                  <div class="project-name">
                    Hablemos sobre salud dental
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/3.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/3.jpg')}}" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Estamos para brindarte el mejor servicio
                  </div>
                  <div class="project-name">
                    Te brindamos el mejor servicio
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/4.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/4.jpg')}}" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Salud dental
                  </div>
                  <div class="project-name">
                    Ir al dentista tambien puede ser divertido.
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/5.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/5.jpg')}}"  alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Progresión
                  </div>
                  <div class="project-name">
                    Antes y despues de nuestros tratamientos.
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="{{asset('img/expandidas/6.jpg')}}">
              <img class="img-fluid" src="{{asset('img/despliegue/6.jpg')}}" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
               
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section id="ubicacion">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading">Nuestra ubicación</h2>
              <hr class="my-4">
            </div>
          </div>
        </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.950682227629!2d-89.21119018516987!3d13.721435690367104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1f037d1e2156c4a!2sClinica+Dental+de+Atencion+Integral+y+Preventiva+YEKIXPAKI!5e0!3m2!1ses!2ses!4v1537645205608" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    

    <section id="contacto">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Necesitas mas información</h2>
            <hr class="my-4">
            <p class="mb-5">No dudes en contactarnos por medio de nuestros numeros telefonicos y redes sociales</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <i class="fas fa-phone fa-3x mb-3 sr-contact-1"></i>
            <p class="text-muted mb-0">2102-2198</p>
            <p class="text-muted mb-0">6420-8735</p>
          </div>
       
              <div class="col-lg-4 ml-auto text-center">
                  <i class="fab fa-facebook fa-3x mb-3 sr-contact-2"></i>
                  <p>
                    <a href="https://www.facebook.com/dra.amayagomez/">Facebook </a>
                  </p>
                </div>
        
          <div class="col-lg-4 ml-auto text-center">
            <i class="fas fa-envelope fa-3x mb-3 sr-contact-3"></i>
            <p>
              <a href="mailto:your-email@your-domain.com">clinicayekixpaki@gmail.com </a>
            </p>
          </div>
        </div>
      </div>
    </section>


 
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="{{asset('index/scrollreveal/scrollreveal.min.js')}}"></script>
    <script src="{{asset('index/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <script src="{{asset('js/index.js')}}"></script>
  </body>
</html>



