<?php

namespace Tests;

use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Providers\EventServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\Matcher\Closure;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;
    use WithFaker;

    /**
     * @param class-string $eventClass
     * @param class-string $listenerClass
     */
    protected function assertEventHasListener(string $eventClass, string $listenerClass): void
    {
        $map = new Collection((new \ReflectionClass(EventServiceProvider::class))
            ->getDefaultProperties()['listen']);

        $this->assertTrue($map->has($eventClass));
        $this->assertTrue(in_array($listenerClass, $map->get($eventClass)));
    }

    /**
     * @param \Illuminate\Support\Collection<mixed, mixed> $expected
     *
     * @return \Mockery\Matcher\Closure
     */
    protected function mockArgCollection(Collection $expected): Closure
    {
        return Mockery::on(function (Collection $arg) use ($expected): bool {
            return $arg->toArray() === $expected->toArray();
        });
    }

    /**
     * @param \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model> $expected
     *
     * @return \Mockery\Matcher\Closure
     */
    protected function mockArgCollectionOfModelIds(Collection $expected): Closure
    {
        return Mockery::on(function (Collection $arg) use ($expected): bool {
            return $arg->pluck('id')->sort()->values()->toArray() === $expected->pluck('id')->sort()->values()->toArray();
        });
    }

    /**
     * @param \Illuminate\Support\Collection $expected
     *
     * @return \Mockery\Matcher\Closure
     */
    protected function mockArgCollectionOfModels(Collection $expected): Closure
    {
        return Mockery::on(function (Collection $arg) use ($expected): bool {
            if ($arg->count() !== $expected->count()) {
                return false;
            }

            foreach ($expected as $expectedKey => $expectedModel) {
                $actualModel = $arg->get($expectedKey);
                if (!$actualModel instanceof Model) {
                    return false;
                }

                if (!$actualModel->is($expectedModel)) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Mockery\Matcher\Closure
     */
    protected function mockArgModel(Model $model): Closure
    {
        return Mockery::on(function (mixed $argument) use ($model) {
            return $argument instanceof Model && $argument->is($model);
        });
    }

    /**
     * @param User|null $user
     *
     * @return User
     */
    protected function authenticateUser(User $user = null): User
    {
        if (!$user) {
            $user = User::factory()->create();
        }

        $this->actingAs($user);

        return $user;
    }
}
