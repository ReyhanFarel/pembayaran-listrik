<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $adminLevel = Level::factory()->create(['id' => 1, 'nama_level' => 'admin']);
        $this->admin = User::factory()->create(['level_id' => $adminLevel->id]);
    }

    public function test_admin_can_view_users_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200)->assertViewIs('admin.user.index');
    }

    public function test_admin_can_access_create_user_form()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.create'));
        $response->assertStatus(200)->assertViewIs('admin.user.create');
    }

    public function test_admin_can_store_new_user()
    {
        $level = Level::factory()->create();

        $data = [
            'nama_user' => 'Petugas Baru',
            'username' => 'petugas123',
            'password' => 'secret123',
            'level_id' => $level->id,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $data);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'username' => 'petugas123',
            'level_id' => $level->id,
        ]);
    }

    public function test_admin_can_edit_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.users.edit', $user));
        $response->assertStatus(200)->assertViewIs('admin.user.edit');
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'nama_user' => 'Updated Name',
            'username' => 'updateduser',
            'level_id' => $user->level_id,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'updateduser',
        ]);
    }

    public function test_admin_can_update_user_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), [
            'nama_user' => 'User Name',
            'username' => $user->username,
            'level_id' => $user->level_id,
            'password' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_self()
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_cannot_delete_last_admin()
{
    // Hapus admin awal (agar benar-benar hanya 1 admin tersisa)
    $this->admin->delete();

    $lastAdmin = User::factory()->create(['level_id' => 1]);

    $response = $this
        ->actingAs($lastAdmin)
        ->from('/admin/users') // agar back() bekerja
        ->delete(route('admin.users.destroy', $lastAdmin));

    $response->assertRedirect('/admin/users');
    $response->assertSessionHas('error', 'Tidak dapat menghapus admin terakhir. Setidaknya harus ada satu akun admin.');

    $this->assertDatabaseHas('users', ['id' => $lastAdmin->id]);
}

}
