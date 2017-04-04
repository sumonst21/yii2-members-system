Contributing
------------

This project is for my own personal use. If what it delivers fits you, you are
more than welcome to use it. I want to make clear, that this isn't for everyone.

This project is a base line that I use for client projects. For any project that
requires a user/admin section, I want this to be my starting point for every
project. It does not need all the bells and whistles, but have the basic needs of
every project. So in order to add something new, it must be needed in majority of
new projects. I will not be adding a feature that only is needed in 1 out of 10
projects. I want this as a middle ground between the yii2 advanced template and
the final project. More than the yii2 advanced template provides, so I don't have
to do anything other than add custom features, theme, etc.

The intent is to have a separate user and admin section, similar to traditional
member systems. I typically have a sub-domain pointed to the `frontend` for
`users.mydomain.com` and a sub-domain pointed to the `backend` for `admin.mydomain.com`.
The `mainsite` section is for your main website (ie: www.mydomain.com). I left it the
stock Yii2 template because it is intended to be replaced completely by your own
custom homepage.

There are a few areas I would like for you to contribute if you want to:

- Expand, cleanup, make faster `Gruntfile.js`
- Fix, perfect, cleanup documentation
- Fix current errors/issues
- Finish anything listed as @todo (there are plugins to search a project for @todo tags)
- Write valid Codeception tests

I do not accept chincy hacks! It must be the most Yii way to handle the issue, or
I wont accept it. So be willing to have your code critiqued.

I am not open to dramatically changing the way things are done with this system. You
may create an issue to state your position/idea, but ultimately I have a vision for this
repo and may reject it if it doesn't fit what I am doing.
