<?php

namespace App\Http\Controllers;

class PetugasController extends StaffController
{
    protected string $role = 'petugas_sarpras';

    protected string $routePrefix = 'petugas';

    protected string $title = 'Petugas Sarpras';
}
