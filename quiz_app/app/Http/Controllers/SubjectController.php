<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    use ResponseTrait;

    public function create(SubjectRequest $request)
    {
        $validated = $request->validated();

        if($validated)
        {
            $subject = Subject::create([
                'name' => $request->name
            ]);

            return $this->okResponse('Subject Created', $subject);
        }
    }

    public function view()
    {
        $subjects = Subject::all();

        return $this->okResponse('Subjects', $subjects);
    }
}
