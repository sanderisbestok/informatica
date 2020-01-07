#! /usr/bin/env bash
set -e

BUILD_DIRECTORY="./back_end/build/install/back_end"
INSTALL_DIRECTORY="/usr/share/cbook"
SYMLINK_FILE="/usr/bin/cbook"

exec_in() {
    OLDDIR=$(pwd)
    cd "$1"
    shift 1
    $*
    cd "$OLDDIR"
}

mkdir_if_not_exists() {
    if [ ! -d "$1" ]; then
        mkdir "$1"
    fi
}

mkdir_if_not_exists "$INSTALL_DIRECTORY"
mkdir_if_not_exists "$INSTALL_DIRECTORY/bin"
mkdir_if_not_exists "$INSTALL_DIRECTORY/lib"

mv "$BUILD_DIRECTORY/bin/back_end" "$INSTALL_DIRECTORY/bin/cbook"
mv "$BUILD_DIRECTORY"/lib/*.jar "$INSTALL_DIRECTORY/lib/"
ln -s "$INSTALL_DIRECTORY/bin/cbook" "$SYMLINK_FILE"

echo "Successfully installed CBook in $INSTALL_DIRECTORY"
