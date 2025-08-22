<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Visitas')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        
        /* Estilos personalizados adicionales */
        .main-sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%) !important;
        }
        
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
            color: #ecf0f1 !important;
        }
        
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
            color: white !important;
        }
        
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
            color: white !important;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        
        .sidebar .nav-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #ecf0f1 50%, transparent 100%);
            margin: 15px 20px;
            opacity: 0.3;
        }
        
        .sidebar .nav-section-title {
            color: #bdc3c7;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 20px 8px 20px;
            margin: 0;
        }
        

        
        .sidebar .user-info {
            background: rgba(255,255,255,0.1);
            margin: 20px 12px;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar .user-info .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: white;
            font-size: 1.2rem;
        }
        
        .sidebar .user-info .user-name {
            color: #ecf0f1;
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            margin: 0;
        }
        
        .sidebar .user-info .user-role {
            color: #bdc3c7;
            font-size: 0.75rem;
            text-align: center;
            margin: 0;
        }
        
        .main-content {
            min-height: calc(100vh - 56px);
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        /* Estilos para las tarjetas del dashboard */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        .text-gray-300 {
            color: #dddfeb !important;
        }
        
        .text-gray-800 {
            color: #5a5c69 !important;
        }
        
        .text-xs {
            font-size: 0.7rem;
        }
        
        .font-weight-bold {
            font-weight: 700 !important;
        }
        
        .text-uppercase {
            text-transform: uppercase !important;
        }
        
        /* Animación de entrada para elementos del sidebar */
        .sidebar .nav-item {
            opacity: 0;
            animation: slideInLeft 0.5s ease forwards;
        }
        
        .sidebar .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .sidebar .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .sidebar .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .sidebar .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .sidebar .nav-item:nth-child(5) { animation-delay: 0.5s; }
        .sidebar .nav-item:nth-child(6) { animation-delay: 0.6s; }
        .sidebar .nav-item:nth-child(7) { animation-delay: 0.7s; }
        .sidebar .nav-item:nth-child(8) { animation-delay: 0.8s; }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        

    </style>
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            @auth
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin() || auth()->user()->isVisitor())
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            @endif
            @endauth
            
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-1"></i>
                    {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    @auth
    @if(auth()->user()->isSuperAdmin())
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i style="opacity: .8"></i>
            <span class="brand-text font-weight-light">📑Sistema de Visitas</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Inicio -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    
                    <!-- Gestión de Visitas -->
                    <li class="nav-header">GESTIÓN DE VISITAS</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.pending') }}" class="nav-link {{ request()->routeIs('admin.visits.pending') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>Solicitudes</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.all') }}" class="nav-link {{ request()->routeIs('admin.visits.all') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Todas las Visitas</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.calendar') }}" class="nav-link {{ request()->routeIs('admin.visits.calendar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Calendario</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.reports') }}" class="nav-link {{ request()->routeIs('admin.visits.reports') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chats</p>
                            @php
                                $unreadChats = \App\Models\ChatRoom::where('status', 'open')->count();
                            @endphp
                            @if($unreadChats > 0)
                                <span class="badge badge-danger right">{{ $unreadChats }}</span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Administración -->
                    <li class="nav-header">ADMINISTRACIÓN</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Gestión de Usuarios</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Roles y Permisos</p>
                        </a>
                    </li>
                    


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @elseif(auth()->user()->isAdmin())
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i style="opacity: .8"></i>
            <span class="brand-text font-weight-light">Sistema de Visitas</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Inicio -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    
                    <!-- Gestión de Visitas -->
                    <li class="nav-header">GESTIÓN DE VISITAS</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.approved') }}" class="nav-link {{ request()->routeIs('admin.visits.approved') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Visitas Aprobadas</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.calendar') }}" class="nav-link {{ request()->routeIs('admin.visits.calendar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Calendario</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.visits.reports') }}" class="nav-link {{ request()->routeIs('admin.visits.reports') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chats</p>
                            @php
                                $unreadChats = \App\Models\ChatRoom::where('status', 'open')->count();
                            @endphp
                            @if($unreadChats > 0)
                                <span class="badge badge-danger right">{{ $unreadChats }}</span>
                            @endif
                        </a>
                    </li>
                    


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @elseif(auth()->user()->isVisitor())
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i style="opacity: .8"></i>
            <span class="brand-text font-weight-light">📑Sistema de Visitas</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Inicio -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    
                    <!-- Mis Visitas -->
                    <li class="nav-header">MIS VISITAS</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('visits.request') }}" class="nav-link {{ request()->routeIs('visits.request') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Nueva Solicitud</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('visits.my-requests') }}" class="nav-link {{ request()->routeIs('visits.my-requests') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Mis Solicitudes</p>
                        </a>
                    </li>
                    
                    <!-- Comunicación -->
                    <li class="nav-header">COMUNICACIÓN</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chats</p>
                            @php
                                $unreadChats = \App\Models\ChatRoom::where('status', 'open')->count();
                            @endphp
                            @if($unreadChats > 0)
                                <span class="badge badge-danger right">{{ $unreadChats }}</span>
                            @endif
                        </a>
                    </li>
                    

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @endif
    @endauth
            
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

@stack('scripts')
</body>
</html>
