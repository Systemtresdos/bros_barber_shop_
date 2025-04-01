<!-- Button trigger modal
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearModal">
    Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <h5 class="login-box-msg" id="input_eliminar_texto"></h5>
            <form action="{{url()->current().'/eliminar/?tabla='.$nombre}}" method="POST">
                @csrf
                <input type="hidden" name="id" id="input_eliminar"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function eliminar_tabla(id){
        //Asignar valor al input de id
        document.getElementById("input_eliminar").value = id;
        let tabla = document.getElementById("table_".concat(id));
        let nombre;
        let dato_id;
        let contador = 0;
        for (var td of tabla.children) {
            //Ver si no tiene datos:
            if(td.children.length==0){
                if(!contador){
                    dato_id = td.innerHTML;
                    contador++;
                }else{
                    nombre = td.innerHTML;
                    break;
                }
            }
        }
        let label = document.getElementById("input_eliminar_texto");
        label.innerHTML = "¿Estas seguro de que quieres eliminar el dato ".concat(nombre).concat('(').concat(dato_id).concat(") de la tabla {{ $nombre }}?");

    }
</script>
