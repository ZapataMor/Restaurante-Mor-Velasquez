// Inicializar índice
window.productIndex = 1;

// Añadir producto
export function addProduct() {
    const container = document.getElementById('products-container');
    
    // Verificar que exista productsList
    if (!window.productsList || window.productsList.length === 0) {
        console.error('No hay productos disponibles');
        alert('No hay productos disponibles');
        return;
    }

    const newProduct = document.createElement('div');
    newProduct.className = 'product-item border border-neutral-200 dark:border-neutral-700 rounded-xl p-4';

    // 🔑 Detectar si estamos en edit o create
    const isEditMode = window.location.pathname.includes('/edit');
    
    // Si estamos en edit, usar prefijo "new_"
    const itemKey = isEditMode ? `new_${window.productIndex}` : window.productIndex;

    let options = '<option value="">Seleccione un producto</option>';
    window.productsList.forEach(product => {
        options += `<option value="${product.id}" data-price="${product.price}">
            ${product.name} - $${parseFloat(product.price).toFixed(2)}
        </option>`;
    });

    newProduct.innerHTML = `
        <div class="grid md:grid-cols-12 gap-4">
            <div class="md:col-span-${isEditMode ? '4' : '6'}">
                <label class="text-sm text-neutral-500">Producto</label>
                <select name="items[${itemKey}][product_id]" required 
                    class="product-select mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                    ${options}
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm text-neutral-500">Cantidad</label>
                <input type="number" name="items[${itemKey}][quantity]" value="1" min="1" required
                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
            </div>
            <div class="md:col-span-3">
                <label class="text-sm text-neutral-500">Notas</label>
                <input type="text" name="items[${itemKey}][notes]" placeholder="Ej: Sin cebolla"
                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
            </div>
            ${isEditMode ? `
            <div class="md:col-span-2">
                <label class="text-sm text-neutral-500">Estado</label>
                <select name="items[${itemKey}][status]"
                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                    <option value="pendiente" selected>Pendiente</option>
                    <option value="preparando">En Preparación</option>
                    <option value="listo">Listo</option>
                </select>
            </div>
            ` : ''}
            <div class="md:col-span-1 flex items-end">
                <button type="button" onclick="removeProduct(this)" 
                    class="remove-product-btn w-full bg-red-500 hover:bg-red-600 text-white rounded-xl px-4 py-2 text-sm">
                    Eliminar
                </button>
            </div>
        </div>
    `;

    container.appendChild(newProduct);
    window.productIndex++;
    updateRemoveButtons();
    
    console.log('Producto agregado con clave:', itemKey);
}

// Eliminar producto
export function removeProduct(button) {
    const productItem = button.closest('.product-item');
    productItem.remove();
    updateRemoveButtons();
}

// Mostrar u ocultar botón de eliminar
export function updateRemoveButtons() {
    const buttons = document.querySelectorAll('.remove-product-btn');
    buttons.forEach(btn => {
        btn.classList.remove('hidden'); 
    });
}

// ⭐ Hacer funciones accesibles en el DOM global
window.addProduct = addProduct;
window.removeProduct = removeProduct;
window.updateRemoveButtons = updateRemoveButtons;

// Inicializar al cargar
updateRemoveButtons();