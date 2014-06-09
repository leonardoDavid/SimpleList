<div class="user-panel">
    <div class="pull-left image">
        <img src="{{ $img }}" class="img-circle" alt="User Image" />
    </div>
    <div class="pull-left info">
        <p>Hola {{ $name }}!</p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>
<!--
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
        <span class="input-group-btn">
            <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>
-->
<ul class="sidebar-menu">
    {{ $menu }}
    <li>
        <a href="/perfil">
            <i class="fa fa-user"></i> <span>Perfil</span>
        </a>
    </li>
    <li>
        <a href="/logout">
            <i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span>
        </a>
    </li>
</ul>