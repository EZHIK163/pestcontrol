#!/usr/bin/env bash

COMMITER=`git config user.name`
LOCAL_BRANCH=`git branch | grep \* | cut -d ' ' -f2`
echo -e "committing as \033[0;32m$COMMITER\033[0m to \033[0;32m$LOCAL_BRANCH\033[0m"

CHANGED_FILES=`git diff --cached --name-only --diff-filter=ACM | grep "\.php" | tr '\r\n' ' '`

if [[ $CHANGED_FILES ]]; then
    echo -e "\033[1;33mrun code style fixer\033[0m"
    make php-cs-fix files="$CHANGED_FILES"

    echo -e "\033[1;33madd fixed files\033[0m"
    git add $CHANGED_FILES
fi