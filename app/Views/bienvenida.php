<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-<title>Pantalla de Bienvenida</title>->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


      <!-MI ESTILO CSS->
     <link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
    



    <div class="minav sticky-top ">
    <nav class="navbar navbar-expand-lg navbar-light sticky-top " style="background-color: #e3f2fd;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="assets/img/BLASS-1.jpg"  width="100" height="100" >
        </a>
        <button class="navbar-toggler bg-white " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation bg-white">
          <span class="navbar-toggler-icon bg-white"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
           
          <!-Inicio ->
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
          </li>

          <!- Quienes Somos ->
          <li class="nav-item">
            <a class="nav-link active" href="#">Somos</a>
          </li>
          <!-<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
            </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>->
        <!- Productos->
        <li class="nav-item">
          <a class="nav-link active" href="#">Productos</a>
        </li>

        <!- Contacto ->
        <li class="nav-item">
          <a class="nav-link active" href="#">Contacto</a>
        </li>
      </ul>

      <form class="d-flex" role="search">
        <!-<input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">->
        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Ingresar</button>
        <button class="btn btn-outline-success" type="submit">Registrate</button>
      </form>

          
    </div>
  </div>
</nav>
</div>-->
</head>

 



    
<body>


<br></br>
<!-- CARRUSEL-->
<!--<section class= "container shadow p-3 mb-5 bg-white rounded">-->
<section class="container col-lg-5 col-md-8 shadow p-3 mb-5 bg-white rounded">
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo base_url() ?>assets/img/termo1.jpg" class="d-block w-100 custom-carousel-img" alt="..."  >
          </div>
          <div class="carousel-item">
            <img src="<?php echo base_url() ?>assets/img/auriculares.jpg" class="d-block w-100 custom-carousel-img" alt="..." >
          </div>
        <div class="carousel-item">
          <img src="<?php echo base_url() ?>assets/img/funko-pop-spider-man.jpg" class="d-block w-100 custom-carousel-img" alt="..." >
        </div>
      </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>
    <br>
    </br>
    
    <!-- CARDS -->
    <section class="container mt-5  ">
            
        <div class="row justify-content-center">
            <div class ="col-lg-4 col-md-6 col-12 mt-3 d-flex justify-content-center ">
            <div class="card shadow-img text-center" style="width: 18rem;">
                    <div class="card-body ">
                        <h5 class="card-title">Regalería</h5>
                        <!--<h6 class="card-subtitle mb-2 text-muted">Subtitulo</h6>-->
                        <img src="assets/img/bazar-cajas.jpg" class="card-img-top custom-card-img" alt="...">
                    </div>
            </div>
            </div>

                <div class ="col-lg-4 col-md-6 col-12 mt-3 d-flex justify-content-center">
                <div class="card shadow-img text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Todo para el hogar</h5>
                        <!--<h6 class="card-subtitle mb-2 text-muted">Subtitulo</h6>-->
                        <img src="assets/img/bazar1.jpg" class="card-img-top custom-card-img" alt="...">
                    </div>
                </div>
                </div>

                <div class ="col-lg-4 col-md-6 col-12 mt-3 d-flex justify-content-center">
                <div class="card shadow-img text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Detalles especiales</h5>
                        <!--<h6 class="card-subtitle mb-2 text-muted">Subtitulo</h6>-->
                        <img src="assets/img/bazar2.jpg" class="card-img-top custom-card-img" alt="...">
                    </div>
                </div>
                </div>





            </div>
        </section>
   
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>



</body>

</html>