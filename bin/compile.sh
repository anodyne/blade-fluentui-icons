#!/usr/bin/env bash

set -e

DIRECTORY=$(cd $1 && pwd)
DIST=$DIRECTORY
RESOURCES=$DIRECTORY/../../../../resources/svg

echo "Compiling icons..."

for file in $DIST/*/SVG/* ;
do
    file="${file%/}";
    prefix="/Users/dvs/Code/blade-fluentui-icons/vendor/microsoft/fluentui-system-icons/assets/"

    [[ "$file" =~ ^($prefix)(.*)(ic_fluent_)(.+)(_20_regular.svg)$ ]] && sed -e 's/ width="20" height="20"//g;s/#212121/currentColor/g' "$file" > "$RESOURCES/o-$(echo ${BASH_REMATCH[4]//_/-}.svg)"

    [[ "$file" =~ ^($prefix)(.*)(ic_fluent_)(.+)(_20_filled.svg)$ ]] && sed -e 's/ width="20" height="20"//g;s/#212121/currentColor/g' "$file" > "$RESOURCES/f-$(echo ${BASH_REMATCH[4]//_/-}.svg)"
done

echo "All done!"
