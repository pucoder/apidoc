#!/bin/bash

cd $(dirname $(readlink -f $0)) && apidoc -i app/Http/Controllers -o public/apidoc/
