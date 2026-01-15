<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Tournament 2025</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://source.unsplash.com/1600x800/?cricket,stadium') center center/cover no-repeat;
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .feature-icon {
            font-size: 3rem;
            color: #ffc107;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('') }}">
                <img src="{{ asset('images/du-logo.png') }}" 
                alt="DU Logo" 
                style="height: 40px; width: auto; margin-right: 10px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    
                    
                    @guest
                        

                         <li class="nav-item">
                            <a class="nav-link btn btn-warning px-3 ms-2" href="{{ url('player_list') }}" style="color:white">Player List</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-warning px-3 ms-2" 
                            href="#" 
                            id="playerListDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false" 
                            style="color:white">
                                Teams
                            </a>
                            <ul class="dropdown-menu shadow border-0" aria-labelledby="playerListDropdown">
                                <li><a class="dropdown-item" href="{{ url('team_detail/1') }}">Mohan Ekushey</a></li>
                                <li><a class="dropdown-item" href="{{ url('team_detail/2') }}">Uttal 69</a></li>
                                <li><a class="dropdown-item" href="{{ url('team_detail/3') }}">Durbar 71</a></li>
                                <li><a class="dropdown-item" href="{{ url('team_detail/4') }}">Jagroto July</a></li>
                                
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link btn btn-warning px-3 ms-2" href="{{ route('register') }}" style="color:white">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning px-3 ms-2" href="{{ route('login') }}" style="color:white">Login</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-success px-3 ms-2" href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="display-4 fw-bold">🏆 DUTCL 2026</h1>
            <p class="lead mb-4">Get ready to witness thrilling cricket action, where teams battle for glory!</p>
            
        </div>
    </section>

    <!-- Features Section -->
   <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 15px;">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000&auto=format&fit=crop" 
                                class="img-fluid w-100" 
                                alt="Cricket Bat Ball and Stumps"
                                style="max-height: 650px; object-fit: cover; object-position: bottom;">

                            <!-- <div class="position-absolute bottom-0 start-0 w-100 p-4 p-md-5" 
                                style="background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);">
                                <h2 class="text-warning fw-bold display-4 mb-2" style="letter-spacing: 2px;">
                                    DUTCL 2026
                                </h2>
                                <p class="text-white lead fw-semibold mb-0">
                                    The Ultimate Battle for Academic Cricket Glory
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    <!-- Footer -->
    <footer class="text-center">
        <div class="container" >
            <p class="mb-0">&copy; DCTCL 2026. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
