// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "marca": "NA",
    "modelo": "XX-000",
    "precio": 0.0,
    "detalles": "NA",
    "unidades": 1,
    "imagen": "img/default.png"
};

// Se ejecuta al cargar la página para mostrar todos los productos
function listarProductos() {
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let productos = JSON.parse(client.responseText);
            let template = '';
            if (productos.length > 0) {
                productos.forEach(producto => {
                    let descripcion = `<li>precio: ${producto.precio}</li><li>unidades: ${producto.unidades}</li><li>modelo: ${producto.modelo}</li><li>marca: ${producto.marca}</li><li>detalles: ${producto.detalles}</li>`;
                    template += `<tr><td>${producto.id}</td><td>${producto.nombre}</td><td><ul>${descripcion}</ul></td></tr>`;
                });
            } else {
                template = `<tr><td colspan="3">No hay productos para mostrar.</td></tr>`;
            }
            document.getElementById("productos").innerHTML = template;
        }
    };
    client.send();
}

// Función para buscar por ID exacto
function buscarID(e) {
    e.preventDefault();
    var id = document.getElementById('search').value;
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let productos = JSON.parse(client.responseText);
            let template = '';
            if(productos.length > 0) {
                const producto = productos[0];
                let descripcion = `<li>precio: ${producto.precio}</li><li>unidades: ${producto.unidades}</li><li>modelo: ${producto.modelo}</li><li>marca: ${producto.marca}</li><li>detalles: ${producto.detalles}</li>`;
                template += `<tr><td>${producto.id}</td><td>${producto.nombre}</td><td><ul>${descripcion}</ul></td></tr>`;
            } else {
                 template = `<tr><td colspan="3">No se encontró un producto con ese ID.</td></tr>`;
            }
            document.getElementById("productos").innerHTML = template;
        }
    };
    client.send("id=" + id);
}

// Función para buscar por texto
function buscarProducto(e) {
    e.preventDefault();
    var search = document.getElementById('search').value;
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let productos = JSON.parse(client.responseText);
            let template = '';
            if (productos.length > 0) {
                productos.forEach(producto => {
                    let descripcion = `<li>precio: ${producto.precio}</li><li>unidades: ${producto.unidades}</li><li>modelo: ${producto.modelo}</li><li>marca: ${producto.marca}</li><li>detalles: ${producto.detalles}</li>`;
                    template += `<tr><td>${producto.id}</td><td>${producto.nombre}</td><td><ul>${descripcion}</ul></td></tr>`;
                });
            } else {
                template = `<tr><td colspan="3">No se encontraron productos con ese texto.</td></tr>`;
            }
            document.getElementById("productos").innerHTML = template;
        }
    };
    client.send("search=" + search);
}

// Función para agregar un producto
function agregarProducto(e) {
    e.preventDefault();
    var nombreProducto = document.getElementById('name').value;
    var productoJsonString = document.getElementById('description').value;
    var finalJSON;

    if (nombreProducto.trim() === '') {
        alert('El nombre del producto no puede estar vacío.');
        return;
    }
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        alert('El formato del JSON de descripción es inválido.');
        return;
    }
    if (!finalJSON.marca || !finalJSON.modelo) {
        alert('El JSON debe contener al menos "marca" y "modelo".');
        return;
    }

    finalJSON['nombre'] = nombreProducto;
    var dataToSend = JSON.stringify(finalJSON, null, 2);
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            try {
                let response = JSON.parse(client.responseText);
                window.alert(response.message);
                if (response.status === 'success') {
                    document.getElementById('name').value = '';
                    listarProductos(); // Actualiza la lista de productos
                }
            } catch (e) {
                window.alert("Ocurrió un error inesperado.");
            }
        }
    };
    client.send(dataToSend);
}

function getXMLHttpRequest() {
    var objetoAjax;
    try{objetoAjax=new XMLHttpRequest();}catch(e){try{objetoAjax=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{objetoAjax=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){objetoAjax=false;}}}
    return objetoAjax;
}

function init() {
    listarProductos(); // Carga la lista de productos al iniciar
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}