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
        <?php foreach ($servicios as $servicio): ?>
            <tr>
                <td><?php echo htmlspecialchars($servicio['id_servicio']); ?></td>
                <td><?php echo htmlspecialchars($servicio['nombre']); ?></td>
                <td><?php echo htmlspecialchars($servicio['precio'] ?? 'No definido'); ?></td>
                <td><?php echo htmlspecialchars($servicio['cantidad_limite'] ?? 'N/A'); ?></td>
                <td><?php echo ($servicio['estado'] === 'A') ? 'Activo' : 'Inactivo'; ?></td>
                <td><?php echo htmlspecialchars($servicio['descripcion'] ?? 'Sin descripción'); ?></td>
                <td>
                    <?php if (!empty($servicio['imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($servicio['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($servicio['nombre']); ?>" style="max-width:100px;">
                    <?php else: ?>
                        Sin imagen
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
