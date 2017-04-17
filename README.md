Yii2 Member's System
--------------------

My members system based on the Yii2 framework.

---

### Features

- Grunt asset handling (and other helpful commands to backup, reset yii, etc)
- AdminLTE theme on admin/user sections
- mainsite is the default Yii2 template improved with Grunt asset handling
- 3 separate sections: admin (backend), users (frontend), and mainsite (for your custom homepage)
- admins and users are completely separated (sessions, cookies, etc)
- database migrations (separate user and admin tables, user profile, basic user settings)
- User component to easily add to `Yii::$app->user->something`
- Extended controller ready if you need it
- and probably a few more things, so poke around the code :)

---

### Demo

You can see it here:

[http://yii2memberssystem-wadeshuler.rhcloud.com](http://yii2memberssystem-wadeshuler.rhcloud.com)

[http://yii2memberssystem-wadeshuler.rhcloud.com/members](http://yii2memberssystem-wadeshuler.rhcloud.com/members)

    username: user
    password: 123456

[http://yii2memberssystem-wadeshuler.rhcloud.com/admin](http://yii2memberssystem-wadeshuler.rhcloud.com/admin)

    username: root (also, `super` and `admin`)
    password: 123456

**Please Note:** The demo is just an example. I have "members" as a symbolic link from `/mainsite/web/members` pointing to `/frontend/web` and a symbolic link from `/mainsite/web/admin` pointing to `/backend/web`. These symbolic links are not included and are created during my OpenShift action hooks. So unless you push to OpenShift, they won't work. You will need to create your own symbolic links, or you can point sub-domains to the web directories.

I have `mainsite` as the main homepage (ie: www.site.com). Then you could create a `users` sub-domain and point it to `/frontend/web` and an `admin` sub-domain pointed to `/backend/web`.

---

### Installation

    composer create-project wadeshuler/yii2-members-system yii2-members-system

Once Composer has done it's thing, you need to run a few commands before you can play.

    composer install
    npm install
    ./init
    grunt build

Then, create the database `yii2-members-system`. If you already have a database
with that name, choose another name. Assign a user to that database. Then update  
`common/config/main-local.php` with your database information.

Now you can migrate:

    ./yii migrate

Out of the box, the paths would be like so:

    http://localhost/yii2-members-system/mainsite
    http://localhost/yii2-members-system/frontend
    http://localhost/yii2-members-system/backend

It is highly recommended to setup VHOSTS and point the domain (even if local) to
the `web` directories. I prefer to map `yii2-members-system.dev` to `mainsite/web`,
`user.yii2-members-system.dev` to `frontend/web`, and `admin.yii2-members-system.dev`
to `backend/web`. Obviously, you can use whatever domain name you want here.

Here is an example of my VHOSTS from my local XAMPP:

    <VirtualHost *:80>
        ServerName yii2-members-system.dev
        ServerAlias www.yii2-members-system.dev
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/yii2-members-system/mainsite/web"
        ErrorLog "logs/mainsite.yii2-members-system.dev-error_log"
        CustomLog "logs/mainsite.yii2-members-system.dev-access_log" common
    </VirtualHost>

    <VirtualHost *:80>
        ServerName yii2-members-system.dev
        ServerAlias users.yii2-members-system.dev
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/yii2-members-system/frontend/web"
        ErrorLog "logs/users.yii2-members-system.dev-error_log"
        CustomLog "logs/users.yii2-members-system.dev-access_log" common
    </VirtualHost>

    <VirtualHost *:80>
        ServerName yii2-members-system.dev
        ServerAlias admin.yii2-members-system.dev
        DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/yii2-members-system/backend/web"
        ErrorLog "logs/admin.yii2-members-system.dev-error_log"
        CustomLog "logs/admin.yii2-members-system.dev-access_log" common
    </VirtualHost>

[![Latest Stable Version](https://poser.pugx.org/wadeshuler/yii2-members-system/version?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
[![License](https://poser.pugx.org/wadeshuler/yii2-members-system/license?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
[![composer.lock available](https://poser.pugx.org/wadeshuler/yii2-members-system/composerlock?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
[![Build Status](https://travis-ci.org/WadeShuler/yii2-members-system.svg?branch=master)](https://travis-ci.org/WadeShuler/yii2-members-system)
