<?php
namespace Deployer;

// Project name
set('application', 'baby-record');

// Project repository
set('repository', 'ssh://git@redmine.nvb-online.com/baby-memo/gl-baby-record.git');

// Shared files/dirs between deploys
set('shared_files', [
    'backend/config/.env',
    'frontend/.env',
]);
set('shared_dirs', [
    'backend/logs',
]);

// Writable dirs by web server
set('writable_dirs', [
    'backend/logs',
    'backend/tmp',
]);
set('writable_mode', 'chown');
set('writable_use_sudo', true);

set('backend_dir', 'backend');
set('frontend_dir', 'frontend');

// Configure composer
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader -d {{backend_dir}}');

// Hosts
host('pro-1')
    ->hostname('nvb-online.com')
    ->stage('pro')
    ->user('ec2-user')
    ->identityFile('~/.ssh/private_keys/ec2-virginia-ec2-user.pem')
    ->set('http_user', 'webuser')
    ->set('deploy_path', '/var/www/html/_baby-record');
