<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    function registration_page_contains_livewire_component()
    {
        if (! Route::has('register')) {
            $this->assertTrue(true);

            return;
        }

        $this->get(route('register'))
            ->assertSuccessful()
            ->assertSeeLivewire('auth.register');
    }

    #[Test]
    public function is_redirected_if_already_logged_in()
    {
        if (! Route::has('register')) {
            $this->assertTrue(true);

            return;
        }

        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('register'))
            ->assertRedirect(route('home'));
    }

    #[Test]
    public function a_user_can_register()
    {
        Event::fake();

        Livewire::test('auth.register')
            ->set('name', 'Tall Stack')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertRedirect(route('home'));

        $this->assertTrue(User::whereEmail('tallstack@example.com')->exists());
        $this->assertEquals('tallstack@example.com', Auth::user()->email);

        Event::assertDispatched(Registered::class);
    }

    #[Test]
    public function name_is_required()
    {
        Livewire::test('auth.register')
            ->set('name', '')
            ->call('register')
            ->assertHasErrors(['name' => 'required']);
    }

    #[Test]
    public function email_is_required()
    {
        Livewire::test('auth.register')
            ->set('email', '')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    #[Test]
    public function email_is_valid_email()
    {
        Livewire::test('auth.register')
            ->set('email', 'tallstack')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    #[Test]
    public function email_hasnt_been_taken_already()
    {
        User::factory()->create(['email' => 'tallstack@example.com']);

        Livewire::test('auth.register')
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    #[Test]
    function see_email_hasnt_already_been_taken_validation_message_as_user_types()
    {
        User::factory()->create(['email' => 'tallstack@example.com']);

        Livewire::test('auth.register')
            ->set('email', 'smallstack@gmail.com')
            ->assertHasNoErrors()
            ->set('email', 'tallstack@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    #[Test]
    public function password_is_required()
    {
        Livewire::test('auth.register')
            ->set('password', '')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    #[Test]
    function password_is_minimum_of_eight_characters()
    {
        Livewire::test('auth.register')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    #[Test]
    function password_matches_password_confirmation()
    {
        Livewire::test('auth.register')
            ->set('email', 'tallstack@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'not-password')
            ->call('register')
            ->assertHasErrors(['password' => 'same']);
    }
}
