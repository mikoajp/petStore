<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index()
    {
        $pets = $this->petService->getAvailablePets();

        if (isset($pets['error'])) {
            return view('pets.index')->withErrors(['error' => $pets['error']]);
        }

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $result = $this->petService->addPet($request->all());

        if ($result === true) {
            return redirect()->route('pets.index')->with('success', 'Pet added successfully.');
        }

        return back()->withErrors($result);
    }

    public function edit($id)
    {
        $pet = $this->petService->getPet($id);

        if (isset($pet['error'])) {
            return redirect()->route('pets.index')->withErrors(['error' => $pet['error']]);
        }

        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;

        $result = $this->petService->updatePet($data);

        if ($result === true) {
            return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
        }

        return back()->withErrors($result);
    }

    public function destroy($id)
    {
        $result = $this->petService->deletePet($id);

        if ($result === true) {
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
        }

        return back()->withErrors($result);
    }
}
