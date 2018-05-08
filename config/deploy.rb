# config valid for current version and patch releases of Capistrano
lock "~> 3.10.2"

set :application, "jana"
set :repo_url, "git@github.com:muriloavila/jana.git"

set :deploy_to, "/var/www/jana"
set :scm, :git

set :log_level, :info
set :use_sudo, false
set :keep_releases, 3

set :linked_files, ["app/config/parameters.yml"]
set :linked_dirs, [fetch(:log_path), fetch(:web_path) + "/uploads"] 
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path)] 
#set :composer_install_flags, '--no-interaction --optimize-autoloader'

set :keep_releases, 5

# Symfony console commands will use this environment for execution
set :symfony_env,  "prod"

# Set this to 2 for the old directory structure
set :symfony_directory_structure, 2
# Set this to 4 if using the older SensioDistributionBundle
set :sensio_distribution_version, 4

# symfony-standard edition directories
set :app_path, "app"
set :web_path, "web"
set :var_path, "var"
set :bin_path, "bin"

# The next 3 settings are lazily evaluated from the above values, so take care
# when modifying them
set :app_config_path, "app/config"
set :log_path, "var/logs"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

# Remove app_dev.php during deployment, other files in web/ can be specified here
set :controllers_to_clear, ["app_*.php", "config.php"]

# asset management
set :assets_install_path, "web"
set :assets_install_flags,  '--symlink'

# Share files/directories between releases
set :linked_files, []
set :linked_dirs, ["var/logs"]

# Set correct permissions between releases, this is turned off by default
set :file_permissions_paths, ["var"]
set :permission_method, false

# Role filtering
set :symfony_roles, :all

set :permission_method, :acl
set :file_permissions_users, ["nginx"]
set :file_permissions_paths, ["var", "web/uploads"]
set :default_env, { path: "/usr/local/bin:$PATH" }
SSHKit.config.command_map[:composer] = "~/bin/composer"
after 'deploy:updated', 'symfony:assets:install'
before 'deploy:updated', 'symfony:build_bootstrap'


namespace :deploy do
  task :migrate do
    symfony_console('doctrine:migrations:migrate', '--no-interaction')
  end
end
