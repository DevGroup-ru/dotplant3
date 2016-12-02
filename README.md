DotPlant3 CMS
=============

Next generation of dotPlant CMS.

Installation
------------

1. Clone a project `git clone git@github.com:DevGroup-ru/dotplant3.git`
2. Go to an application directory `cd dotplant3`
3. Run an installing of composer packages `./composer.sh create-project`
4. Modify configuration files
    * Open `config/db-local.php` and set your connection parameters. It looks like;
    * Change a domain in `config/languages/Context.php` and `config/languages/Language.php` if needs;
    * Create a new domain configuration at your web server and set `webroot` as `/path/to/dotplant3/web`.
5. Run migrations `./yii migrate`
6. Run a extensions activation process `./activate.sh`
7. Open a site in you browser `http://dotplant3.dev`


**WARNING**
> Composer working dir should always be `extensions/`.
>
> Run composer with `--working-dir=extensions/`
> 
> For example: `php composer.phar --working-dir=extensions/ update -vvv`


### How to develop

Assume that your dp3 app is located at `~/git-my/dotplant3` and all other dev packages are in `~/git-my/*`, for example `~/git-my/yii2-deferred-tasks`.

1. Create `dev.composer.json` - you can use an example file
2. All local packages with `../../` to `dev.composer.json` as path repositories.
3. Run `./composer.sh update -vvv`
4. Now your vendor packages symlinks to your working dirs.

**Note:** double `../` is needed as composer working dir is `extensions/`.