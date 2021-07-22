<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                MANTENIMIENTOS
            </li>
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active"><i class="icon-speedometer"></i> MANTOS. GENERALES PENDIENTES</a>
            </li>
            <li @click="menu=1" class="nav-item">
                <a class="nav-link active"><i class="icon-drop"></i> MANTOS. LUBRICANTES PENDIENTES</a>
            </li>
            <li @click="menu=2" class="nav-item">
                <a class="nav-link active"><i class="icon-docs"></i> HISTORIAL DE MANTENIMIENTOS GENERALES</a>
            </li>
            <li @click="menu=3" class="nav-item">
                <a class="nav-link active"><i class="icon-docs"></i> HISTORIAL DE CAMBIOS DE LUBRICANTES </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" />
</div>
