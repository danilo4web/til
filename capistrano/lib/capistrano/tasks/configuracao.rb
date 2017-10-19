namespace :configuracao do
  desc "Criando Link simbolico"
  task :create_symlink do
    on roles(:web) do
        info "======= Criando Link simbolico ========="
        execute "ln -nfs /var/www/vhosts/PROJECT_NAME/projeto/current/app/webroot/* /var/www/vhosts/PROJECT_NAME/htdocs/"
        execute "ln -nfs /var/www/vhosts/PROJECT_NAME/projeto/current/app/webroot/.htaccess /var/www/vhosts/PROJECT_NAME/htdocs/"
    end
  end
  
  desc "Criando diretorio TMP"
  task :create_tmp do
    on roles(:web) do
        info "======= Criando diretorio TMP =========="
        execute "test -L /var/www/vhosts/PROJECT_NAME/htdocs/tmp || sudo rm -fr /var/www/vhosts/PROJECT_NAME/htdocs/tmp"
        execute "test -d /var/www/vhosts/PROJECT_NAME/htdocs/tmp/logs || mkdir -p /var/www/vhosts/PROJECT_NAME/htdocs/tmp/logs"
        execute "test -d /var/www/vhosts/PROJECT_NAME/htdocs/tmp/cache || mkdir -p /var/www/vhosts/PROJECT_NAME/htdocs/tmp/cache"
        # execute "test -d /var/www/vhosts/PROJECT_NAME/htdocs/tmp/session || mkdir -p /var/www/vhosts/PROJECT_NAME/htdocs/tmp/session"
        execute "chmod 777 /var/www/vhosts/PROJECT_NAME/htdocs/tmp -Rfv"
    end
  end  
end