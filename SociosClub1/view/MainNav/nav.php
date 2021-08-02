<?php
    if ($_SESSION["rol_id"]==1){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\NuevoSocio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Nuevo Socio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\ConsultarSocio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Consultar Socio</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }else{
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\NuevoSocio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Nuevo Socio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntUsuario\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mantenimiento Usuario</span>
                        </a>
                    </li>
                    <li class="blue-dirty">
                        <a href="..\ConsultarSocio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Consultar Socio</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
    }
?>
