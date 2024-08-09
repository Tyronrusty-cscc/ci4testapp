document.addEventListener('DOMContentLoaded', function() {
    const showModal = () => {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div class="modal">
                <p>Please accept our cookies to continue.</p>
                <button onclick="closeModal()">Accept</button>
            </div>
        `;
        document.body.appendChild(modal);
    };

    const closeModal = () => {
        document.querySelector('.modal').remove();
    };

    showModal();
});