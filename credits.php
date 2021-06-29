<?php
require_once __DIR__ . '/include/main.php';
ob_start(); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">

        <p class="lead text-justify">
          Siamo la classe 5^A SIA dell'Istituto Tecnico Commerciale Franco Andrea Bonelli di Cuneo.<br />
          Coordinati dai nostri professori di informatica abbiamo contribuito all'analisi della base di dati e allo sviluppo del backoffice di gestione di Donatempo.
          Ringraziamo l'associazione Casa Do Menor Onlus e il Team del capitolato BNI La Granda per averci offerto la possibilità di partecipare a questo progetto.
        </p>
      </div>
      <div class="col-md-5">
        <h1>Team di sviluppo</h1>

        <h5>Docenti</h5>
        <ul>
          <li>Prof. Flecchia Federico</li>
          <li>Prof.ssa Console Laura</li>
        </ul>

        <h5>Studenti</h5>
        <ul>
          <li>Ambrogio Michela</li>
          <li>Barale Gaia</li>
          <li>Chesta Giulia</li>
          <li>Cometto Carola</li>
          <li>Coraglia Giorgio</li>
          <li>Filippi Matteo</li>
          <li>Llozhi Matteo</li>
          <li>Lops Andrea</li>
          <li>Mattalia Alice</li>
          <li>Meinero Beatrice</li>
          <li>Miglietti Francesco</li>
          <li>Nerattini Carola</li>
          <li>Oberto Azzurra</li>
          <li>Olla Simone</li>
          <li>Pagliasso Alessia</li>
          <li>Ramonda Samuele</li>
          <li>Ricci Federica</li>
          <li>Tosello Lucia</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>