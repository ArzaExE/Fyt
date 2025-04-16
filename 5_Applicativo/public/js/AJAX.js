// Funzione per il caricamento dei prodotti in base al numero della pagina (se non valido o non passato imposta di default 1)
function loadProducts(page = 1) {
    // Recupera i prodotti in base al numero della pagina
    fetch(`/products?page=${page}`)
        .then(response => response.json())
        .then(data => {
            // Aggiorna i prodotti (solo gli oggetti)
            const productList = document.getElementById('product-list');
            // Pulizia della lista
            productList.innerHTML = data.data.map(product => `
                <div class="product">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                </div>
            `).join('');

            // Aggiorna i link di paginazione (usiamo solo i link, non l'HTML completo)
            const paginationLinks = document.getElementById('pagination-links');
            paginationLinks.innerHTML = data.links; // Mostra solo i link di paginazione
        });
}

// Carica i prodotti alla prima pagina quando la pagina viene caricata
window.onload = () => loadProducts(1);

// Listener per link della navbar
document.addEventListener('click', function(event) {
    /* Controllo che il link premuto (event.target) appartenga alla classe "page-link",
       classe generata automaticamente da laravel per i link di paginazione */
    if (event.target && event.target.matches('a.page-link')) {
        // Evita il ricaricamento della pagina causato dal tag <a> dopo un reindirizzamento
        event.preventDefault();
        /* Creazione dell'URL per la pagina selezionata partendo dall'URL attuale usando "searchParams"
           per ottenere il numero di pagina del parametro "page" */
        const page = new URL(event.target.href).searchParams.get('page');
        // Carica i prodotti
        loadProducts(page);
    }
});
