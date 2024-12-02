<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AttendanceController extends Controller
{
    public function index()
    {
        return response()->json(Attendance::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,late,on_leave',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'attendance_date' => $request->attendance_date,
            'status' => $request->status,
        ]);

        return response()->json($attendance, 201);
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return response()->json($attendance);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:present,absent,late,on_leave',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->only('status'));

        return response()->json($attendance);
    }

    public function destroy($id)
    {
        Attendance::destroy($id);
        return response()->json(['message' => 'Attendance record deleted successfully']);
    }
}
