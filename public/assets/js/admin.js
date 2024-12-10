// Eventos al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    const enlaces = document.querySelectorAll('.admin-link');
    const main = document.querySelector('main');

    configurarNavegacion(enlaces, main);
});

// Configuración de navegación dinámica
function configurarNavegacion(enlaces, main) {
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', (event) => {
            event.preventDefault();
            const url = enlace.getAttribute('href');
            main.innerHTML = '<p>Cargando...</p>';

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error(`Error: ${response.statusText}`);
                    return response.json();
                })
                .then(data => {
                    if (url.includes('servicios-api')) {
                        main.innerHTML = generarTablaServicios(data);
                        configurarModalInsercion(main);
                        configurarEventosTabla(main);
                    } else if (url.includes('habitaciones-api')) {
                        main.innerHTML = generarTablaHabitaciones(data);
                    }
                })
                .catch(err => {
                    console.error(err);
                    main.innerHTML = '<p>Error al cargar los datos.</p>';
                });
        });
    });
}

// Generación de tablas dinámicas
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
        <div id="modal-editar-servicio" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="form-editar-servicio">
                    <h3>Editar Servicio</h3>
                    <input type="hidden" name="id_servicio">
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
                    <button type="submit">Guardar Cambios</button>
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
                ${servicios.map(servicio => generarFilaServicio(servicio)).join('')}
            </tbody>
        </table>
    `;
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

// Configuración de modales y eventos
function configurarModalInsercion(main) {
    const modal = main.querySelector('#modal-insertar-servicio');
    const btnAbrir = main.querySelector('#btn-agregar-servicio');
    const btnCerrar = modal.querySelector('.close');

    btnAbrir.addEventListener('click', () => modal.style.display = 'block');
    btnCerrar.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', (event) => {
        if (event.target === modal) modal.style.display = 'none';
    });

    modal.querySelector('#form-insertar-servicio').addEventListener('submit', (event) => {
        event.preventDefault();
        insertarServicio(new FormData(event.target), main);
        modal.style.display = 'none';
    });
}

function configurarEventosTabla(main) {
    const modalEditar = main.querySelector('#modal-editar-servicio');

    main.addEventListener('click', (event) => {
        const target = event.target;

        if (target.classList.contains('btn-editar')) {
            const fila = target.closest('tr');
            const id = fila.getAttribute('data-id');
            const form = modalEditar.querySelector('#form-editar-servicio');

            form.id_servicio.value = id;
            form.nombre.value = fila.querySelector('td:nth-child(2)').textContent;
            form.precio.value = fila.querySelector('td:nth-child(3)').textContent;
            form.cantidad_limite.value = fila.querySelector('td:nth-child(4)').textContent !== 'N/A' ? fila.querySelector('td:nth-child(4)').textContent : '';
            form.estado.value = fila.querySelector('td:nth-child(5)').textContent === 'Activo' ? 'A' : 'I';
            form.descripcion.value = fila.querySelector('td:nth-child(6)').textContent;
            form.imagen.value = fila.querySelector('td:nth-child(7) img')?.getAttribute('src') || '';

            modalEditar.style.display = 'block';
        }

        if (target.classList.contains('btn-eliminar')) {
            const fila = target.closest('tr');
            const id = fila.getAttribute('data-id');
            if (confirm('¿Estás seguro de eliminar este servicio?')) eliminarServicio(id, fila);
        }
    });

    modalEditar.querySelector('.close').addEventListener('click', () => {
        modalEditar.style.display = 'none';
    });

    modalEditar.querySelector('#form-editar-servicio').addEventListener('submit', (event) => {
        event.preventDefault();
        editarServicio(new FormData(event.target));
        modalEditar.style.display = 'none';
    });
}

// Operaciones CRUD
function insertarServicio(formData, main) {
    const data = Object.fromEntries(formData.entries());
    fetch('/admin/servicios-api', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(nuevoServicio => {
            alert('Servicio insertado correctamente');
            main.querySelector('table tbody').insertAdjacentHTML('beforeend', generarFilaServicio(nuevoServicio));
        })
        .catch(err => alert('Error al insertar el servicio.'));
}

function editarServicio(formData) {
    const id = formData.get('id_servicio');
    const data = Object.fromEntries(formData.entries());

    fetch('/admin/servicios-api', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_servicio: id, ...data })
    })
        .then(() => {
            alert('Servicio actualizado correctamente');
            location.reload();
        })
        .catch(err => alert('Error al actualizar el servicio.'));
}

function eliminarServicio(id, fila) {
    fetch('/admin/servicios-api', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(() => {
            alert('Servicio eliminado correctamente');
            fila.remove();
        })
        .catch(err => alert('Error al eliminar el servicio.'));
}
