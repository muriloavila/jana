#######################
#Setup Server
########################
server "ec2-18-191-54-140.us-east-2.compute.amazonaws.com", user: "ubuntu", roles: %w{web}
set :deploy_to, "/var/www/jana"

#########################
#Capistrano Symfony
#########################
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"

#########################
#Setup Git
#########################
set :branch, "master"
