<!-- resources/views/components/modals/close-order-modal.blade.php -->
<div id="closeOrderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 w-96">
        <h3 class="text-lg font-bold mb-4">Confirmar cierre de orden</h3>
        <p class="mb-4">¿Estás seguro de que quieres completar la orden y liberar la mesa?</p>
        
        <form id="closeOrderForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCloseOrderModal()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Confirmar</button>
            </div>
        </form>
    </div>
</div>
