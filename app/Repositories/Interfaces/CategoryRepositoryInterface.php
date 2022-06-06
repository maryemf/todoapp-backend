<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface extends RepositoryInterface
{}

/*
    La ventaja de hacerlo así, es que se pueden incluir mas metodos si hace falta en el futuro y
    luego se pueden registrar únicamente RepositoryInterface en las clases que lo requieran.
*/
