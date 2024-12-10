// Eventos al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    const enlaces = document.querySelectorAll('.admin-link');
    const main = document.querySelector('main');

    enlaces.forEach(enlace => {
        enlace.addEventListener('click', (event) => {
            event.preventDefault(); 
            const url = enlace.getAttribute('href');

            main.innerHTML = '<p>Cargando...</p>';

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al obtener los datos: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (url.includes('servicios-api')) {
                        const tablaHTML = generarTablaServicios(data);
                        main.innerHTML = tablaHTML;

                        // Configuración del modal
                        configurarModal(main);
                    } else if (url.includes('habitaciones-api')) {
                        const tablaHTML = generarTablaHabitaciones(data);
                        main.innerHTML = tablaHTML;
                    }
                })
                .catch(err => {
                    console.error(err);
                    main.innerHTML = '<p>Error al cargar los datos.</p>';
                });
        });
    });
});

// Función para configurar el modal
function configurarModal(main) {
    const modal = main.querySelector('#modal-insertar-servicio');
    const btnAbrir = main.querySelector('#btn-agregar-servicio');
    const btnCerrar = modal.querySelector('.close');

    btnAbrir.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    btnCerrar.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    const form = modal.querySelector('#form-insertar-servicio');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        insertarServicio(new FormData(form), main);
        modal.style.display = 'none';
    });
}

// Función para insertar servicio
function insertarServicio(formData, main) {
    const data = Object.fromEntries(formData.entries());
    fetch('/admin/servicios-api', { // Actualización de ruta
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al insertar el servicio: ' + response.statusText);
            }
            return response.json();
        })
        .then(nuevoServicio => {
            alert('Servicio insertado correctamente');
            const tabla = main.querySelector('table tbody');
            const nuevaFila = generarFilaServicio(nuevoServicio);
            tabla.insertAdjacentHTML('beforeend', nuevaFila);
        })
        .catch(err => {
            console.error(err);
            alert('Error al insertar el servicio.');
        });
}

// Funciones para generar tablas
function generarTablaServicios(servicios) {
    if (!Array.isArray(servicios) || servicios.length === 0) {
        return '<p>No hay servicios disponibles</p>';
    }

    let html = `
        <h2>Servicios</h2>
        <button id="btn-agregar-servicio">Agregar Servicio</button>
        <div id="modal-insertar-servicio" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="form-insertar-servicio">
                    <h3>Insertar Nuevo Servicio</h3>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>
                    <label>Precio:</label>
                    <input type="number" name="precio" step="0.01" required>
                    <label>Cantidad Límite:</label>
                    <input type="number" name="cantidad_limite">
                    <label>Estado:</label>
                    <select name="estado">
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                    </select>
                    <label>Descripción:</label>
                    <textarea name="descripcion"></textarea>
                    <label>Imagen URL:</label>
                    <input type="url" name="imagen">
                    <button type="submit">Insertar Servicio</button>
                </form>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Servicio</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad Límite</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    `;

    servicios.forEach(servicio => {
        html += generarFilaServicio(servicio);
    });

    html += `</tbody></table>`;
    return html;
}

function generarFilaServicio(servicio) {
    return `
        <tr data-id="${servicio.id_servicio}">
            <td>${servicio.id_servicio}</td>
            <td>${servicio.nombre}</td>
            <td>${servicio.precio !== null ? servicio.precio : 'No definido'}</td>
            <td>${servicio.cantidad_limite || 'N/A'}</td>
            <td>${servicio.estado === 'A' ? 'Activo' : 'Inactivo'}</td>
            <td>${servicio.descripcion || 'Sin descripción'}</td>
            <td>${servicio.imagen ? `<img src="${servicio.imagen}" alt="Imagen de ${servicio.nombre}" style="max-width:100px;">` : 'Sin imagen'}</td>
            <td>
                <button class="btn-editar">Editar</button>
                <button class="btn-eliminar">Eliminar</button>
            </td>
        </tr>
    `;
}
