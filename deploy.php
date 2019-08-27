<?php
namespace Deployer;

require 'recipe/common.php';
require './config.php';

/**
 * Create plugins' symlinks
 */
task('deploy:init', function () {
    run('{{release_path}}/{{backend_dir}}/bin/cake plugin assets symlink');
})->desc('Initialization');

/**
 * Run migrations
 */
task('deploy:run_migrations', function () {
    run('{{release_path}}/{{backend_dir}}/bin/cake migrations migrate');
    run('{{release_path}}/{{backend_dir}}/bin/cake orm_cache clear');
    run('{{release_path}}/{{backend_dir}}/bin/cake orm_cache build');
})->desc('Run migrations');

/**
 * Run npm installation and building
 */
task('deploy:npm_build', function () {
    run('cd {{release_path}}/{{frontend_dir}} && npm install');
    run('cd {{release_path}}/{{frontend_dir}} && npm run build');
})->desc('Run npm installation and building');

/**
 * Restart php-fpm to clear cache
 */
task('deploy:restart-php-fpm', function () {
    run ('sudo service php-fpm restart');
})->desc('Restart php-fpm to clear cache');

/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:init',
    'deploy:copy_dirs',
    'deploy:shared',
    'deploy:run_migrations',
    'deploy:npm_build',
    'deploy:writable',
    'deploy:symlink',
    'deploy:restart-php-fpm',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');
after('deploy:failed', 'deploy:unlock');
