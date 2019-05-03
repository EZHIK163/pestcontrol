#!/usr/bin/env bash

REMOTE_BRANCH=`git branch | grep '^\*' | cut -d' ' -f2`

echo -e "pushing to \033[0;32m$REMOTE_BRANCH\033[0m"

echo -e "\033[1;33mrun check code style\033[0m"
make php-cs-fix-dry

echo -e "\033[1;33mrun tests\033[0m"
make codecept