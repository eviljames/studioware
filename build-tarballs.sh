#!/bin/sh
# Quick and dirty script to build all the tarballs.

CWD=$(pwd)
PKGDIR=${PKGDIR:-$CWD}

for SB in $( find $PKGDIR -name '*.SlackBuild' -type f); do
    DIR=$(echo $SB | rev | cut -d/ -f2- | rev | sed "s#$PKGDIR/##")
    PKG=$(echo $DIR | rev | cut -d/ -f1 | rev)
    PARENT=$(echo $DIR | rev | cut -d/ -f2- | rev)
    
    #echo $DIR
    #echo $PKG
    #echo $PARENT
    
    mkdir -vp $CWD/tarballs/$PARENT
    rm -vf $CWD/tarballs/$PARENT/$PKG.tar.gz
    (
        cd $PKGDIR/$PARENT
        tar -czvf $CWD/tarballs/$PARENT/$PKG.tar.gz $PKG
    )
done