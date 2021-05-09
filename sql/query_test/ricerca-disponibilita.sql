SELECT disponibilita.*
FROM disponibilita
JOIN utente_partecipa_associazione as partecipa on partecipa.id_partecipazione = disponibilita.id_partecipazione
JOIN profili ON profili.id_utente = partecipa.utenti_id_utente
WHERE 1=1
AND profili.id_comune = 'D205'
AND disponibilita.data_disp = '2021-05-09'
AND disponibilita.ora_inizio = '17:00'
AND disponibilita.ora_fine = '18:00'