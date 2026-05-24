<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_question
 * @property string $choices
 * @property int $correctAnswer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Question|null $question
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereChoices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereCorrectAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereIdQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Answer whereUpdatedAt($value)
 */
	class Answer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $material_title
 * @property string|null $material_image
 * @property string $description
 * @property int|null $id_teacher
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $userTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereIdTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereMaterialImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereMaterialTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereUpdatedAt($value)
 */
	class Material extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_user
 * @property int|null $id_material
 * @property string|null $joined_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereIdMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialUser whereUpdatedAt($value)
 */
	class MaterialUser extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_material
 * @property string $question
 * @property int|null $score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Answer> $answers
 * @property-read int|null $answers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereIdMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUpdatedAt($value)
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_material
 * @property int|null $id_user
 * @property int|null $totalQuestion
 * @property int|null $correctAnswers
 * @property int|null $score
 * @property array<array-key, mixed>|null $questions
 * @property array<array-key, mixed>|null $resultAnswers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereCorrectAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereIdMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereResultAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereTotalQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultQuiz whereUpdatedAt($value)
 */
	class ResultQuiz extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_material
 * @property string $title
 * @property string|null $description
 * @property string|null $file_material
 * @property string|null $file_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereFileMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereFilePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereIdMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubMaterial whereUpdatedAt($value)
 */
	class SubMaterial extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempQuiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempQuiz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempQuiz query()
 */
	class TempQuiz extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $id_role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_verified
 * @property int|null $nip
 * @property string|null $image_profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MaterialUser> $classes
 * @property-read int|null $classes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Material> $material
 * @property-read int|null $material_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImageProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

