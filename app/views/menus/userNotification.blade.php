<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>{{ $username }} <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header bg-light-blue">
            <img src="{{ $img }}" class="img-circle" alt="User Image" />
            <p>
                {{ $fullname }}
                <small>{{ $added }}</small>
            </p>
        </li>
        <li class="user-footer">
            <div class="pull-left">
                <a href="/perfil" class="btn btn-default btn-flat">Perfil</a>
            </div>
            <div class="pull-right">
                <a href="/logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
            </div>
        </li>
    </ul>
</li>