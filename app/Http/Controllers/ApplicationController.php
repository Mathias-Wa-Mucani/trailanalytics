<?php

namespace App\Http\Controllers;

use App\DataTables\ViewOldPersonApplicationDataTable;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(ViewOldPersonApplicationDataTable $dataTable)
    {
        $data['title']    = "Applications";
        return $dataTable->render('dashboard.applications.applications', $data);;
    }
}
