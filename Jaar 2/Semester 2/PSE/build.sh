#! /usr/bin/env bash
set -e

exec_in() {
    OLDDIR=$(pwd)
    cd "$1"
    shift 1
    $*
    cd "$OLDDIR"
}


build_project() {
    [ -d "front_end/dist" ] && rm -r "front_end/dist"
    [ -d "front_end/build" ] && rm -r "front_end/build"

    exec_in "front_end" npm install
    exec_in "front_end" npm run build
    exec_in "back_end" ./gradlew installDist
}

build_project