<?php

namespace Astrogoat\Courses\Http\Controllers;

use Astrogoat\Courses\Models\Course;
use Helix\Lego\Events\PageViewed;
use Helix\Lego\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CoursesController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->isVisible(), 404);

        $course->load(['sections', 'footer.sections']);

        return view('lego::sectionables.show', ['sectionable' => $course]);
    }

    public function editor(Request $request, Course $course, $editorView = 'editor')
    {
        $course->load('sections');

        return view('lego::editor.editor', [
            'sectionable' => $course,
            'editorView' => $editorView,
            'layout' => $request->input('layout'),
        ]);
    }

    public function update(Request $request, $stripeCheckoutSessionId)
    {
        return $stripeCheckoutSessionId;
    }
}
