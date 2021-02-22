/**
 * Ottiene i dati di geolocalizzazione dell'utente e li inserisce nei campi della pagina web
 * @param {HTMLInputElement} campoLong riferimento al campo della longitudine
 * @param {HTMLInputElement} campoLat riferimento al campo della latitudine
 */
function localizza(campoLong, campoLat) {
    if(navigator.geolocation==undefined) {
        alert("Funzione di geolocalizzazione non supportata in questo dispositivo");
        return false;
    }

    navigator.geolocation.getCurrentPosition(function (pos) {
        campoLat.value = pos.coords.latitude;
        campoLong.value = pos.coords.longitude;
    });
}

/**
 * Ottiene i dati di geolocalizzazione dell'utente e li inserisce nei campi della pagina web.
 * A differenza della funzione localizza, continua ad aggiornare i valori dei campi se l'utente si sposta.
 * @param {HTMLInputElement} campoLong riferimento al campo della longitudine
 * @param {HTMLInputElement} campoLat riferimento al campo della latitudine
 */
function localizzaContinuo(campoLong, campoLat) {
    if(navigator.geolocation==undefined) {
        alert("Funzione di geolocalizzazione non supportata in questo dispositivo");
        return false;
    }

    navigator.geolocation.getCurrentPosition(function (pos) {
        campoLat.value = pos.coords.latitude;
        campoLong.value = pos.coords.longitude;
    });
}