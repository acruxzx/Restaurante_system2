<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-warning shadow">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand text-warning" href="#">
            <i class="fas fa-store"></i> Delicia China
        </a>
        
          <!-- Botón del menú para dispositivos móviles -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menú principal -->
        <div class="collapse navbar-collapse" id="navbarContent">
            @auth
                @php
                    $rol = Auth::check() ? Auth::user()->id_rol : null;
                @endphp

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if ($rol == 1)
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('dashboard') }}">
                                <i class="fas fa-chart-line"></i> Estadísticas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('num-cajas.index') }}">
                                <i class="fas fa-cash-register"></i>Caja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('precios.index') }}">
                                <i class="fas fa-tags"></i> Gestión de Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('pedidos.index') }}">
                                <i class="fas fa-shopping-cart"></i> Gestión de Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('ventas.historial') }}">
                                <i class="fas fa-history"></i> Historial de Ventas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('trabajadores.index') }}" class="nav-link text-light">
                                <i class="fas fa-user-plus"></i>
                                <span>Trabajadores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('clientes.index') }}">
                                <i class="fas fa-user-friends"></i> Clientes
                            </a>
                        </li>
                    @elseif ($rol == 2) 
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('precios.index') }}">
                            <i class="fas fa-tags"></i> Gestión de Productos
                        </a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('pedidos.index') }}">
                                <i class="fas fa-shopping-cart"></i> Gestión de Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('clientes.index') }}">
                                <i class="fas fa-user-friends"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('ventas.historial') }}">
                                <i class="fas fa-history"></i> Historial de ventas
                            </a>
                        </li>
                        @elseif ($rol == 3) 
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('precios.index') }}">
                                <i class="fas fa-tags"></i> Gestión de Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('pedidos.index') }}">
                                <i class="fas fa-shopping-cart"></i> Gestión de Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('clientes.index') }}">
                                <i class="fas fa-user-friends"></i> Clientes
                            </a>
                        </li> 
                    @endif
                </ul>
                @endauth
                <!-- Menú desplegable del usuario -->
              
            <!-- User Dropdown -->
            <div x-data="{ open: false }" class="relative flex items-center text-white">
                <button @click="open = ! open" class="flex items-center focus:outline-none">
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
                <div x-show="open" @click.away="open = false" 
                     class="absolute sm:right-0 left-0 sm:mt-2 mt-4 bg-white shadow-lg rounded-lg w-full sm:w-48 z-50 border border-gray-200">
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-[#D4AF37] hover:text-white transition duration-300">
                       Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();" 
                           class="block px-4 py-2 text-gray-700 hover:bg-[#D4AF37] hover:text-white transition duration-300">
                           Cerrar Sesión
                        </a>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</nav>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
