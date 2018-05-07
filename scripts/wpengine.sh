#!/usr/bin/env bash

# Deploy a bedrock like WP setup to WPEngine
# based on https://github.com/schrapel/wpengine-bedrock-build/blob/master/wpengine.sh

output () {
  bold=$(tput bold)
  normal=$(tput sgr0)
  echo "${bold}=====> $1${normal}"
}

if [ ! -d "web" ]
then
  output "Please run this script from the root directory."
  exit
fi

if [[ -n $(git status -s) ]]
then
  output "Please review and commit your changes before continuing."
  exit
fi

# Create a wpengine branch
exists=`git show-ref refs/heads/wpengine`
if [ -n "$exists" ]
then
  git branch -D wpengine
fi
git checkout -b wpengine

output "Installing dependencies"

# Make sure all plugins are installed
composer update --quiet
composer install --quiet

output "Dependencies installed"

# Create WP directories and move relevant directories from web/app
mkdir wp-content
mv web/app/plugins wp-content
mv web/app/themes wp-content

output "Rearranging project structure, applying to git and pushing"

# Remove files we overwrite with wpengine specific files
rm .gitignore

# and copy our specific ones
cp wpengine/.gitignore .gitignore
cp wpengine/.htaccess .htaccess

# Clear git cache base on new .gitignore
git ls-files | xargs git rm --cached --quiet

# Commit and push
git add .
git commit -am "WP Engine build from: $(git log -1 HEAD --pretty=format:%s)$(git rev-parse --short HEAD 2> /dev/null | sed "s/\(.*\)/@\1/")" --quiet
git push wpengine wpengine:master --force
git checkout master
output "Successfully deployed"

# Cleanup
git branch -D wpengine
rm -rf wp-content
git fetch
output "Done"
