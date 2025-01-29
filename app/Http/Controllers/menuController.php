<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $posts = Menu::all();
        return view('menu.index', compact('posts'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga_menu' => 'required|string|max:255',
        ]);

        Menu::create($request->all());
        return redirect()->route('menu.index')->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga_menu' => 'required|string|max:255',
        ]);

        $menu->update($request->all());
        return redirect()->route('menu.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully.');
    }
}
