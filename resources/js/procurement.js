/**
 * Procurement Module JavaScript
 * Handles modal interactions for procurement management
 */

/**
 * Opens the rejection modal with a prompt for reason
 * @param {number} id - Procurement ID
 */
function openRejectModal(id) {
    let reason = prompt("Masukkan alasan penolakan (Wajib diisi):");
    if (reason !== null && reason.trim() !== "") {
        submitStatusForm(id, 'rejected', reason);
    } else if (reason !== null) {
        alert("Alasan penolakan tidak boleh kosong.");
    }
}

/**
 * Opens the approval modal with procurement details
 * @param {string} id - Procurement ID
 * @param {string} itemName - Item name
 * @param {string} qty - Quantity
 * @param {string} itemType - Type (asset/consumable)
 * @param {string} categoryName - Category name
 */
function openApproveModal(id, itemName, qty, itemType, categoryName) {
    document.getElementById('approve_id').value = id;
    document.getElementById('modal_item_name').innerText = itemName;
    document.getElementById('modal_item_qty').innerText = qty;
    document.getElementById('modal_item_type').innerText = itemType === 'asset' ? 'Aset Tetap' : 'BHP';
    document.getElementById('modal_item_category').innerText = categoryName;
    document.getElementById('approveModal').classList.remove('hidden');
}

/**
 * Closes the approval modal
 */
function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

/**
 * Opens the completion modal with procurement details
 * @param {string} id - Procurement ID
 * @param {string} itemName - Item name
 * @param {string} qty - Quantity
 * @param {string} price - Unit price estimation
 * @param {string} itemType - Type (asset/consumable)
 * @param {string} categoryName - Category name
 */
function openCompleteModal(id, itemName, qty, price, itemType, categoryName) {
    document.getElementById('complete_id').value = id;
    document.getElementById('modal_complete_item_name').innerText = itemName;
    document.getElementById('modal_complete_item_qty').innerText = qty;
    document.getElementById('modal_complete_item_type').innerText = itemType === 'asset' ? 'Aset Tetap' : 'BHP';
    document.getElementById('modal_complete_item_category').innerText = categoryName;

    // Generate batch code with date
    let today = new Date().toISOString().slice(0, 10).replace(/-/g, "");
    document.getElementById('batch_code').value = 'PROC-' + id + '-' + today;
    document.getElementById('unit_price').value = price;

    document.getElementById('completeModal').classList.remove('hidden');
}

/**
 * Closes the completion modal
 */
function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
}

/**
 * Submits a status change form dynamically
 * @param {number} id - Procurement ID
 * @param {string} status - New status
 * @param {string|null} note - Admin note (optional)
 */
function submitStatusForm(id, status, note = null) {
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = '/pengadaan/' + id + '/status';
    
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Hidden method field for PUT
    let hiddenMethod = document.createElement('input');
    hiddenMethod.type = 'hidden';
    hiddenMethod.name = '_method';
    hiddenMethod.value = 'PUT';
    form.appendChild(hiddenMethod);

    // CSRF token
    let hiddenCsrf = document.createElement('input');
    hiddenCsrf.type = 'hidden';
    hiddenCsrf.name = '_token';
    hiddenCsrf.value = csrfToken;
    form.appendChild(hiddenCsrf);

    // Status field
    let hiddenStatus = document.createElement('input');
    hiddenStatus.type = 'hidden';
    hiddenStatus.name = 'status';
    hiddenStatus.value = status;
    form.appendChild(hiddenStatus);

    // Admin note (if provided)
    if (note) {
        let hiddenNote = document.createElement('input');
        hiddenNote.type = 'hidden';
        hiddenNote.name = 'admin_note';
        hiddenNote.value = note;
        form.appendChild(hiddenNote);
    }

    document.body.appendChild(form);
    form.submit();
}

// Export functions for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        openRejectModal,
        openApproveModal,
        closeApproveModal,
        openCompleteModal,
        closeCompleteModal,
        submitStatusForm
    };
}
