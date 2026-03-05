<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TableController extends Controller
{
    public function getAllStudents(Request $request)
    {
        $students = Students::all();
        return response()->json([
        'message' => 'All Students from Database',
        'count' => $students->count(),
        'data' => $students
        ]);
    }

    public function store(Request $request)
    {
        // Add validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'password' => 'required|string|min:6',
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);
        
        // Use correct model: Students (plural)
        $student = Students::create($validated);
        
        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function show(string $id)
    {
        // Use correct model: Students (plural)
        $student = Students::findOrFail($id);
        return response()->json([
            'data' => $student
        ]);
    }

    public function update(Request $request, string $id)
    {
        // Use correct model: Students (plural)
        $student = Students::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $student->update($validated);
        
        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    public function destroy(string $id)
    {
        // Use correct model: Students (plural)
        $student = Students::findOrFail($id);
        $student->delete();
        
        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }
}