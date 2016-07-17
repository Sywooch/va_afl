#!/bin/bash

if [[ -d .git ]]; then
    echo ".git folder exist"
else
    echo "init git"
    git init
    git remote add origin $1
fi

echo "get repo"
git reset —hard
git pull origin $2

echo "composers tasks"
composer install
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer update