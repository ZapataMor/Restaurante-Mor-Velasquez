// resources/js/tables.js (o modals/tables.js)
export function openCloseOrderModal(orderId) {
    const modal = document.getElementById('closeOrderModal');
    if (!modal) {
        console.error('Modal closeOrderModal no encontrado');
        return;
    }

    // Actualizar la acción del formulario
    const form = document.getElementById('closeOrderForm');
    form.action = `/orders/${orderId}/close`;

    // Mostrar el modal
    modal.classList.remove('hidden');
}

export function closeCloseOrderModal() {
    const modal = document.getElementById('closeOrderModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

// También exponer la función de cerrar
window.closeCloseOrderModal = closeCloseOrderModal;