########################
#Setup project
########################
set :application, "jana"
set :repo_url, "https://github.com/muriloavila/jana.git"
set :scm, :git

#########################
#Setup Capistrano
#########################
set :log_level, :info
set :use_sudo, false
set :pty, true
set :ssh_options, {forward_agent: true, auth_methods: %w[publickey], keys: %w[~/.ssh/jana_key.pem]}
set :keep_releases, 3

#######################################
#Linked files and directories (symlinks)
#######################################
set :linked_files, ["app/config/parameters.yml"]
set :linked_dirs, [fetch(:log_path), fetch(:web_path) + "/uploads"] 
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path)] 
set :composer_install_flags, '--no-interaction --optimize-autoloader'

namespace :deploy do
  after :updated, 'composer:install_executable'
end
