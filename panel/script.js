document.addEventListener('DOMContentLoaded', function() {
    // Konfiguracja
    const API_URL = 'api.php';
    const STATUS_MAPPING = {
        'nowe-zamowienia': 'nowe',
        'przyjete': 'przyjete',
        'w-trakcie': 'w trakcie',
        'u-dostawcy': 'u dostawcy',
        'zrealizowane': 'zrealizowane',
        'odrzucone': 'odrzucone'
    };

    // Funkcja formatująca datę
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('pl-PL', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Funkcja tworząca element zamówienia
    function createOrderElement(order) {
        const element = document.createElement('div');
        element.className = 'draggable';
        element.draggable = true;
        element.dataset.orderId = order.id_zamowienia;

        // Przygotowanie listy pizz
        let pizzasHTML = '';
        order.szczegoly.forEach(pizza => {
            pizzasHTML += `<li>${pizza.nazwa_pizzy} (${pizza.ilosc}szt)`;
            
            // Dodaj składniki jeśli istnieją
            if (pizza.skladniki) {
                try {
                    const ingredients = JSON.parse(pizza.skladniki);
                    if (Array.isArray(ingredients)) {
                        pizzasHTML += ` - ${ingredients.join(', ')}`;
                    }
                } catch (e) {
                    console.error('Błąd parsowania składników:', e);
                }
            }
            
            pizzasHTML += `</li>`;
        });

        element.innerHTML = `
            <div class="order-header">
                <strong>Zamówienie #${order.id_zamowienia}</strong>
                <span class="order-time">${formatDate(order.data_zamowienia)}</span>
            </div>
            <div class="customer-info">
                <div><strong>${order.imie_nazwisko}</strong></div>
                <div>${order.adres}, ${order.miasto}</div>
                <div>Tel: ${order.telefon}</div>
            </div>
            <div class="pizzas">
                <strong>Pizze (${order.liczba_pizz || 0}):</strong>
                <ul class="pizza-list">${pizzasHTML}</ul>
            </div>
            ${order.uwagi ? `<div class="notes"><strong>Uwagi:</strong> ${order.uwagi}</div>` : ''}
        `;

        return element;
    }

    // Funkcja ładująca zamówienia
    async function loadOrders() {
        try {
            for (const [columnId, status] of Object.entries(STATUS_MAPPING)) {
                const response = await fetch(`${API_URL}?action=get_orders&status=${status}`);
                if (!response.ok) throw new Error('Błąd sieci');
                
                const orders = await response.json();
                const column = document.getElementById(columnId);
                
                // Zachowaj tytuł kolumny
                const title = column.querySelector('.section-title')?.textContent || '';
                column.innerHTML = `<div class="section-title">${title}</div>`;
                
                if (orders.length === 0) {
                    column.innerHTML += '<div class="no-orders">Brak zamówień</div>';
                    continue;
                }
                
                orders.forEach(order => {
                    column.appendChild(createOrderElement(order));
                });
            }
        } catch (error) {
            console.error('Błąd ładowania zamówień:', error);
        }
    }

    // Inicjalizacja przeciągania
    function initDragAndDrop() {
        const draggables = document.querySelectorAll('.draggable');
        const columns = document.querySelectorAll('.column');
        
        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });
            
            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });
        
        columns.forEach(column => {
            column.addEventListener('dragover', e => {
                e.preventDefault();
                const draggable = document.querySelector('.dragging');
                if (!draggable) return;
                
                const afterElement = getDragAfterElement(column, e.clientY);
                if (afterElement) {
                    column.insertBefore(draggable, afterElement);
                } else {
                    column.appendChild(draggable);
                }
                
                // Aktualizacja statusu w bazie danych
                const orderId = draggable.dataset.orderId;
                const newStatus = STATUS_MAPPING[column.id];
                
                fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_status&order_id=${orderId}&new_status=${newStatus}`
                }).catch(error => {
                    console.error('Błąd aktualizacji statusu:', error);
                });
            });
        });
        
        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];
            
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    }

    // Automatyczne odświeżanie co 10 sekund
    setInterval(() => {
        loadOrders().then(initDragAndDrop);
    }, 10000);
    
    // Pierwsze ładowanie
    loadOrders().then(initDragAndDrop);
    
    // Inicjalizacja przycisków (otwieranie/zamykanie)
    document.getElementById('openBtn').addEventListener('click', () => {
        document.getElementById('openBtn').style.display = 'none';
        document.getElementById('closeBtn').style.display = 'inline-block';
        document.getElementById('deliveryToggleBtn').style.display = 'inline-block';
    });
    
    document.getElementById('closeBtn').addEventListener('click', () => {
        document.getElementById('openBtn').style.display = 'inline-block';
        document.getElementById('closeBtn').style.display = 'none';
        document.getElementById('deliveryToggleBtn').style.display = 'none';
    });
    
    document.getElementById('deliveryToggleBtn').addEventListener('click', function() {
        this.textContent = this.textContent === 'Wstrzymanie dostaw' 
            ? 'Wznów dostawy' 
            : 'Wstrzymanie dostaw';
        this.classList.toggle('active');
    });
    
    // Wylogowanie
    document.getElementById('logoutBtn').addEventListener('click', () => {
        if (confirm('Na pewno chcesz się wylogować?')) {
            window.location.href = 'logout.php';
        }
    });
});