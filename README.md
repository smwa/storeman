# Storeman

###What

Storeman is a web app that helps someone manage where they have stored stuff.

You can have locations, containers, and items. Containers can be at a location, and items can be in a location or a container.

For example I have 2 boxes*(containers)* and a chair*(item)* in storage in my mother's attic*(location)*. The first box contains comic books*(items)*, the second has my red hat*(item)* and blue hat*(item)*.

If you'd rather, you can just make items or containers without worrying about locations.

You can also print out a [QR Code](https://en.wikipedia.org/wiki/QR_code) for any items, locations, or containers by clicking the QR Code links in the app. These can be taped to whatever, and when scanned with your phone, they'll take you to the page. This works really well for storage boxes, like the hat box above, so that you can see inside them without unstacking anything on top.

###Why
Because I, like most people I'm sure, have way too much stuff, scattered among at least 3 places, with no order to the madness.

###How
Storeman is built on Angular.js, with bootstrap, jquery, and a qr library thanks to [monospaced](https://github.com/monospaced/).

For the backend, it uses PHP(>= 5.4) and MySQL for a REST based API.(Feel free to implement this, there is documentation in the docs directory)

The REST API uses a light framework I built that can be found in app/api/rest.php.
It doesn't use mod rewrite or anything similar.
It looks into the routes/ folder for files named after the route, and class names with a Route on the end.
For example, GET /api/?locations/3 will load the file routes/locations.php, with the class locationsRoute, and call the function get().

It uses an active record implementation I built that can be found at app/api/ActiveRecord.php and MysqlActiveRecord.php.
It supports defining table relations and getting all related records. It also requires a single primary key.
Examples:

* Create new user:
  * $newUser = new User();
  * $newUser->email = 'test@example.org';
  * $newUser->save();
* Find that user, and update values
  * $newUser = User::findOne(array("email" => "test@example.org"));
  * if ($newUser) {
  *   $newUser->password = 'thisShouldn\'tBeSetLikeThis';
  *   $newUser->save();
  * }
* Delete user
  * $user = User::findOne(2); //this selects user with a primary key of 2
  * if ($user) $user->delete();

Feel free to use those two libraries, or improve upon them.
Pull Requests are always welcome.

###DIY
If you'd like to get it running on your own server, there are two scripts for starting docker containers
startDB.sh and startWeb.sh.
If you clone the repo, change into the directory, and run those two scripts, it'll start the containers necessary.
You can then go to http://localhost/api/migrate.php to initiate the database. This will let you know if anything went wrong or the database can't connect.
