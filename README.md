# nummer.se

## INSTALL DEPENDENCIES

Install Vagrant & Virtual box 
  See https://www.vagrantup.com

Install the vagrant plugin 'hostupdater'
`vagrant plugin install vagrant-hostsupdater`

For Capistrano:

 - Install Capistrano: http://capistranorb.com/documentation/getting-started/installation/
 - Install Capistrano + Composer plugin: https://github.com/capistrano/composer/
 
(  Now you should be able to deploy your stuff with 'cap staging deploy' \o/ )


## INITIAL SETUP
 
 Checkout this repo 
 
 `git clone git@github.com:bolstad/wp_project_template.se.git`

 `cd wp_project_template/`

 Initialize & provision vagrant box 
 
 `vagrant up`

 Ssh into box and do initial composer install 

 `vagrant ssh`

 `cd /vagrant/`

 `composer install`

 Create a .env with database settings 

 `cp .env-example .env`
  
 Setup new new site at http://dev.wpprojecttemplate.se/

## PHPMYADMIN 

 Can be found at http://dev.wpprojecttemplate.se:81/



## Deploy

### Setup

  - Edit `config/deploy.rb` and enter production repository (`:repo_url`) and application name (`:application`)
  - Edit `config/deploy/staging.rb` and enter server (`server`) and username (`user`) on row 4, also setup the
    capistrano base path on your stage server with `:deploy_to`
  - Edit `config/deploy/production.rb` and enter server (`server`) and username (`user`) on row 12, also setup the
    capistrano base path on your production server with `:deploy_to`
  - Deploy along with `cap staging deploy`, `cap staging rollback` etc



