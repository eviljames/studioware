#!/bin/sh

cats="
amps/
desktop/
development/
drums/
editors/
effects/
graphics/
libraries/
misc/
mixers/
multitrack/
plugins/
recorders/
samplers/
sequencers/
synthesizers/
system/"

for i in $cats
do
    cd $i >/dev/null
    find . -type d | while read app
    do
        if [ "$app" != "." ]; then
            mv $app.tar.gz $app
        fi
    done
    cd - >/dev/null
done
