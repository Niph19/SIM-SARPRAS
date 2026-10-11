<?php

namespace App\Http\Controllers;

class GuruController extends StaffController
{
    protected string $role = 'guru';

    protected string $routePrefix = 'guru';

    protected string $title = 'Guru';
}
