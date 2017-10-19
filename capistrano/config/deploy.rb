# config valid only for current version of Capistrano
lock "3.8.1"

set :application, "REPOSIPORY"
set :repo_url, "git@bitbucket.org:OWNER/REPOSIPORY.git"

# Default deploy_to directory
set :deploy_to, "/var/www/vhosts/PROJECT_NAME/projeto"

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml", "config/secrets.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 5

# Executar apos Upload do Projeto
after :deploy, "configuracao:create_symlink"
after :deploy, "configuracao:create_tmp"