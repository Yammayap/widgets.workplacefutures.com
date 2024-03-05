<?php
namespace Deployer;

require 'recipe/common.php';
require 'contrib/rsync.php';

/**
 * CONFIG
 */
set('allow_anonymous_stats', false);

set('application', 'widgets.workplacefutures.com');
set('repository', 'git@github.com:Yammayap/widgets.workplacefutures.com.git');
set('keep_releases', 5);

set('git_tty', true);
set('ssh_multiplexing', false);

set('writable_mode', 'chown');
set('writable_chmod_mode', '0750');
set('writable_recursive', true);

set('rsync',[
    'exclude'       => [
        '/.git/',
        '/.github/',
        '/node_modules/',
        '/storage/',
        '/vendor/',
        '/.env',
        '/.env.example',
        '/deploy.php',
        '/deployer.phar',
    ],
    'exclude-file' => false,
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 60,
]);
set('rsync_src', __DIR__);
set('rsync_dest','{{release_path}}');

add('shared_dirs', [
    'storage',
]);
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

/**
 * HOSTS
 */
// PRODUCTION
host('3.9.105.36')
    ->set('labels', [
        'env'   => 'production',
        'role'  => 'web',
    ])
    ->set('remote_user', 'wfg')
    ->set('http_user', 'wfg')
    ->set('deploy_path', '/var/www/widgets.workplacefutures.com');

// TEST
host('18.132.44.67')
    ->set('labels', [
        'env'   => 'test',
        'role'  => 'web',
    ])
    ->set('remote_user', 'wfg')
    ->set('http_user', 'wfg')
    ->set('deploy_path', '/var/www/test.widgets.workplacefutures.com');

/**
 * TASKS
 */
desc('Create .env from GitHub Secrets');
task('deploy:yammayap:dot-env', function () {
    file_put_contents(__DIR__ . '/deploy.env', getenv('DOT_ENV'));
    upload(__DIR__ . '/deploy.env', get('release_path') . '/.env');
});

desc('Create storage symlinks');
task('deploy:yammayap:storage-link', function () {
    run('{{bin/php}} {{release_path}}/artisan storage:link');
});

desc('Run Laravel optimizations');
task('deploy:yammayap:laravel-optimize', function () {
    run('{{bin/php}} {{release_path}}/artisan config:cache');
    run('{{bin/php}} {{release_path}}/artisan route:cache');
    run('{{bin/php}} {{release_path}}/artisan view:cache');
});

desc('Execute database migrations');
task('deploy:yammayap:db-migrate', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate --force');
});

desc('Restart Horizon (queues)');
task('deploy:yammayap:restart-horizon', function () {
    run('{{bin/php}} {{release_path}}/artisan horizon:terminate');
});

/**
 * RUN!
 */
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:yammayap:dot-env',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:yammayap:storage-link',
    'deploy:yammayap:laravel-optimize',
    'deploy:yammayap:db-migrate',
    'deploy:symlink',
    'deploy:yammayap:restart-horizon',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success',
]);

/**
 * HOOKS
 */
after('deploy:failed', 'deploy:unlock');
