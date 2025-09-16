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

<style>
body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: #f6f8fa;
  margin: 0;
  padding: 0;
}
.container {
  max-width: 480px;
  margin: 32px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  padding: 32px 24px 24px 24px;
}
#filtro {
  display: grid;
  gap: 16px;
}
#filtro label {
  display: flex;
  flex-direction: column;
  font-size: 15px;
  color: #222;
}
#filtro input, #filtro select {
  margin-top: 6px;
  padding: 8px 10px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 15px;
  background: #f9f9f9;
  transition: border-color 0.2s, box-shadow 0.3s;
}
#filtro input:focus, #filtro select:focus {
  border-color: #0078d7;
  outline: none;
  box-shadow: 0 0 0 2px #cce6ff;
}
#buscar {
  background: #0078d7;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 12px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 8px;
  transition: background 0.2s, box-shadow 0.3s;
  box-shadow: 0 2px 8px rgba(0,120,215,0.08);
}
#buscar:hover {
  background: #005fa3;
  box-shadow: 0 0 12px 2px #0078d7a0;
}
#status {
  margin: 18px 0 8px 0;
  font-size: 15px;
  color: #0078d7;
}
#results {
  margin-top: 8px;
}
.property {
  background: #f3f6fa;
  border-radius: 8px;
  padding: 16px;
  margin-bottom: 12px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.7s cubic-bezier(.23,1.01,.32,1) forwards;
}
@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<div class="container">
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
</div>
<!-- Incluye tu JS -->
<script src="assets/app.js"></script>
