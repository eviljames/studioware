#!/bin/sh

# Takes a list of apps named CHECKLIST in the form of /category/appname
# ./getdeps.sh
# or will take a single argument:
# ./getdeps.sh rosegarden
# 
# Note that it is designed to run in a chroot, or as root user, but the
# paths can be changed to allow normal user.


REPO=/root/git/14.0/
QUEUEDIR=/root/studioware.org/queues
mkdir -p $QUEUEDIR
APP=$1
DEPS="dummy"
PKG="dummy"

getdeps()
{
    source $REPO/*/$1/$1.info

    if [ -n "$REQUIRES" ]; then
        for dep in $REQUIRES
        do
            echo $dep 
            [[ -r ${PKG}.tmp ]] && sed -i "/^$dep$/d" ${PKG}.tmp
            echo $dep >> ${PKG}.tmp
            getdeps $dep
        done
    fi
}

if [ -z "$APP" ]; then
    for PKG in `cat CHECKLIST | sed 's/\/$//g; s/^.*\///g'`
    do
        source $REPO/*/$PKG/$PKG.info

        if [ -n "$REQUIRES" ]; then
            getdeps $PKG
        fi
    done
else
    source $REPO/*/$APP/$APP.info
    DEPS=${APP}.tmp
    PKG=$APP

    if [ -n "$REQUIRES" ]; then
        echo -n > ${APP}.tmp

        for dep in $REQUIRES
        do
            sed -i "/^$dep$/d" $DEPS && echo $dep
            echo $dep >> $DEPS
            getdeps $dep
        done
    else
        exit
    fi
    
    tac $DEPS > $QUEUEDIR/${APP}.queue
    rm -f $DEPS
    exit 
fi

for q in *.tmp
do
    tac $q > $QUEUEDIR/$(basename $q .tmp).queue
    rm -f $q
done

