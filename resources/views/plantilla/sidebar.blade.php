<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active"><i class="icon-speedometer"></i> ESCRITORIO</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> MANTENIMIENTOS</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i>General</a>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-tint"></i>Lubricantes</a>
                    </li>
                    <li @click="menu=10" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-car-battery"></i>Baterias</a>
                    </li>
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-dot-circle"></i>Llantas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> CATÁLOGOS</a>
                <ul class="nav-dropdown-items">
                    <!--li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Supervisores</a>
                    </li-->
                    <!--li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> U. de Medida</a>
                    </li-->
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Talleres</a>
                    </li>
                    <!--li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Items</a>
                    </li-->
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Tipos Manto.</a>
                    </li>

                    <li @click="menu=18" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios Taller.</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> REPORTES</a>
                <ul class="nav-dropdown-items">
                    <!--li @click="menu=16" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Vehiculos</a>
                    </li-->
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Mantenimientos</a>
                    </li>
                </ul>
            </li>
            <!--li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> EMPRESAS</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Catálogo</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Asignación</a>
                    </li>
                </ul>
            </li-->
            <!--li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> BATERÍAS</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Catálogo</a>
                    </li>
                    <li @click="menu=10" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Asignación</a>
                    </li>
                </ul>
            </li-->
            <!--li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> MANTENIMIENTO</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Asignación</a>
                    </li>
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Reportes</a>
                    </li>
                </ul>
            </li-->
            <li class="nav-title">
                Configuración
            </li>
            <!--li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> ACCESO</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                    </li>
                    <li @click="menu=14" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-user-following"></i> ROLES</a>
                    </li>
                </ul>
            </li-->
            <li @click="menu=15" class="nav-item">
                <a class="nav-link"><i class="icon-book-open"></i> CONFIGURACIÓN H<span class="badge badge-danger">PDF</span></a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
