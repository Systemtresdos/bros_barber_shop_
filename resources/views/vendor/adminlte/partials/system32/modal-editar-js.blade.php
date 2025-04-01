<script type="text/javascript">
  function labelEditar(){
    let element = document.getElementById("crud_labelNombre");
    element.innerHTML = "Editar";
  }
  function editar_tabla(id) {
    //Asignar valor al input de id
    labelEditar();
    let tabla = document.getElementById("table_".concat(id));
    let datos = [];
    for (var td of tabla.children) {
      //Ver si no tiene datos:
      if (td.children.length == 0) {
        datos.push(td.innerHTML);
      }
    }
    let inputs = document.getElementsByClassName("crud_label");
    let i = 0;
    for (let input of inputs) {
      switch (input.tagName) {
        case "SELECT":
          let valor;
          for (let opcion of input.children) {
            if (opcion.tagName == "OPTION") {
              if (datos[i] == opcion.innerHTML) {
                input.value = opcion.value;
              }
            }
          }
          break;
        default:
          if (input.type == "checkbox") {
            if (datos[i] == "0") {
              input.checked = false;
            } else {
              input.checked = true;
            }
          } else {
            switch (input.type){
              /*case "date":
                var fecha = datos[i].split('/');
                input.value = "20" + fecha[2] + "-" + fecha[1] + "-" + fecha[0];
                console.log(datos[i]);
                break;*/
              default:
                input.value = datos[i];
            }
          }
      }
      i++;
    }
  }
</script>