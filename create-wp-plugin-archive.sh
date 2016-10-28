#!/bin/sh

# Zip Ecovillage Sieben Linden Event Wordpress Plugin

set -e

# See https://github.com/ecovillage/ev7l-events/issues/1
#if [ -n "$(git status --porcelain ev7l-events)" ]; then
#  echo "You have local changes, cannot build release zip file.";
#  exit 1
#else
#  echo "Building zip file";
#fi

cd ev7l-events && zip -r ../ev7l-events-`git describe --abbrev=0`.zip .
