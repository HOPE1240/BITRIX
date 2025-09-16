// Selector corto
const $ = selector => document.querySelector(selector);

// Elementos principales
const resultsEl = $('#results');
const statusEl = $('#status');
const buscarBtn = $('#buscar');

// Evento de búsqueda con validación de sector obligatorio
buscarBtn.addEventListener('click', async () => {
    resultsEl.innerHTML = '';
    statusEl.textContent = 'Buscando...';
    const payload = buildPayload();

    try {
    const response = await fetch('/Bitrix-Iframe/api/similares.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            statusEl.textContent = 'Error en la búsqueda (' + response.status + ')';
            return;
        }

        const data = await response.json();
        const properties = data.properties || [];
        render(properties);
        statusEl.textContent = properties.length
            ? `Se encontraron ${properties.length} inmuebles.`
            : 'No se encontraron resultados.';
    } catch (error) {
        statusEl.textContent = 'Error de red o servidor: ' + error.message;
    }
});

/**
 * Construye el payload para la consulta
 */
function buildPayload() {
    const getValue = sel => ($(sel)?.value ?? '').trim();

    // Mapeo de campos del formulario a payload
    const fields = [
        ['#type', 'propertyTypeCode'],
        ['#sector', 'sectorCode'],
        ['#branch', 'branchCode'],
        ['#rmin', 'fromRooms'], ['#rmax', 'toRooms'],
        ['#amin', 'fromArea'],  ['#amax', 'toArea'],
        ['#pmin', 'fromPrice'], ['#pmax', 'toPrice'],
        ['#forRent', 'forRent'], ['#onSale', 'onSale']
    ];

    const payload = fields.reduce((payload, [selector, key]) => {
        const val = getValue(selector);
        if (val !== '') payload[key] = val;
        return payload;
    }, { operation: 'getMatchingProperties' });
    payload.apiKey = 'b337103d-34e9-4ea6-8b80-21b86592532d';
    return payload;
}

/**
 * Renderiza la lista de propiedades
 */
function render(list) {
    resultsEl.innerHTML = '';

    if (!list.length) {
        resultsEl.textContent = 'No hay propiedades para mostrar.';
        return;
    }

    list.forEach((pr, i) => {
        const div = document.createElement('div');
        div.className = 'property';
        div.style.animationDelay = (i * 0.08) + 's';
        div.innerHTML = `
            <strong>${pr.name || pr.title || pr.PropertyType || 'Propiedad'}</strong><br>
            Código de inmueble: ${pr.propertyCode || ''}<br>
            Tipo: ${pr.PropertyType || pr.type || ''}<br>
            Sector: ${pr.Sector || pr.sector || ''}<br>
            Habitaciones: ${pr.numberOfRooms || pr.rooms || ''}<br>
            Área: ${fmt(pr.area)} m²<br>
            Precio: ${fmt(pr.RentValue || pr.saleValue || pr.price)}
        `;
        resultsEl.appendChild(div);
    });
}

/**
 * Formatea valores numéricos como moneda
 */
function fmt(value) {
    if (value == null || value === '') return '';
    try {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(Number(value));
    } catch {
        return value;
    }
}