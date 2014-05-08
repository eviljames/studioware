# Backup the old XFCE menu file, just in case, but don't clobber
# if we already have Studioware in it.

if [ -z "$(grep Studioware etc/xdg/menus/xfce-applications.menu)" ]; then
    mv etc/xdg/menus/xfce-applications.menu \
        etc/xdg/menus/xfce-applications.menu.orig
fi

# Move our XFCE menu into place
mv etc/xdg/menus/xfce-applications.menu.new \
    etc/xdg/menus/xfce-applications.menu

# Backup the old KDE menu file, just in case, but don't clobber
# if we already have Studioware in it.

if [ -z "$(grep Studioware etc/kde/xdg/menus/applications.menu)" ]; then
    mv etc/kde/xdg/menus/applications.menu \
        etc/kde/xdg/menus/applications.menu.orig
fi

# Move our KDE menu into place
mv etc/kde/xdg/menus/applications.menu.new \
    etc/kde/xdg/menus/applications.menu

# Test to see if we are actually using xfdesktop and reload it
if [ -n "$(pgrep xfdesktop)" ]; then
    /usr/bin/xfdesktop --reload >/dev/null 2>&1
fi
