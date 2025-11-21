import { openCloseOrderModal } from './tables.js';

import { addProduct, removeProduct, updateRemoveButtons } from './orders';

// Hacer funciones globales
window.addProduct = addProduct;
window.removeProduct = removeProduct;
window.updateRemoveButtons = updateRemoveButtons;

// Exponerla globalmente
window.openCloseOrderModal = openCloseOrderModal;