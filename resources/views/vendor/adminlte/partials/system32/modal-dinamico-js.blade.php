<script type="text/javascript">
  Object.defineProperty(String.prototype, 'capitalize', {
    value: function() {
      return this.charAt(0).toUpperCase() + this.slice(1);
    },
    enumerable: false
  });
  
  const tableName = "{{$nombre}}"

  function crearTabla(json){
    for(var i in json){
      var row = json[i];
      //Buscar si ya existe una fila con la misma id
      if(crudTable.row('#crud-table-'.concat(row["id"])).node()==null){
        row["data"].push(
          '<div class="btn-group">'.concat(
          @if (Auth::user()->rol!="cliente")
              '<button type="button" class="btn btn-info" onclick = "editarModal(').concat(row["id"]).concat(`)" data-toggle="modal" data-target="#modal-crud">
                  <i class="fas fa-wrench"></i>
              </button>`).concat(
          @endif
          @if (Auth::user()->rol!="cliente")
              '<button type="button" class="btn btn-danger" onclick = "eliminar_tabla(').concat(row["id"]).concat(`)" data-toggle="modal" data-target="#eliminarModal">
                  <i class="fas fa-trash"></i>
              </button>`).concat(
          @endif
          '</div>')
        );
        var rowDT = crudTable.row.add(row["data"]).draw(false).node();
        $(rowDT).attr("id","crud-table-".concat(row["id"]));
        
        jfk = 0;
        for(let ifk = row["data"].length-row["fk"].length; ifk < row["data"].length;ifk++){
          $(rowDT.children[ifk-1]).attr("data-fk",123);
          //rowDT.children[ifk].dataset.fk = row["fk"][jfk];
          jfk++;
        }
      } 
    }
    //var row = crudTable.row('#crud-table-5').node();
  }
  function editarTabla(json){
    for(var i in json){
      var row = json[i];
      var rowDT = crudTable.row('#crud-table-'.concat(row["id"])).node();
      if(rowDT){
        let i = 0;
        for(var child of rowDT.children){
            if(i<row["data"].length){
              child.innerHTML=row["data"][i];i++;
            }
        }
      }else{
        agregarTabla([row]);
      }
    }
  }
  function eliminarTabla(ids){
    for(var id of ids){
      var rowDT = crudTable.row('#crud-table-'.concat(id)).node();
      if(rowDT){
        $(rowDT).remove();
      }
    }
  }
  /*crearTabla([
      { 'id': 100,    
        'data':[
          1,
          2,
          3, 
          "Hola mundo",
        ],
        'fk':[
          1,
        ]
    }
  ]);*/
  //eliminarTabla([1,2,3,4]);
  let  modalType = "crear";
  function labelUpdate() {
    document.getElementById("modal-crud-name").innerHTML = modalType.capitalize();
    document.getElementById("modal-crud-button").innerHTML = modalType.capitalize();
    document.getElementById("modal-crud-form").action = "{{url()->current()}}".concat("/").concat(modalType).concat("?tabla=").concat(tableName);
  }
  labelUpdate();
  function crearModal() {
    if (modalType != "crear") {
      modalType = "crear";
      labelUpdate();
      let inputs = document.getElementsByClassName("label-crud");
      let i = 0;
      for (let input of inputs) {
        switch (input.tagName) {
          case "SELECT":
            let valor;
            for (let opcion of input.children) {
              if (opcion.tagName == "OPTION") {
                input.value = opcion.value;
                break;
              }
            }
            break;
          default:
            if (input.type == "checkbox") {
              input.checked = false;
            } else {
              input.value = "";
            }
        }
        i++;
      }
    }
  }
  function editarModal(id) {
    //Asignar valor al input de id
    if (modalType != "editar") {
      modalType = "editar";
      labelUpdate();
    }

    let tabla = document.getElementById("crud-table-".concat(id));
    let datos = []
    for (var td of tabla.children) {
      //Ver si no tiene datos:
      if (td.children.length == 0) {
        datos.push(td.innerHTML);
      }
    }
    let inputs = document.getElementsByClassName("label-crud");
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
            switch (input.type) {
              //Si la fecha no funciona, descomentar esta linea
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