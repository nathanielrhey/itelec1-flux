<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /** Show the contact form. */
    public function create(): View
    {
        return view('contact.create');
    }

    /** Validate and save the message, then redirect with a flash. */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return redirect()
            ->route('contact.create')
            ->with('success', 'Thank you, ' . $request->input('name') . '! Your message has been sent. We\'ll get back to you soon.');
    }
}
