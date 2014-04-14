# Backup the old menu file, just in case, but don't clobber
# if we already have Studioware in it.

if [ -z "$(grep Studioware etc/kde/xdg/menus/applications.menu)" ]; then
    mv etc/kde/xdg/menus/applications.menu \
        etc/kde/xdg/menus/applications.menu.orig
fi

# Move our menu into place
mv etc/kde/xdg/menus/applications.menu.new \
    etc/kde/xdg/menus/applications.menu

# Test to see if we are actually using xfdesktop and reload it
if [ -n "$(pgrep xfdesktop)" ]; then
    /usr/bin/xfdesktop --reload
fi
