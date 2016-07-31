Task Progress Record
----

#### Environment Setup

Been long time since i played with Vagrant last time (and never tried Phalcon, so this is going to be an interesting experience).

	- Searched for vagrant config with phalcon and php7 pre-configured (https://gist.github.com/Lewiscowles1986/4928f7dd04c599b64ba041fd7334f9c3)
	- Setting up vagrant and correct php extensions. Lets go for sqlite so its easy to attach for testing.
	- Installed the box with no problems and pulled task interfaces in.
	- Initiated GIT repository (including vagrant files)

----

#### Framework Configuration

Time for phalcon framework, lets see what's out there via composer... and what docs do we have for the framework itself.

	- Looks like vagrant wasn't really configured properly (by default), lets look into this 
	- Reconfigured to have phalcon extension available and installed phalcon tools via composer
	- yey, it works. Looks like i need a project now "vendor/bin/phalcon.php project fms simple ."
	- Command interface looks like zend1 console ;)
	- OK... replace simple project with cli one
	- Looks like vagrant required even more configuration and addition of sqlite too

----

#### Let's write some code 

After some time spend for additional configuration, its time to start setting up application and models.

	- Lets try to provide skeleton for filesystem classes
	- Actually before we do this lets get behat up and running (vagrant vm behat extension dependency missing php7.0-mbstring)
	- And lets create initial db schema using the task
	- Now time for models creation based on created db schema (using phalcon command tools)
	- Wow, phalcon db! I hate you so far ;) What is this repository, entity, model, dto? All at once with access to DI?!
	- Model classes and provide adapter, so filesystem can be configured with different adapter in the future
	- Lets write some behat features so we can write our cli scripts and test them

So far I probably don't understand Phalcon intentions, but there is totally different appraoch to what i call 'model'. 
There is not clear separation (at least by default) between entities and model and persistance layer, and DI available everywhere.

I have made some decisions I am not externally proud of so far. Mainly due to default application setup. Very tight coupling between framework and business application logic. 

Next time I would probably create a composer library and bundle integration with that library. 

	- Based on behat scenarios, lets write our console tasks...

----

Time tracking summary
----

- Friday Evening
- Saturday on and off aprox 6h
- Sunday 3h