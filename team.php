<?php ob_start(); ?>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h1>Informazioni su...</h1>

      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis repudiandae placeat doloribus expedita fugiat, ullam ducimus. Architecto sapiente eius delectus non accusamus rem! Corrupti asperiores quibusdam explicabo totam corporis animi?</p>
    </div>
    <div class="col-md-4">
      <h1>Dev::Team</h1>

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

<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>