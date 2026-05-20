<?php

use App\Models\LearningLog;
use App\Models\Material;
use App\Models\SubMaterial;
use App\Models\User;

test('student can start a learning log', function () {
    $teacher = User::factory()->create(['id_role' => 2, 'is_verified' => true]);
    $student = User::factory()->create(['id_role' => 1]);
    $material = Material::create([
        'material_title' => 'Test Material',
        'material_image' => null,
        'description'    => 'Desc',
        'id_teacher'     => $teacher->id,
    ]);
    $sub = SubMaterial::create([
        'id_material'   => $material->id,
        'title'         => 'Sub 1',
        'description'   => 'Desc',
        'file_material' => null,
        'file_pdf'      => null,
    ]);

    $response = $this->actingAs($student)->postJson('/learning-log/start', [
        'id_sub_material' => $sub->id,
        'id_material'     => $material->id,
    ]);

    $response->assertOk()->assertJsonStructure(['log_id']);
    expect(LearningLog::count())->toBe(1);
    expect(LearningLog::first()->id_user)->toBe($student->id);
});

test('student can end a learning log', function () {
    $student = User::factory()->create(['id_role' => 1]);
    $teacher = User::factory()->create(['id_role' => 2]);
    $material = Material::create([
        'material_title' => 'Test',
        'material_image' => null,
        'description'    => 'D',
        'id_teacher'     => $teacher->id,
    ]);
    $sub = SubMaterial::create([
        'id_material'   => $material->id,
        'title'         => 'S',
        'description'   => 'D',
        'file_material' => null,
        'file_pdf'      => null,
    ]);

    $log = LearningLog::create([
        'id_user'         => $student->id,
        'id_sub_material' => $sub->id,
        'id_material'     => $material->id,
        'started_at'      => now()->subMinutes(5),
    ]);

    $response = $this->actingAs($student)->postJson('/learning-log/end', [
        'log_id' => $log->id,
    ]);

    $response->assertOk()->assertJson(['ok' => true]);
    $log->refresh();
    expect($log->ended_at)->not->toBeNull();
    expect($log->duration)->toBeGreaterThan(0);
});

test('unauthenticated user cannot start a log', function () {
    $response = $this->postJson('/learning-log/start', [
        'id_sub_material' => 1,
        'id_material'     => 1,
    ]);
    $response->assertStatus(401);
});
