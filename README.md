Yii2 Member's System
--------------------

My members system based on the Yii2 framework.

---

## WARNING ##
This project is not complete yet. It currently is for my own personal use.

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

### Installation

    composer create-project wadeshuler/yii2-members-system yii2-members-system

Once Composer has done it's thing, you need to run a few commands before you can play.

    npm install
    composer update
    grunt build
    ./init

[![Latest Stable Version](https://poser.pugx.org/wadeshuler/yii2-members-system/version?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
[![License](https://poser.pugx.org/wadeshuler/yii2-members-system/license?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
[![composer.lock available](https://poser.pugx.org/wadeshuler/yii2-members-system/composerlock?format=flat-square)](https://packagist.org/packages/wadeshuler/yii2-members-system)
