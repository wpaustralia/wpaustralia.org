# wpaustralia.org

The WP Australia site [http://wpaustralia.org/]([http://wpaustralia.org/).

### Installation

We've created a script that automatically sets up a local development server using [Chassis](http://docs.chassis.io/en/latest/).

You can get up and running by doing the following:
1. Open Terminal.
2. Change directories into the folder where you would like to download the project. e.g. `cd /Volumes/Sites`
3. Run the following command: `curl -L https://git.io/vxWPG | sh`
4. Wait patiently while the script downloads and sets up the appropriate software.
5. If all goes well a browser should open [http://wpaustralia.local](http://wpaustralia.local)
6. You can login to the site by visiting: `http://wpaustralia.local/wp/wp-admin/`(http://wpaustralia.local/wp/wp-admin/). Username: `admin` Password: `password`

### Development Tools

We have bundled a few Chassis Extensions to assist with development. We've included the following extensions:
* [Xdebug](https://github.com/Chassis/Xdebug) - This extensions automatically sets up the Xdebug php module for you.
* [Mailhog](https://github.com/Chassis/mailhog) - This extension setup Mailhog which catches all the email WordPress sends. You can see the dashboard for it by visiting. [http://wpaustralia.local:8025/]
 * [Sequel Pro](https://github.com/Chassis/sequelpro) - This extensions allows you to run `vagrant sequel` from the command line and it will generate a `.spf` file and open the mySQL database in [Sequel Pro](https://www.sequelpro.com/).
* [Database Backup](https://github.com/Chassis/db-backup/) - This extension will prompt you to backup your database if you run `vagrant destroy` from the command line.
* [Fish](https://github.com/Chassis/Fish/) - This extension replaces Bash shell with [Fish](https://fishshell.com/) shell.

## Useful commands

* `vagrant up` - Run this from the `wpaustralia` directory you downloaded and installed this project. e.g. `cd /Volumes/Sites/wpaustralia; vagrant up` then browse to [http://wpaustralia.local](http://wpaustralia.local)
* `vagrant halt` - Run this when you have finished development to shutdown the Vagrant Virtual Machine. e.g. `cd /Volumes/Sites/wpaustralia; vagrant halt`
* `vagrant destroy` - Run this if you wish to destory the Vagrant Virtual Machine.
* `vagrant provison` - Run this if you have added an additional Chassis extension or if you are [disabling](http://docs.chassis.io/en/latest/config/#extensions) one of the Chassis extensions.

### Development Process

If you're new to git, here are a few steps to help you get started:

* Ensure you're in the on the `development` branch. `git checkout development`
* Ensure this branch is up to date. `git pull`
* Create a new branch `git checkout -b issue-number-name-of-feature`
* Add your files.  `git add .` or if you've changed a lot of files use `git add -p` to be prompted about small chunks of code.
* Commit your files. `git commit -m "Adds name of feature`
* Push the branch to Github. `git push`
* Submit a new pull request to the team and request a review.
