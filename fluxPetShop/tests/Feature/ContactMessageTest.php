<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_contact_message_is_saved_and_confirmation_is_shown(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jamie Santos',
            'email' => 'jamie@example.com',
            'subject' => 'Product question',
            'message' => 'Can you tell me more about this product?',
        ]);

        $response->assertRedirect(route('contact.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jamie Santos',
            'email' => 'jamie@example.com',
            'subject' => 'Product question',
            'message' => 'Can you tell me more about this product?',
            'status' => 'new',
        ]);

        $this->assertSame(1, ContactMessage::count());
    }

    public function test_invalid_contact_message_is_not_saved(): void
    {
        $response = $this->from(route('contact.create'))
            ->post(route('contact.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'subject' => '',
                'message' => 'short',
            ]);

        $response->assertRedirect(route('contact.create'));
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }
}
