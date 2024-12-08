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

function generarTablaServicios(servicios) {
    if (!Array.isArray(servicios) || servicios.length === 0) {
        return '<p>No hay servicios disponibles</p>';
    }

    let html = `
        <h2>Servicios</h2>
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
                </tr>
            </thead>
            <tbody>
    `;

    servicios.forEach(servicio => {
        html += `
            <tr>
                <td>${servicio.id_servicio}</td>
                <td>${servicio.nombre}</td>
                <td>${servicio.precio !== null ? servicio.precio : 'No definido'}</td>
                <td>${servicio.cantidad_limite || 'N/A'}</td>
                <td>${servicio.estado === 'A' ? 'Activo' : 'Inactivo'}</td>
                <td>${servicio.descripcion || 'Sin descripción'}</td>
                <td>${servicio.imagen ? `<img src="${servicio.imagen}" alt="Imagen de ${servicio.nombre}" style="max-width:100px;">` : 'Sin imagen'}</td>
            </tr>
        `;
    });

    html += `</tbody></table>`;
    return html;
}

function generarTablaHabitaciones(habitaciones) {
    if (!Array.isArray(habitaciones) || habitaciones.length === 0) {
        return '<p>No hay habitaciones disponibles</p>';
    }

    let html = `
        <h2>Habitaciones</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Habitación</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
    `;

    habitaciones.forEach(habitacion => {
        html += `
            <tr>
                <td>${habitacion.id_habitacion}</td>
                <td>${habitacion.nombre}</td>
                <td>${habitacion.precio !== null ? habitacion.precio : 'No definido'}</td>
                <td>${habitacion.capacidad || 'N/A'}</td>
                <td>${habitacion.estado === 'A' ? 'Activo' : 'Inactivo'}</td>
                <td>${habitacion.descripcion || 'Sin descripción'}</td>
                <td>${habitacion.imagen ? `<img src="${habitacion.imagen}" alt="Imagen de ${habitacion.nombre}" style="max-width:100px;">` : 'Sin imagen'}</td>
            </tr>
        `;
    });

    html += `</tbody></table>`;
    return html;
}
