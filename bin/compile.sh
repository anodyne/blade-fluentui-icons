#!/usr/bin/env bash

set -euo pipefail

ROOT=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
DIRECTORY=$(cd "${1:?Usage: compile.sh <assets-directory>}" && pwd)
RESOURCES="$ROOT/resources/svg"

if [[ ! -x "$ROOT/node_modules/.bin/svgo" ]]; then
    echo "SVGO is missing. Run bun install --frozen-lockfile before compiling icons." >&2
    exit 1
fi

mkdir -p "$RESOURCES"
shopt -s nullglob

echo "Compiling icons..."

for file in "$DIRECTORY"/*/SVG/*; do
    filename=${file##*/}

    if [[ "$filename" =~ ^ic_fluent_(.+)_20_(regular|filled)\.svg$ ]]; then
        name=${BASH_REMATCH[1]//_/-}
        variant=${BASH_REMATCH[2]}
        prefix=o
        if [[ "$variant" == filled ]]; then
            prefix=f
        fi

        sed -e 's/ width="20" height="20"//g;s/#212121/currentColor/g' "$file" > "$RESOURCES/$prefix-$name.svg"
    fi
done

echo "Optimizing icons..."
bun run --cwd "$ROOT" optimize-icons

echo "Generating icon enum..."
bun "$ROOT/bin/generate-enum.mjs"

echo "All done!"
