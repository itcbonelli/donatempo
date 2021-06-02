/**
 * Filtra i comuni di un elenco a discesa in base alla provincia scelta
 * @param {string} targetElement ID di un elemento select contenente voci di comune
 * @param {string} sigla Sigla della provincia da impostare
 */
function setProvincia(sender, targetElement) {
    var sigla = sender.value;
    var comboComuni=document.getElementById(targetElement);
    var figli = comboComuni.querySelectorAll('optgroup, option');
    for(var i=0; i<figli.length; i++) {
        var data_prov = figli[i].getAttribute('data-provincia');
        if(data_prov !== sigla) {
            figli[i].style.display='none';
        } else {
            figli[i].style.display='block';
        }
    }

    comboComuni.value="";
}