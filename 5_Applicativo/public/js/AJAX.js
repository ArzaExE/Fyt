/* Funzione per il caricamento dei prodotti in base al numero della pagina
   (se non valido o non passato imposta di default 1) */
function loadProducts(page = 1) {
    // Recupera i prodotti in base al numero della pagina
    fetch(`/catalog?page=${page}`)
        .then(response => response.json()) // Converte la risposta in formato json
        .then(data => {
            // Ricarica la parziale con la nuova pagina dei prodotti
            document.getElementById('catalog-partial').innerHTML = data.html;
        });
}

// Carica i prodotti alla prima pagina quando la pagina viene caricata (solamente nella pagina del catalogo)
window.onload = () => {
    if (window.location.pathname === '/catalog') {
        loadProducts(1);
    }
};

// Listener per link della navbar
document.addEventListener('click', function(event) {
    /* Controllo che il link premuto (event.target) appartenga alla classe "page-link",
       classe generata automaticamente da laravel per i link di paginazione */
    if (event.target && event.target.matches('a.page-link')) {
        // Evita il ricaricamento della pagina causato dal tag <a> dopo un reindirizzamento
        event.preventDefault();
        /* Creazione dell'URL per la pagina selezionata partendo dall'URL attuale usando "searchParams"
           per ottenere il numero di pagina del parametro "page".
           event.target.href serve a ottenere l'URL completo che è stato cliccato*/
        const page = new URL(event.target.href).searchParams.get('page');
        // Carica i prodotti della pagina definita nell'URL
        loadProducts(page);
    }
});
