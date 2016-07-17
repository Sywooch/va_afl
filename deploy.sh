#!/bin/bash

if [[ -d .git ]]; then
    
else
    git init
    git remote add origin $1
fi

git reset —hard
git pull origin $2

composer install
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer update