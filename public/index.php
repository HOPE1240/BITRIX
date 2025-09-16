<?php

$tipos = [
    'APARTAMENTO'     => 'Apartamento',
    'APARATESTUDIO'   => 'Apartaestudio',
    'CASA'            => 'Casa',
    'BODEGA'          => 'Bodega',
    'OFICINA'         => 'Oficina',
    'FINCA'           => 'Finca',
    'LOCAL'           => 'Local',
    'LOTE'            => 'Lote',
    'CONSULTORIO'     => 'Consultorio',
    'HOTEL'           => 'Hotel',
    'EDIFICIO'        => 'Edificio',
    'CABAÑA'          => 'Cabaña',
    'APSUITE'         => 'Aparta Suite',
    'SUITEHT'         => 'Suite Hotelera',
    'CASA_COM'        => 'Casa Comercial',
    'BURBUJA'         => 'Burbuja',
    'CASACAMPESTRE'   => 'Casa Campestre',
    'BD1'             => 'Bodega Producto',
    'BD2'             => 'Bodega de partes',
    'PRUEBA'          => 'Prueba',
    '1'               => '1',
    'PARQUEADERO'     => 'Parqueadero'
];
?>
<form id="filtro">
    <label for="type">Tipo
        <select id="type" name="type">
            <?php foreach ($tipos as $codigo => $nombre): ?>
                <option value="<?= $codigo ?>" <?= $codigo === 'APARTAMENTO' ? 'selected' : '' ?>><?= $nombre ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label for="sector">Sector
        <input id="sector" name="sector" type="text" />
    </label>
    <input id="branch" name="branch" type="hidden" value="OCCIDENTE" />
    <label for="rmin">Habitaciones mín.
        <input id="rmin" name="rmin" type="number" min="0" />
    </label>
    <label for="rmax">Habitaciones máx.
        <input id="rmax" name="rmax" type="number" min="0" />
    </label>
    <label for="amin">Área mín.
        <input id="amin" name="amin" type="number" min="0" />
    </label>
    <label for="amax">Área máx.
        <input id="amax" name="amax" type="number" min="0" />
    </label>
    <label for="pmin">Precio mín.
        <input id="pmin" name="pmin" type="number" min="0" />
    </label>
    <label for="pmax">Precio máx.
        <input id="pmax" name="pmax" type="number" min="0" />
    </label>
    <label for="forRent">¿Arriendo?
        <select id="forRent" name="forRent">
            <option value="T">Sí</option>
            <option value="F">No</option>
        </select>
    </label>
    <label for="onSale">¿Venta?
        <select id="onSale" name="onSale">
            <option value="T">Sí</option>
            <option value="F">No</option>
        </select>
    </label>
    <button type="button" id="buscar">Buscar</button>
</form>
<div id="status"></div>
<div id="results"></div>
<!-- Incluye tu JS -->
<script src="assets/app.js"></script>
