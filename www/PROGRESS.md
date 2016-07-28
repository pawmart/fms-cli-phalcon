Task Progress Record
----

- Been long time since i played with Vagrant last time (and never tried Phalcon, so this is going to be an interesting experience).
- Searched for vagrant config with phalcon and php7 pre-configured (https://gist.github.com/Lewiscowles1986/4928f7dd04c599b64ba041fd7334f9c3)
- Installed the box with no problems and pulled task interfaces in
- Initiated GIT repository (including vagrant files)
- Time for phalcon framework, lets see what's out there via composer...
- Looks like vagrant wasn't really configured properly (by default), lets look into this 
- Reconfigured to have phalcon extension available and installed phalcon tools via composer
- yey, it works. Looks like i need a project now "vendor/bin/phalcon.php project fms simple ."
- Command interface looks like symfony app/console but very simplified
- OK... replace simple project with cli ;)