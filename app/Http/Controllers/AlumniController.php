<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlumniDetailResource;
use App\Http\Resources\AlumniResource;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with('Account:id,username,email')->get();
        return AlumniResource::collection($alumni);
    }
    public function show($id)
    {
        $alumniShow = Alumni::with('DetailAccount:id,username,email')->findOrFail($id);
        return new AlumniDetailResource($alumniShow);
    }
}
