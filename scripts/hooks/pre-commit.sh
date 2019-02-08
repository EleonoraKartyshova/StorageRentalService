#!/bin/sh

PROJECT=`php -r "echo dirname(dirname(dirname(realpath('$0'))));"`
STAGED_FILES_CMD=`git diff --cached --name-only --diff-filter=ACMR HEAD | grep \\\\.php`

# Determine if a file list is passed
if [ "$#" -eq 1 ]
then
    oIFS=$IFS
    IFS='
    '
    SFILES="$1"
    IFS=$oIFS
fi
SFILES=${SFILES:-$STAGED_FILES_CMD}

echo "Checking PHP Lint..."
for FILE in $SFILES
do
    php -l -d display_errors=0 $PROJECT/$FILE
    if [ $? != 0 ]
    then
        echo "Please fix the error before commit."
        exit 1
    fi
    FILES="$FILES $PROJECT/$FILE"
done

if [ "$FILES" != "" ]
then
    echo "Running Code Sniffer. Code standard PSR2."
    ./vendor/bin/phpcs --standard=PSR2 --colors --encoding=utf-8 -n -p $FILES
    if [ $? != 0 ]
    then
        echo "Please fix the following errors before commit!"
        exit 1
    fi
fi

exit $?
