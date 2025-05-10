<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $tests = Test::with(['course', 'module', 'lesson', 'questions'])->paginate($perPage);

        return response()->json($tests);
    }

    public function show($id)
    {
        $test = Test::with(['course', 'module', 'lesson', 'questions'])->findOrFail($id);
        return response()->json($test);
    }
}
