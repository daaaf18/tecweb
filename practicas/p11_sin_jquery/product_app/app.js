// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// Variable para controlar si estamos editando
var edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

$(document).ready(function() {
    init();

    // EVENTO KEYUP PARA BÚSQUEDA EN TIEMPO REAL
    $('#search').keyup(function() {
        var search = $(this).val();
        
        if(search.trim() !== '') {
            buscarProducto(search);
        } else {
            // Si el campo está vacío, mostrar todos los productos
            listarProductos();
            // Ocultar la barra de resultados
            $('#product-result').removeClass('d-block').addClass('d-none');
        }
    });

    // PREVENIR SUBMIT DEL FORMULARIO DE BÚSQUEDA
    $('.form-inline').submit(function(e) {
        e.preventDefault();
    });

    // EVENTO SUBMIT DEL FORMULARIO DE AGREGAR/EDITAR PRODUCTO
    $('#product-form').submit(function(e) {
        agregarProducto(e);
    });

    // EVENTO CLICK EN BOTONES DE ELIMINAR (delegación de eventos)
    $(document).on('click', '.product-delete', function() {
        eliminarProducto($(this));
    });

    // EVENTO CLICK EN BOTONES DE EDITAR (delegación de eventos)
    $(document).on('click', '.product-edit', function() {
        editarProducto($(this));
    });
});

// FUNCIÓN PARA LISTAR PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';

                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td><a href="#" class="product-edit">${producto.nombre}</a></td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
            }
        }
    });
}

// FUNCIÓN PARA BUSCAR PRODUCTO EN TIEMPO REAL
function buscarProducto(search) {
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                let template_bar = '';

                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td><a href="#" class="product-edit">${producto.nombre}</a></td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template_bar += `
                        <li>${producto.nombre}</li>
                    `;
                });
                
                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').removeClass('d-none').addClass('d-block');
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                // SE INSERTA LA PLANTILLA EN LA TABLA
                $('#products').html(template);
            } else {
                // Si no hay resultados, ocultar la barra y limpiar la tabla
                $('#product-result').removeClass('d-block').addClass('d-none');
                $('#products').html('');
            }
        }
    });
}

// FUNCIÓN PARA AGREGAR O EDITAR PRODUCTO
function agregarProducto(e) {
    e.preventDefault();

    var productoJsonString = $('#description').val();
    var finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();
    finalJSON['id'] = $('#productId').val();
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    /**
     * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
     * ...
     * 
     * --> EN CASO DE NO HABER ERRORES, SE ENVÍA EL PRODUCTO A AGREGAR
     */

    // Determinar la URL según si estamos editando o agregando
    var url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json;charset=UTF-8',
        data: productoJsonString,
        success: function(response) {
            console.log(response);
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;

            // SE HACE VISIBLE LA BARRA DE ESTADO
            $('#product-result').removeClass('d-none').addClass('d-block');
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            $('#container').html(template_bar);
            
            // SE LISTAN TODOS LOS PRODUCTOS PARA VISUALIZAR LA LISTA ACTUALIZADA
            listarProductos();
            
            // Limpiar el formulario y resetear el modo de edición
            $('#name').val('');
            $('#productId').val('');
            $('#description').val(JSON.stringify(baseJSON, null, 2));
            edit = false;
            $('#product-form button[type="submit"]').text('Agregar Producto');
        }
    });
}

// FUNCIÓN PARA EDITAR PRODUCTO
function editarProducto(element) {
    // Prevenir comportamiento por defecto del enlace
    event.preventDefault();
    
    // Obtener el ID del producto desde el atributo productId del tr
    var row = element.closest('tr');
    var id = row.attr('productId');
    
    // Hacer una petición para obtener los datos del producto
    $.ajax({
        url: './backend/product-single.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            let producto = JSON.parse(response);
            
            // Llenar el formulario con los datos del producto
            $('#name').val(producto.nombre);
            $('#productId').val(producto.id);
            
            // Crear el objeto JSON sin el nombre y el id
            let productoJSON = {
                "precio": parseFloat(producto.precio),
                "unidades": parseInt(producto.unidades),
                "modelo": producto.modelo,
                "marca": producto.marca,
                "detalles": producto.detalles,
                "imagen": producto.imagen
            };
            
            $('#description').val(JSON.stringify(productoJSON, null, 2));
            
            // Cambiar el modo a edición
            edit = true;
            $('#product-form button[type="submit"]').text('Editar Producto');
        }
    });
}

// FUNCIÓN PARA ELIMINAR PRODUCTO
function eliminarProducto(button) {
    if(confirm("De verdad deseas eliminar el Producto")) {
        var row = button.closest('tr');
        var id = row.attr('productId');

        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').removeClass('d-none').addClass('d-block');
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);
                
                // SE LISTAN TODOS LOS PRODUCTOS PARA VISUALIZAR LA LISTA ACTUALIZADA
                listarProductos();
            }
        });
    }
}