# Backup the old menu file, just in case, but don't clobber
# if we already have Studioware in it.

if [ -z "$(grep Studioware etc/xdg/menus/xfce-applications.menu)" ]; then
    mv etc/xdg/menus/xfce-applications.menu \
        etc/xdg/menus/xfce-applications.menu.orig
fi

mv etc/xdg/menus/xfce-applications.menu.new \
    etc/xdg/menus/xfce-applications.menu
